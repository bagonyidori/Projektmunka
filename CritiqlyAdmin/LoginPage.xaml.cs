using System.Text;
using System.Text.Json;
using CritiqlyAdmin.Models;

namespace CritiqlyAdmin;

public partial class LoginPage : ContentPage
{
    List<User> Users = new List<User>();
    public LoginPage()
	{
		InitializeComponent();
    }

    public async void TryLogin(object sender, EventArgs e)
	{
        var client = new HttpClient();

        var data = new
        {
            username = EntryUsername.Text,
            password = EntryPassword.Text
        };

        var json = JsonSerializer.Serialize(data);

        var content = new StringContent(json, Encoding.UTF8, "application/json");

        var response = await client.PostAsync("http://localhost:8000/api/admin/login", content);

        if (!response.IsSuccessStatusCode)
        {
            await DisplayAlertAsync("SIKERTELEN BELÉPÉS", "Kérlek próbáld meg újra!", "OK");
            return;
        }

        var responseJson = await response.Content.ReadAsStringAsync();

        var user = JsonSerializer.Deserialize<User>(responseJson);

        if (user.Is_Admin)
        {
            LoginBtn.Text = "SIKERES BELÉPÉS";
            await Task.Delay(1000);
            //await DisplayAlertAsync("Alert", "belépett", "OK");
            await Shell.Current.GoToAsync("//MainPage");
        }
    }
}