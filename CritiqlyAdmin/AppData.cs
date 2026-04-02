using System;
using System.Collections.Generic;
using System.Text;
using CritiqlyAdmin.Models;

namespace CritiqlyAdmin
{
    public static class AppData
    {
        public static List<Movie> Movies { get; set; }
        public static List<Rating> Ratings { get; set; }
        public static Movie updatePageSelectedMovie {  get; set; }
        public static DateTime? DailyLastUpdate { get; set; }
        public static DateTime? TrendingLastUpdate { get; set; }
        public static string Username { get; set; }
    }
}
