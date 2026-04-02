using System.Collections.ObjectModel;
using System.Net.Http;
using System.Net.Http;
using System.Net.Http.Json;
using System.Text;
using System.Text.Json;
using System.Threading.Tasks;
using CritiqlyAdmin.Models;
using Microsoft.Maui.Controls.Shapes;
using MySql.Data.MySqlClient;
using Microsoft.Maui.Controls;

namespace CritiqlyAdmin;

public partial class UpdatePage : ContentPage
{
    public ObservableCollection<Movie> QueryMovies { get; set; } = new ObservableCollection<Movie>();
    public int selectedId;
    List<Movie> UpdatedMovies = new List<Movie>();
    public UpdatePage()
    {
        InitializeComponent();
        BindingContext = this;
    }
    protected override async void OnAppearing()
    {
        base.OnAppearing();

        EntryQuery.Text = "";
        StatusLabel.Text = "Kérlek válaszd ki a szerkeszteni kívánt filmet!";

        QueryMovies.Clear();
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
    public async void editMovie(Object sender, EventArgs e)
    {
        selectedId = 0;
        var Button = sender as Button;
        var id = Button?.CommandParameter;
        AppData.updatePageSelectedMovie = AppData.Movies.First(x => x.id == (Int32)id);

        if(UpdatedMovies.Contains(AppData.Movies.First(x => x.id == (Int32)id)))
        {
            Movie sel = UpdatedMovies.First(x => x.id == (Int32)id); 
            UpdatedMovies.Remove(sel);
            sel.IsUpdated = false;
            checkUpdated(this, EventArgs.Empty);
        }
        else
        {
            Button.BackgroundColor = Colors.Orange;
            await Task.Delay(500);
            await Shell.Current.GoToAsync("//UpdateSubPage");
            UpdatedMovies.Add(AppData.updatePageSelectedMovie);
            Button.BackgroundColor = Color.FromRgb(212, 255, 62);
        }
    }

    public async void checkUpdated(Object sender, EventArgs e)
    {
        QueryMovies.Clear();
        checkUpdatedBtn.BackgroundColor = Colors.Orange;

        foreach (var movie in UpdatedMovies)
        {
            QueryMovies.Add(movie);
        }
        await Task.Delay(500);
        checkUpdatedBtn.BackgroundColor = Color.FromRgb(212, 255, 62);
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
        if (UpdatedMovies.Count > 0) 
        {
            HttpClient client = new HttpClient();

            foreach (var movie in UpdatedMovies)
            {
                var data = new
                {
                    tmdb_id = movie.tmdb_id,
                    title = movie.title,
                    genre = movie.genre,
                    plot = movie.plot,
                    releaseDate = movie.releaseDate?.ToString("yyyy-MM-dd"),
                    poster = movie.poster
                };

                var json = JsonSerializer.Serialize(data);
                var httpData = new StringContent(json, Encoding.UTF8, "application/json");

                var response = await client.PutAsync($"http://localhost:8000/api/movies/{movie.id}", httpData);
                var responseText = await response.Content.ReadAsStringAsync();

                /*await DisplayAlertAsync("DEBUG",
                $"{response.StatusCode}\n{responseText}",
                "OK");*/

                var existing = AppData.Movies.FirstOrDefault(x => x.id == movie.id);

                if (existing != null)
                {
                    existing.title = movie.title;
                    existing.genre = movie.genre;
                    existing.plot = movie.plot;
                    existing.releaseDate = movie.releaseDate;
                    existing.poster = movie.poster;
                }

                if (response.IsSuccessStatusCode)
                {
                    islastRequestSuccessful = true;
                }
                else
                {
                    await DisplayAlertAsync("Hiba", "A mentés nem sikerült! \n" +
                        $"A hiba ezzel történt: {movie.title} \n" +
                        "Próbáld újra!", "OK");
                    islastRequestSuccessful = false;
                }
            }

            if (islastRequestSuccessful)
            {
                await Shell.Current.GoToAsync("//MainPage");
                UpdatedMovies.Clear();
                AppData.updatePageSelectedMovie = null;
            }
        }
        else
        {
            await DisplayAlertAsync("HIBA", "A feltölteni kívánt filmek száma nem elegendő!", "OK");
        }
    }
}