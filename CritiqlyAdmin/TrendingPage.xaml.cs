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

public partial class TrendingPage : ContentPage
{
    public ObservableCollection<Movie> QueryMovies { get; set; } = new ObservableCollection<Movie>();

    public List<int> SelectedIds = new List<int>();
    public TrendingPage()
    {
        InitializeComponent();
        BindingContext = this;
    }
    protected override void OnAppearing()
    {
        base.OnAppearing();

        EntryQuery.Text = "";
        StatusLabel.Text = "Utolsó frissítés: " + AppData.TrendingLastUpdate?.ToString("yyyy.MM.dd HH:mm") ?? "N/I";

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

    public async void autoSelect(Object sender, EventArgs e)
    {
        Dictionary<int, int> trendingMovies = new Dictionary<int, int>();

        foreach (var movie in AppData.Movies)
        {
            foreach (var rating in AppData.Ratings)
            {
                if (rating.movie_id == movie.id && !trendingMovies.ContainsKey(movie.id))
                {
                    //await DisplayAlertAsync("Alert", "Találtam mId + rId -> Nem volt még listában", "OK");
                    trendingMovies.Add(movie.id, rating.stars);
                }
                else if (rating.movie_id == movie.id && trendingMovies.ContainsKey(movie.id))
                {
                    //await DisplayAlertAsync("Alert", "Találtam mId + rId ->  Volt már listában", "OK");
                    trendingMovies[movie.id] += rating.stars;
                }
            }
        }

        int[] top4 = trendingMovies.OrderByDescending(x => x.Value).Take(4).Select(x => x.Key).ToArray();

        for (int i = 0; i < top4.Length; i++)
        {
            SelectedIds.Add(top4[i]);
        }

        checkSelected(this, EventArgs.Empty);
    }
    public async void AddToTrendingList(Object sender, EventArgs e)
    {
        var Button = sender as Button;
        var id = Button?.CommandParameter;

        if (SelectedIds.Count != 4 && !SelectedIds.Contains((Int32)id))
        {
            Button.BackgroundColor = Colors.Orange;
            SelectedIds.Add((Int32)id);
            await Task.Delay(500);
            Button.BackgroundColor = Color.FromRgb(212, 255, 62);
        }
        else if (SelectedIds.Contains((Int32)id))
        {
            Button.BackgroundColor = Colors.Red;
            SelectedIds.Remove((Int32)id);
            await Task.Delay(500);
            Button.BackgroundColor = Color.FromRgb(212, 255, 62);
            checkSelected(this, EventArgs.Empty);
        }
        else
        {
            await DisplayAlertAsync("INFO", "Elérted a maximálisan hozzáadható filmek számát!", "OK");
        }
    }

    public async void checkSelected(Object sender, EventArgs e)
    {
        QueryMovies.Clear();
        checkSelectedBtn.BackgroundColor = Colors.Orange;

        foreach (var movie in AppData.Movies)
        {
            if (SelectedIds.Contains(movie.id))
            {
                QueryMovies.Add(movie);
            }
        }
        await Task.Delay(500);
        checkSelectedBtn.BackgroundColor = Color.FromRgb(212, 255, 62);
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