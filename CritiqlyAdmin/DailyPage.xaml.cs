using System.Collections.ObjectModel;
using System.Net.Http;
using System.Net.Http;
using System.Security.Policy;
using System.Text;
using System.Text.Json;
using System.Threading.Tasks;
using CritiqlyAdmin.Models;
using Microsoft.Maui.Controls.Shapes;
using MySql.Data.MySqlClient;
using Org.BouncyCastle.Bcpg;

namespace CritiqlyAdmin;

public partial class DailyPage : ContentPage
{
    public ObservableCollection<Movie> QueryMovies { get; set; } = new ObservableCollection<Movie>();
    public List<DailyMovie> DailyMovies = new List<DailyMovie>();
    public List<int> CurrentDayIds = new();

    public DailyPage()
    {
        InitializeComponent();
        BindingContext = this;
    }
    protected override void OnAppearing()
    {
        base.OnAppearing();

        EntryQuery.Text = "";
        StatusLabel.Text = "Utolsó frissítés: " + AppData.DailyLastUpdate?.ToString("yyyy.MM.dd HH:mm") ?? "N/I";

        CurrentDayIds.Clear();
        QueryMovies.Clear();

        DateTime min = DateTime.Today;
        dateSelector.Date = min.Date;
        dateSelector.MinimumDate = new DateTime(min.Year, min.Month, min.Day);
        dateSelector.MaximumDate = new DateTime(min.Year + 1, min.Month, min.Day);

        getDailys();
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

    public async void RollRandom(Object sender, EventArgs e)
    {
        rollRandomBtn.BackgroundColor = Colors.Orange;
        int count = CurrentDayIds.Count;
        int currentNum = 0;
        if(count != 15)
        {
            currentNum = 15 - count;

            Random rnd = new Random();
            for (int i = 0; i < currentNum; i++)
            {
                CurrentDayIds.Add(rnd.Next(1, (AppData.Movies.Count + 1)));
                await Task.Delay(500);
                rollRandomBtn.BackgroundColor = Color.FromRgb(212, 255, 62);
            }
        }
        else
        {
            await DisplayAlertAsync("INFO", "Elérted a maximálisan hozzáadható filmek számát!", "OK");
        }
    }

    public async void AddToDailyList(Object sender, EventArgs e)
    {
        var Button = sender as Button;
        var id = Button?.CommandParameter;
        
        if (CurrentDayIds.Count != 15 && !CurrentDayIds.Contains((Int32)id))
        {
            Button.BackgroundColor = Colors.Orange;
            CurrentDayIds.Add((Int32)id);
            await Task.Delay(500);
            Button.BackgroundColor = Color.FromRgb(212, 255, 62);
        }
        else if (CurrentDayIds.Contains((Int32)id))
        {
            Button.BackgroundColor = Colors.Red;
            CurrentDayIds.Remove((Int32)id);
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

        foreach(var movie in AppData.Movies)
        {
            if (CurrentDayIds.Contains(movie.id))
            {
                QueryMovies.Add(movie);
            }
        }
        await Task.Delay(500);
        checkSelectedBtn.BackgroundColor = Color.FromRgb(212, 255, 62);
    }

    public async void getDailys()
    {
        DailyMovies.Clear();
        var client = new HttpClient();

        var response = await client.GetAsync("http://localhost:8000/api/get-daily");

        if (!response.IsSuccessStatusCode)
            throw new Exception("API error");

        var json = await response.Content.ReadAsStringAsync();

        var result = JsonSerializer.Deserialize<List<DailyMovie>>(json, new JsonSerializerOptions
        {
            PropertyNameCaseInsensitive = true
        });

        foreach (var dailymovie in result)
        {
            DailyMovies.Add(dailymovie);
        }
    }

    public async void LoadDailys(object sender, DateChangedEventArgs e)
    {
        CurrentDayIds.Clear();
        foreach (var daily in DailyMovies)
        {
            if (daily.date?.Date == dateSelector.Date?.Date)
            {
                CurrentDayIds.Add(daily.movie_id);
            }
        }
        checkSelected(this, EventArgs.Empty);
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
        if (CurrentDayIds.Count > 2)
        {
            var client = new HttpClient();

            var dailyData = new
            {
                movies = CurrentDayIds.ToArray(),
                date = dateSelector.Date
            };
            var dailyJson = JsonSerializer.Serialize(dailyData);
            var httpDailyData = new StringContent(dailyJson, Encoding.UTF8, "application/json");

            var responseDaily = await client.PostAsync("http://localhost:8000/api/daily-movies", httpDailyData);

            var dateData = new
            {
                daily = DateTime.Now.ToString("yyyy-MM-ddTHH:mm:sszzz"),
                trending = AppData.TrendingLastUpdate.Value.ToString("yyyy-MM-ddTHH:mm:sszzz")
            };
            var dateJson = JsonSerializer.Serialize(dateData);
            var httpDateDate = new StringContent(dateJson, Encoding.UTF8, "application/json");
            //await DisplayAlertAsync("json", json, "OK");
            var responseDate = await client.PostAsync("http://localhost:8000/api/admin/update", httpDateDate);

            if (responseDate.IsSuccessStatusCode && responseDaily.IsSuccessStatusCode)
            {
                //await Shell.Current.GoToAsync($"//MainPage");
                await DisplayAlertAsync("INFO", "A mentés sikeres!", "OK");
                getDailys();
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