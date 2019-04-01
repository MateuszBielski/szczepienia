jQuery(document).ready(function() {
    //var $przycisk = $('#przycisk');
    var $rodzSzczepionki = $('#copodano_rodzajSzczepionki');//
    
    $rodzSzczepionki.change(function() {
        console.log($rodzSzczepionki.val());
        
        var $form = $(this).closest('form');
        var data = {};
        data[$rodzSzczepionki.attr('name')] = $rodzSzczepionki.val();//$rodzSzczepionki.attr('name') 'szczepienie[rodzajSzczepionki]'
        $('#kontener').text($rodzSzczepionki.val()); 
         $.ajax({
        url : $form.attr('action'),
        type:'POST',
        data : data,
        success: function(html_odp) {
          // Replace current position field ...
          $('#copodano_coPodano').replaceWith(
            // ... with the returned one from the AJAX response.
            $(html_odp).find('#copodano_coPodano')
          );
          //$('#kontener').text($rodzSzczepionki.val()); 
          //$('#kontener').html(html_odp);
          // Position field now displays the appropriate positions.
        }
      });
    });
    
});
