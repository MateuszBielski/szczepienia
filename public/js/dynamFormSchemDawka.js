jQuery(document).ready(function() {
    //var $przycisk = $('#przycisk');
    var $schem = $('#copodano_schematTymczasowy');//
    var $year = $('#copodano_dataZabiegu_year');
    var $month = $('#copodano_dataZabiegu_month');
    var $day = $('#copodano_dataZabiegu_day');
    
    
    $schem.change(function() {
        console.log($schem.val());
        
        var $form = $(this).closest('form');
        var data = {};
        data[$schem.attr('name')] = $schem.val();//$rodzSzczepionki.attr('name') 'szczepienie[rodzajSzczepionki]'
        data[$year.attr('name')] = $year.val();
        data[$month.attr('name')] = $month.val();
        data[$day.attr('name')] = $day.val();
        $('#kontener').text($schem.val()); 
         $.ajax({
        url : $form.attr('action'),
        type:'POST',
        data : data,
        success: function(html_odp) {
          $('#copodano_coPodano').replaceWith(
            $(html_odp).find('#copodano_coPodano')
          );
          //$('#kontener').text($rodzSzczepionki.val()); 
          //$('#kontener').html(html_odp);
        }
      });
    });
    
});
