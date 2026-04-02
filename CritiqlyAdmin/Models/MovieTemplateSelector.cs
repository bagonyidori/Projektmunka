using System;
using System.Collections.Generic;
using System.Text;

namespace CritiqlyAdmin.Models
{
    public class MovieTemplateSelector : DataTemplateSelector
    {
        public DataTemplate NormalTemplate { get; set; }
        public DataTemplate UpdatedTemplate { get; set; }

        protected override DataTemplate OnSelectTemplate(object item, BindableObject container)
        {
            var movie = item as Movie;

            if (movie.IsUpdated)
                return UpdatedTemplate;

            return NormalTemplate;
        }
    }
}
