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

            foreach (var movie in movies)
            {
                Movies.Add(movie);
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
            var client = new HttpClient();

            int[] newDailys = new int[4];
            Random rnd = new Random();
            for (int i = 0; i < 4; i++)
            {
                newDailys[i]= rnd.Next(1, 450);
            }

            var data = new
            {
                movies = newDailys
            };

            var json = JsonSerializer.Serialize(data);
            var httpData = new StringContent(json, Encoding.UTF8, "application/json");

            var response = await client.PostAsync("http://localhost:8000/api/daily-movies", httpData);
            var responseBody = await response.Content.ReadAsStringAsync();
        }
    }
}
