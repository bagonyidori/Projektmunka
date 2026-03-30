using System;
using System.Collections.Generic;
using System.Text;

namespace CritiqlyAdmin.Models
{
    public class Rating
    {
        public int Id { get; set; }
        public int movie_id { get; set; }
        public int user_id { get; set; }
        public string comment { get; set; }
        public int stars { get; set; }
        public DateTime? created_at { get; set; }
        public DateTime? updated_at { get; set; }
        public DateTime? deleted_at { get; set; }

    }
}
