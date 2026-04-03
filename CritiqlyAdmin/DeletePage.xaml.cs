using System.Collections.ObjectModel;
using System.Net.Http;
using System.Net.Http;
using System.Text;
using System.Text.Json;
using System.Threading.Tasks;
using CritiqlyAdmin.Models;
using Microsoft.Maui.Controls.Shapes;
using MySql.Data.MySqlClient;

namespace CritiqlyAdmin;

public partial class DeletePage : ContentPage
{
    public ObservableCollection<Movie> QueryMovies { get; set; } = new ObservableCollection<Movie>();
    List<Movie> DeletedMovies = new List<Movie>();
    public DeletePage()
    {
        InitializeComponent();
        BindingContext = this;
    }
    protected override async void OnAppearing()
    {
        base.OnAppearing();

        EntryQuery.Text = "";
        StatusLabel.Text = "Kérlek válaszd ki a törölni kívánt filmet!";

        QueryMovies.Clear();

        SearchQuery(this, EventArgs.Empty);
    }

    public async void SearchQuery(Object sender, EventArgs e)
    {
        searchQueryBtn.BackgroundColor = Colors.Orange;
        QueryMovies.Clear();
        foreach (var movie in AppData.Movies)
        {
            if (movie.title.ToLower().Contains(EntryQuery.Text.ToLower()))
            {
                QueryMovies.Add(movie);
            }
        }
        await Task.Delay(1000);
        searchQueryBtn.BackgroundColor = Color.FromRgb(212, 255, 62);
    }
    public async void deleteMovie(Object sender, EventArgs e)
    {
        var Button = sender as Button;
        var id = Button?.CommandParameter;

        if (DeletedMovies.Contains(AppData.Movies.First(x => x.id == (Int32)id)))
        {
            Movie sel = DeletedMovies.First(x => x.id == (Int32)id);
            DeletedMovies.Remove(sel);
            sel.IsDeleted = false;
            checkDeleted(this, EventArgs.Empty);
        }
        else
        {
            Button.BackgroundColor = Colors.Orange;
            Movie del = AppData.Movies.First(x => x.id == (Int32)id);
            del.IsDeleted = true;
            DeletedMovies.Add(del);
            await Task.Delay(500);
            Button.BackgroundColor = Color.FromRgb(212, 255, 62);
            SearchQuery(this, EventArgs.Empty);
        }
    }

    public async void checkDeleted(Object sender, EventArgs e)
    {
        QueryMovies.Clear();
        checkDeletedBtn.BackgroundColor = Colors.Orange;

        foreach (var movie in DeletedMovies)
        {
            await DisplayAlertAsync("DEBUG", movie.title + ": " + movie.IsDeleted, "OK");
            QueryMovies.Add(movie);
        }
        await Task.Delay(500);
        checkDeletedBtn.BackgroundColor = Color.FromRgb(212, 255, 62);
    }

    public async void Exit(Object sender, EventArgs e)
    {
        var isResponseOk = await DisplayAlertAsync(
            "Kilépés",
            "Biztosan ki akarsz lépni? Az eddigi változtatások elvesznek!",
            "Igen",
            "Mégse"
        );

        if (isResponseOk)
        {
            await Shell.Current.GoToAsync("//MainPage");
        }
        else
        {
            return;
        }
    }

    public async void Save(Object sender, EventArgs e)
    {
        bool islastRequestSuccessful = true;
        if (DeletedMovies.Count > 0)
        {
            HttpClient client = new HttpClient();

            foreach (var movie in DeletedMovies)
            {
                var data = new
                {
                    tmdb_id = movie.tmdb_id,
                    title = movie.title,
                    genre = movie.genre,
                    plot = movie.plot,
                    releaseDate = movie.releaseDate?.ToString("yyyy-MM-dd"),
                    poster = movie.poster,
                    deleted_at = DateTime.Now
                };

                var json = JsonSerializer.Serialize(data);
                var httpData = new StringContent(json, Encoding.UTF8, "application/json");

                var response = await client.PutAsync($"http://localhost:8000/api/movies/{movie.id}", httpData);
                var responseText = await response.Content.ReadAsStringAsync();

                /*await DisplayAlertAsync("DEBUG",
                $"{response.StatusCode}\n{responseText}",
                "OK");*/

                if (response.IsSuccessStatusCode)
                {
                    islastRequestSuccessful = true;
                }
                else
                {
                    await DisplayAlertAsync("Hiba", "A mentés nem sikerült! \n" +
                        $"A hiba ezzel történt:  {movie.title} + \n" +
                        "Próbáld újra!", "OK");
                    islastRequestSuccessful = false;
                }
            }

            if (islastRequestSuccessful)
            {
                await Shell.Current.GoToAsync("//MainPage");
                DeletedMovies.Clear();
                AppData.updatePageSelectedMovie = null;
            }
        }
        else
        {
            await DisplayAlertAsync("HIBA", "A feltölteni kívánt filmek száma nem elegendő!", "OK");
        }
    }
}