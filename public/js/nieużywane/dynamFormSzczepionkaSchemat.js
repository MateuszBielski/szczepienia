jQuery(document).ready(function() {
    //var $przycisk = $('#przycisk');
    var $rodzSzczepionki = $('#copodano_rodzajSzczepionki');//
    var $coPodano = $('#copodano_coPodano');
    var $schemat = $('#copodano_schematTymczasowy');
    var $year = $('#copodano_dataZabiegu_year');
    var $month = $('#copodano_dataZabiegu_month');
    var $day = $('#copodano_dataZabiegu_day');
    
    
    
    $rodzSzczepionki.change(function() {
        console.log($rodzSzczepionki.val());
        
        var $form = $(this).closest('form');
        var data = {};
        data[$rodzSzczepionki.attr('name')] = $rodzSzczepionki.val();//$rodzSzczepionki.attr('name') 'szczepienie[rodzajSzczepionki]'
        data[$year.attr('name')] = $year.val();
        data[$month.attr('name')] = $month.val();
        data[$day.attr('name')] = $day.val();
        data[$coPodano.attr('name')] = $coPodano.val();
        data[$schemat.attr('name')] = $schemat.val();
        //$('#kontener').text($rodzSzczepionki.val()); 
         $.ajax({
        url : $form.attr('action'),
        type:'POST',
        data : data,
        success: function(html_odp) {
          $('#copodano_schematTymczasowy').replaceWith(
            $(html_odp).find('#copodano_schematTymczasowy')
          );
          $('#copodano_coPodano').replaceWith(
            $(html_odp).find('#copodano_coPodano')
          );
          //$('#kontener').text($rodzSzczepionki.val()); 
          //$('#kontener').html(html_odp);
        }
      });
    });
    
});
