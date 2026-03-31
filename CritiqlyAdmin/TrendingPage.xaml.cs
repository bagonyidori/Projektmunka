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
        AppData.TrendingLastUpdate = DateTime.Now;

        await Shell.Current.GoToAsync($"//MainPage");
    }
}