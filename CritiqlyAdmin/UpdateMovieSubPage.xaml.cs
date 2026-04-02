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
        LabelPlot.Text = AppData.updatePageSelectedMovie.plot;
        LabelDate.Text = AppData.updatePageSelectedMovie.release_date.ToString();
        LabelPoster.Text = AppData.updatePageSelectedMovie.poster;
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
        Movie updatedMovie = new Movie
        {
            id = AppData.updatePageSelectedMovie.id,
            tmdb_id = AppData.updatePageSelectedMovie.tmdb_id,
            title = string.IsNullOrWhiteSpace(EntryTitle.Text) ? AppData.updatePageSelectedMovie.title : EntryTitle.Text,
            genre = string.IsNullOrWhiteSpace(EntryGenre.Text) ? AppData.updatePageSelectedMovie.genre : EntryGenre.Text,
            plot = string.IsNullOrWhiteSpace(EntryPlot.Text) ? AppData.updatePageSelectedMovie.plot : EntryPlot.Text,
            release_date = string.IsNullOrWhiteSpace(EntryDate.Text) ? AppData.updatePageSelectedMovie.release_date : DateTime.Parse(EntryDate.Text),
            poster = string.IsNullOrWhiteSpace(EntryPoster.Text) ? AppData.updatePageSelectedMovie.poster : EntryPoster.Text,
        };

        AppData.updatePageSelectedMovie = updatedMovie;

        await Shell.Current.GoToAsync("//UpdatePage");
    }
}