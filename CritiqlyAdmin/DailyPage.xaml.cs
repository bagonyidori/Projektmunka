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
    public DailyPage()
    {
        InitializeComponent();
        BindingContext = this;
    }
    protected override void OnAppearing()
    {
        base.OnAppearing();

        StatusLabel.Text = "Utolsó frissítés: " + AppData.DailyLastUpdate?.ToString("yyyy.MM.dd HH:mm") ?? "N/I";
    }

    public async void Save(Object sender, EventArgs e)
    {
        AppData.DailyLastUpdate = DateTime.Now;

        await Shell.Current.GoToAsync($"//MainPage");
    }
}