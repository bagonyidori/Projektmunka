using System;
using System.Collections.Generic;
using System.Text;

namespace CritiqlyAdmin.Models
{
    public class Movie
    {

        public int id {  get; set; }
        public int tmdb_id { get; set; }
        public string title { get; set; }
        public string genre { get; set; }
        public string plot { get; set; }
        public DateTime? releaseDate { get; set; }
        public string poster { get; set; }
        public string fullPosterUrl =>
            string.IsNullOrEmpty(poster)? null : $"https://image.tmdb.org/t/p/w500{poster}";
        public DateTime? created_at { get; set; }
        public DateTime? updated_at { get; set; }
        public DateTime? deleted_at { get; set; }
        public bool IsUpdated { get; set; }
        public bool IsDeleted { get; set; }

        /*public Movie(int id, int tmdb_id, string title, string genre, string plot, DateTime release_date, string poster, DateTime created_at, DateTime updated_at, DateTime deleted_at)
        {
            this.id = id;
            this.tmdb_id = tmdb_id;
            this.title = title;
            this.genre = genre;
            this.plot = plot;
            this.release_date = release_date;
            this.poster = poster;
            this.created_at = created_at;
            this.updated_at = updated_at;
            this.deleted_at = deleted_at;
        }*/
    }
}
