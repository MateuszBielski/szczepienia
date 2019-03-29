var $rodzSzczepionki = $('#szczepienie_rodzajSzczepionki');

jQuery(document).ready(function() {
    $rodzSzczepionki.change(function() {
        // ... retrieve the corresponding form.
      var $form = $(this).closest('form');
      // Simulate form data, but only include the selected szczepionka value.
      var data = {};
      data[$rodzSzczepionki.attr('name')] = $rodzSzczepionki.val();
      // Submit data via AJAX to the form's action path.
      $.ajax({
        url : $form.attr('action'),
        type: $form.attr('method'),
        data : data,
        success: function(html) {
          // Replace current position field ...
          $('#szczepienie_coPodano').replaceWith(
            // ... with the returned one from the AJAX response.
            $(html).find('#szczepienie_coPodano')
          );
          // Position field now displays the appropriate positions.
        }
      });
    });
    
});

/*

*/