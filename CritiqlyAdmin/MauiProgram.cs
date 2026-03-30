using Microsoft.Extensions.Logging;
using Microsoft.Maui.LifecycleEvents;

namespace CritiqlyAdmin
{
    public static class MauiProgram
    {
        public static MauiApp CreateMauiApp()
        {
            var builder = MauiApp.CreateBuilder();

            builder.UseMauiApp<App>();

            builder.ConfigureLifecycleEvents(events =>
            {
#if WINDOWS
        events.AddWindows(w =>
        {
            w.OnWindowCreated(window =>
            {
                var hWnd = WinRT.Interop.WindowNative.GetWindowHandle(window);
                var windowId = Microsoft.UI.Win32Interop.GetWindowIdFromWindow(hWnd);
                var appWindow = Microsoft.UI.Windowing.AppWindow.GetFromWindowId(windowId);

                appWindow.Resize(new Windows.Graphics.SizeInt32(1200, 800));

                if (appWindow.Presenter is Microsoft.UI.Windowing.OverlappedPresenter presenter)
                {
                    presenter.IsResizable = false;
                    presenter.IsMaximizable = false;
                }
            });
        });
#endif
            });

            builder.ConfigureFonts(fonts =>
            {
                fonts.AddFont("OpenSans-Regular.ttf", "OpenSansRegular");
                fonts.AddFont("OpenSans-Semibold.ttf", "OpenSansSemibold");
                fonts.AddFont("KimberleyBL-Regular 900", "Kimberley");
            });

#if DEBUG
            builder.Logging.AddDebug();
#endif

            return builder.Build();
        }
    }
}
