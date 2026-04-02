using System.Text;
using System.Text.Json;
using CritiqlyAdmin.Models;
using Microsoft.Maui.Platform;
using Org.BouncyCastle.Asn1.Cms;

namespace CritiqlyAdmin;

public partial class UpdateMovieSubPage : ContentPage
{
    public UpdateMovieSubPage()
    {
        InitializeComponent();
    }

    protected override async void OnAppearing()
    {
        base.OnAppearing();

        LabelTitle.Text = AppData.updatePageSelectedMovie.title;
        LabelGenre.Text = AppData.updatePageSelectedMovie.genre;
        LabelPlot.Text = AppData.updatePageSelectedMovie.plot.Replace(".", "." + System.Environment.NewLine);
        LabelDate.Text = AppData.updatePageSelectedMovie.release_date.ToString();
        LabelPoster.Text = AppData.updatePageSelectedMovie.poster;

        EntryTitle.Text = "";
        EntryGenre.Text = "";
        EntryPlot.Text = "";
        EntryDate.Text = "";
        EntryPoster.Text = "";
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
            await Shell.Current.GoToAsync("//UpdatePage");
        }
        else
        {
            return;
        }
    }

    public async void Save(Object sender, EventArgs e)
    {
        var updatedMovie = AppData.updatePageSelectedMovie;

        updatedMovie.id = AppData.updatePageSelectedMovie.id;
        updatedMovie.tmdb_id = AppData.updatePageSelectedMovie.tmdb_id;
        updatedMovie.title = string.IsNullOrWhiteSpace(EntryTitle.Text) ? AppData.updatePageSelectedMovie.title : EntryTitle.Text;
        updatedMovie.genre = string.IsNullOrWhiteSpace(EntryGenre.Text) ? AppData.updatePageSelectedMovie.genre : EntryGenre.Text;
        updatedMovie.plot = string.IsNullOrWhiteSpace(EntryPlot.Text) ? AppData.updatePageSelectedMovie.plot : EntryPlot.Text;
        updatedMovie.release_date = string.IsNullOrWhiteSpace(EntryDate.Text) ? AppData.updatePageSelectedMovie.release_date : DateTime.Parse(EntryDate.Text);
        updatedMovie.poster = string.IsNullOrWhiteSpace(EntryPoster.Text) ? AppData.updatePageSelectedMovie.poster : EntryPoster.Text;

        await Shell.Current.GoToAsync("//UpdatePage");
    }
}