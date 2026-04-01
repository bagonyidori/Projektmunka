using System;
using System.Collections.Generic;
using System.Text;
using System.Text.Json.Serialization;

namespace CritiqlyAdmin.Models
{
    public class AdminData
    {
        public int Id { get; set; }

        [JsonPropertyName("daily_last_update")]
        public DateTime DailyLastUpdate { get; set; }

        [JsonPropertyName("trending_last_update")]
        public DateTime TrendingLastUpdate { get; set; }
    }
}
