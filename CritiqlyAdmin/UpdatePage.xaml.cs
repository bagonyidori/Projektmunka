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

    public List<int> SelectedIds = new List<int>();
    public UpdatePage()
    {
        InitializeComponent();
        BindingContext = this;
    }
    protected override void OnAppearing()
    {
        base.OnAppearing();

        EntryQuery.Text = "";
        StatusLabel.Text = "Kérlek válaszd ki a szerkeszteni kívánt filmet!";

        SelectedIds.Clear();
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
        var Button = sender as Button;
        var id = Button?.CommandParameter;
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
        if (SelectedIds.Count > 2)
        {
            var client = new HttpClient();

            var trendingData = new
            {
                movies = SelectedIds.ToArray(),
            };
            var trendingJson = JsonSerializer.Serialize(trendingData);
            var httpTrendingData = new StringContent(trendingJson, Encoding.UTF8, "application/json");

            var responseDaily = await client.PostAsync("http://localhost:8000/api/trending-movies", httpTrendingData);

            var dateData = new
            {
                daily = AppData.DailyLastUpdate.Value.ToString("yyyy-MM-ddTHH:mm:sszzz"),
                trending = DateTime.Now.ToString("yyyy-MM-ddTHH:mm:sszzz")
            };
            var dateJson = JsonSerializer.Serialize(dateData);
            var httpDateDate = new StringContent(dateJson, Encoding.UTF8, "application/json");
            //await DisplayAlertAsync("json", json, "OK");
            var responseDate = await client.PostAsync("http://localhost:8000/api/admin/update", httpDateDate);

            if (responseDate.IsSuccessStatusCode && responseDaily.IsSuccessStatusCode)
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