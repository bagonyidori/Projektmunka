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
        public MainPage()
        {
            InitializeComponent();
            BindingContext = this;

        }


        //var users = await GetAsync<User>("http://10.0.2.2:8000/api/users");
        //var reviews = await GetAsync<Review>("http://10.0.2.2:8000/api/reviews");

        public async void GetMovies(object sender, EventArgs e)
        {
            var movies = await GetAsync<Movie>("http://127.0.0.1:8000/api/movies");

            Movies.Clear();
            getMoviesBtn.BackgroundColor = Colors.DarkGreen;
            //getMoviesBtn.TextColor = Colors.Black;

            foreach (var movie in movies)
            {
                Movies.Add(movie);
            }
        }

        public async void GetRatings(object sender, EventArgs e)
        {
            var ratings = await GetAsync<Rating>("http://127.0.0.1:8000/api/ratings");

            Ratings.Clear();
            getRatingsBtn.BackgroundColor = Colors.DarkGreen;
            //getRatingsBtn.TextColor = Colors.Black;

            foreach (var rating in ratings)
            {
                Ratings.Add(rating);
            }
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

        public async void TestDailyMovies(object sender, EventArgs e)
        {
            if(Movies.Count == 0)
            {
                await DisplayAlertAsync("Hiba", "Előbb töltsd be az adatokat!", "OK");
                return;
            }
            else
            {
                var client = new HttpClient();

                int[] newDailys = new int[4];
                Random rnd = new Random();
                for (int i = 0; i < 4; i++)
                {
                    newDailys[i] = rnd.Next(1, (Movies.Count + 1));
                }

                var data = new
                {
                    movies = newDailys
                };

                var json = JsonSerializer.Serialize(data);
                var httpData = new StringContent(json, Encoding.UTF8, "application/json");

                var response = await client.PostAsync("http://localhost:8000/api/daily-movies", httpData);
                var responseBody = await response.Content.ReadAsStringAsync();
                //await DisplayAlertAsync("Alert", response.ToString(), "OK");

                //TODO: Try-Catch, error handling
            }
        }

        public async void GetTrendingMovies(object sender, EventArgs e)
        {
            if (Movies.Count == 0 || Ratings.Count == 0)
            {
                await DisplayAlertAsync("Hiba", "Előbb töltsd be az adatokat!", "OK");
                return;
            }
            else
            {
                var client = new HttpClient();

                Dictionary<int, int> trendingMovies = new Dictionary<int, int>();

                foreach (var movie in Movies)
                {
                    foreach (var rating in Ratings)
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

                var data = new
                {
                    movies = top4
                };

                var json = JsonSerializer.Serialize(data);
                var httpData = new StringContent(json, Encoding.UTF8, "application/json");
                await DisplayAlertAsync("Alert", json, "OK");

                var response = await client.PostAsync("http://localhost:8000/api/trending-movies", httpData);
                var responseBody = await response.Content.ReadAsStringAsync();
                //await DisplayAlertAsync("Alert", response.ToString(), "OK");

                //TODO: Try-Catch, error handling
            }
        }
    }
}
