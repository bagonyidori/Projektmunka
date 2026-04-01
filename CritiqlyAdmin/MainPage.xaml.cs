using System.Collections.ObjectModel;
using System.Net.Http;
using System.Net.Http;
using System.Text;
using System.Text.Json;
using System.Threading.Tasks;
using CritiqlyAdmin.Models;
using Microsoft.Maui.Controls.Shapes;
using MySql.Data.MySqlClient;

namespace CritiqlyAdmin
{
    public partial class MainPage : ContentPage
    {
        public ObservableCollection<Movie> Movies { get; set; } = new();
        public ObservableCollection<Rating> Ratings { get; set; } = new();
        public ObservableCollection<Rating> relevantData { get; set; } = new();
        public MainPage()
        {
            InitializeComponent();
            BindingContext = this;
        }

        protected override void OnAppearing()
        {
            base.OnAppearing();

            welcomeLabel.Text = "Üdv újra, " + AppData.Username +"!";
            LoadAppData();
        }


        //var users = await GetAsync<User>("http://10.0.2.2:8000/api/users");
        //var reviews = await GetAsync<Review>("http://10.0.2.2:8000/api/reviews");

        public async void GetMovies(object sender, EventArgs e)
        {
            var movies = await GetAsync<Movie>("http://127.0.0.1:8000/api/movies");

            Movies.Clear();

            foreach (var movie in movies)
            {
                Movies.Add(movie);
            }
            AppData.Movies = Movies.ToList();
            fireUp();
            getMoviesBtn.BackgroundColor = Colors.DarkGreen;
            getMoviesBtn.Text = "FILMEK ✓";
            //getMoviesBtn.TextColor = Colors.Black;
        }

        public async void GetRatings(object sender, EventArgs e)
        {
            var ratings = await GetAsync<Rating>("http://127.0.0.1:8000/api/ratings");

            Ratings.Clear();

            foreach (var rating in ratings)
            {
                Ratings.Add(rating);
            }
            AppData.Ratings = Ratings.ToList();
            fireUp();
            getRatingsBtn.Text = "ÉRTÉKELÉSEK ✓";
            getRatingsBtn.BackgroundColor = Colors.DarkGreen;
            //getRatingsBtn.TextColor = Colors.Black;
        }

        public async void LoadAppData()
        {
            var client = new HttpClient();
            var data = await client.GetAsync("http://127.0.0.1:8000/api/admin/get");
            var json = await data.Content.ReadAsStringAsync();

            var result = JsonSerializer.Deserialize<List<AdminData>>(json, new JsonSerializerOptions
            {
                PropertyNameCaseInsensitive = true
            });

            //await DisplayAlertAsync("Alert", result[0].DailyLastUpdate.ToString(), "OK");
            //await DisplayAlertAsync("Alert", result[0].TrendingLastUpdate.ToString(), "OK");

            AppData.DailyLastUpdate = result[0].DailyLastUpdate;
            AppData.TrendingLastUpdate = result[0].TrendingLastUpdate;
        }

        public async Task<List<T>> GetAsync<T>(string url)
        {
            var client = new HttpClient();

            var response = await client.GetAsync(url);

            if (!response.IsSuccessStatusCode)
                throw new Exception("API error");

            var json = await response.Content.ReadAsStringAsync();

            var result = JsonSerializer.Deserialize<List<T>>(json, new JsonSerializerOptions
            {
                PropertyNameCaseInsensitive = true
            });

            if (result == null)
                throw new Exception("Deserialization failed");

            return result;
        }

        public async void SelectDailyMovies(object sender, EventArgs e)
        {
            await Shell.Current.GoToAsync("//DailyPage");
        }

        public async void EditTrendingMovies(object sender, EventArgs e)
        {
            await Shell.Current.GoToAsync("//TrendingPage");
        }

        public async void UpdateMovies(object sender, EventArgs e)
        {
            await Shell.Current.GoToAsync("//UpdatePage");
        }

        public async void DeleteMovies(object sender, EventArgs e)
        {
            await Shell.Current.GoToAsync("//DeletePage");
        }

        public void fireUp()
        {
            if(Movies.Count > 0 && Ratings.Count > 0)
            {
                selectDailyBtn.IsEnabled = true;
                updateTrendingBtn.IsEnabled = true;
                updateMoviesBtn.IsEnabled = true;
                deleteMoviesBtn.IsEnabled = true;
                selectDailyBtn.Opacity = 1;
                updateTrendingBtn.Opacity = 1;
                updateMoviesBtn.Opacity = 1;
                deleteMoviesBtn.Opacity = 1;
                selectDailyBtn.BackgroundColor = Color.FromRgb(212, 255, 62);
                updateTrendingBtn.BackgroundColor = Color.FromRgb(212, 255, 62);
                updateMoviesBtn.BackgroundColor = Color.FromRgb(212, 255, 62);
                deleteMoviesBtn.BackgroundColor = Color.FromRgb(212, 255, 62);

                getMoviesBtn.IsEnabled = false;
                getRatingsBtn.IsEnabled = false;
            }
        }

        public async void LogOut(Object sender, EventArgs e)
        {
            await Shell.Current.GoToAsync("//LoginPage");
        }
    }
}
