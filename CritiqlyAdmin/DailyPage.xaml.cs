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

public partial class DailyPage : ContentPage
{
    public ObservableCollection<Movie> QueryMovies { get; set; } = new ObservableCollection<Movie>();

    public List<int> SelectedIds = new List<int>();

    public DailyPage()
    {
        InitializeComponent();
        BindingContext = this;
    }
    protected override void OnAppearing()
    {
        base.OnAppearing();

        StatusLabel.Text = "Utolsó frissítés: " + AppData.DailyLastUpdate?.ToString("yyyy.MM.dd HH:mm") ?? "N/I";

        SelectedIds.Clear();
        QueryMovies.Clear();
    }

    public void SearchQuery(Object sender, EventArgs e)
    {
        QueryMovies.Clear();
        foreach (var movie in AppData.Movies)
        {
            if (movie.title.Contains(EntryQuery.Text))
            {
                QueryMovies.Add(movie);
            }
        }
    }

    public void RollRandom(Object sender, EventArgs e)
    {
        int count = SelectedIds.Count;
        int currentNum = 0;
        if(count != 4)
        {
            currentNum = 4 - count;
        }

        Random rnd = new Random();
        for (int i = 0; i < currentNum; i++)
        {
            SelectedIds.Add(rnd.Next(1, (AppData.Movies.Count + 1)));
        }
    }

    public async void AddToDailyList(Object sender, EventArgs e)
    {
        var Button = sender as Button;
        var id = Button?.CommandParameter;

        Button.BackgroundColor = Colors.Orange;
        await Task.Delay(3000);
        Button.BackgroundColor = Color.FromRgb(212, 255, 62);
        
        if (SelectedIds.Count != 4)
        {
            SelectedIds.Add((Int32)id);
        }
        else
        {
            await DisplayAlertAsync("INFO", "Elérted a maximálisan hozzáadható filmek számát!", "OK");
        }
    }

    public async void Save(Object sender, EventArgs e)
    {
        var client = new HttpClient();

        var dailyData = new
        {
            movies = SelectedIds.ToArray(),
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
            await Shell.Current.GoToAsync($"//MainPage");
        }
        else
        {
            await DisplayAlertAsync("Hiba", "A mentés nem sikerült! \n Próbáld újra!", "OK");
        }
    }
}