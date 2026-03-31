using Microsoft.Extensions.DependencyInjection;

namespace CritiqlyAdmin
{
    public partial class App : Application
    {
        public App()
        {
            InitializeComponent();
            MainPage = new AppShell();
        }
    }
}