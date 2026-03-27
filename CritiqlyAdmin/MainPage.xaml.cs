using System.Net.Http;
using System.Net.Http;
using System.Text.Json;
using System.Threading.Tasks;
using CritiqlyAdmin.Models;
using Microsoft.Maui.Controls.Shapes;
using MySql.Data.MySqlClient;

namespace CritiqlyAdmin
{
    public partial class MainPage : ContentPage
    {
        public MainPage()
        {
            InitializeComponent();
        }

        //var movies = await GetAsync<Movie>("http://10.0.2.2:8000/api/movies");
        //var users = await GetAsync<User>("http://10.0.2.2:8000/api/users");
        //var reviews = await GetAsync<Review>("http://10.0.2.2:8000/api/reviews");

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
    }
}
