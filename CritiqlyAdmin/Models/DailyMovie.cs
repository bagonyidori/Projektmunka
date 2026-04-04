using System;
using System.Collections.Generic;
using System.Text;
using static System.Runtime.InteropServices.JavaScript.JSType;

namespace CritiqlyAdmin.Models
{
    public class DailyMovie
    {
        public int id { get; set; }
        public int movie_id { get; set; }
        public DateTime? date { get; set; }
        public DateTime? created_at { get; set; }
        public DateTime? updated_at { get; set; }
    }
}
