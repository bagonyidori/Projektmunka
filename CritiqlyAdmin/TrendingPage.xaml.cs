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
    public TrendingPage()
    {
        InitializeComponent();
        BindingContext = this;
    }
    protected override void OnAppearing()
    {
        base.OnAppearing();

        StatusLabel.Text = AppData.TrendingLastUpdate?.ToString("yyyy.MM.dd HH:mm") ?? "N/I";
    }

    public async void Save(Object sender, EventArgs e)
    {
        var client = new HttpClient();
        var data = new
        {
            daily = AppData.DailyLastUpdate.Value.ToString("yyyy-MM-ddTHH:mm:sszzz"),
            trending = DateTime.Now.ToString("yyyy-MM-ddTHH:mm:sszzz")
        };

        var json = JsonSerializer.Serialize(data);
        var httpData = new StringContent(json, Encoding.UTF8, "application/json");
        //await DisplayAlertAsync("json", json, "OK");
        var response = await client.PostAsync("http://localhost:8000/api/admin/update", httpData);

        if (response.IsSuccessStatusCode)
        {
            await Shell.Current.GoToAsync($"//MainPage");
        }
        else
        {
            await DisplayAlertAsync("Hiba", "A mentés nem sikerült! \n Próbáld újra!", "OK");
        }
    }
}