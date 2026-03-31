using System;
using System.Collections.Generic;
using System.Text;
using System.Text.Json.Serialization;

namespace CritiqlyAdmin.Models
{
    public class User
    {
        public int Id { get; set; }
        public string Username { get; set; }
        public string Email { get; set; }
        public DateTime? Email_Verified_At { get; set; }
        public string Password { get; set; }

        [JsonPropertyName("is_admin")]
        public bool Is_Admin { get; set; }

    }
}
