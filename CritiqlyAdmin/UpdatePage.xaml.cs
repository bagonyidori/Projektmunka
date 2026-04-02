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

        if (AppData.updatePageSelectedMovie != null)
        {
            UpdatedMovies.Add(AppData.updatePageSelectedMovie);
            UpdatedMovies.Clear();
        }
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

        Button.BackgroundColor = Colors.Orange;
        await Task.Delay(500);
        await Shell.Current.GoToAsync("//UpdateMovieSubPage");
        Button.BackgroundColor = Color.FromRgb(212, 255, 62);
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
        if (selectedId > 0) 
        {
            Movie sel = AppData.updatePageSelectedMovie;
            var data = new
            {
                id = selectedId,
                tmdb_id = sel.tmdb_id,
                title = sel.tmdb_id,
                genre = sel.genre,
                plot = sel.plot,
                releaseDate = sel.release_date,
                poster = sel.poster
            };

            HttpClient client = new HttpClient();
            var json = JsonSerializer.Serialize(data);
            var httpData = new StringContent(json, Encoding.UTF8, "application/json");

            var response = await client.PostAsync($"http://localhost:8000/api/movies/{selectedId}", httpData);

            if (response.IsSuccessStatusCode)
            {
                await Shell.Current.GoToAsync($"//MainPage");
            }
            else
            {
                await DisplayAlertAsync("Hiba", "A mentés nem sikerült! \n Próbáld újra!", "OK");
            }
        }
        else
        {
            await DisplayAlertAsync("HIBA", "A feltölteni kívánt filmek száma nem elegendő!", "OK");
        }
    }
}