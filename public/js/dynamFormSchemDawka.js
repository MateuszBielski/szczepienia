jQuery(document).ready(function() {
    //var $przycisk = $('#przycisk');
    var rodzajSzczepionki = '#copodano_rodzajSzczepionki';
    var schem = $('#copodano_schematTymczasowy');//
    var year = '#copodano_dataZabiegu_year';
    var month = '#copodano_dataZabiegu_month';
    var day = '#copodano_dataZabiegu_day';
    
    
    //schem.change(function() {
    $(document).on('change',schem,function() {
        console.log('schemat '+schem.val());
        
        var $form = $(this).closest('form');
        var data = {};
        data[schem.attr('name')] = schem.val();
        data[$(year).attr('name')] = $(year).val();
        data[$(month).attr('name')] = $(month).val();
        data[$(day).attr('name')] = $(day).val();
        $('#kontener').append('schemat '+schem.val()); 
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
    $(document).on('change',$(rodzajSzczepionki),function() {
        console.log('rodzajSzczepionki '+$(rodzajSzczepionki).val());
        
        var $form = $(this).closest('form');
        var data = {};
        data[$(rodzajSzczepionki).attr('name')] = $(rodzajSzczepionki).val();
        data[$(year).attr('name')] = $(year).val();
        data[$(month).attr('name')] = $(month).val();
        data[$(day).attr('name')] = $(day).val();
        $('#kontener').text('rodzaj'+$(rodzajSzczepionki).val()); 
         $.ajax({
        url : $form.attr('action'),
        type:'POST',
        data : data,
        success: function(html_odp) {
          //$('#copodano_schematTymczasowy').replaceWith(
            //$(html_odp).find('#copodano_schematTymczasowy')
          //);
          //$('#kontener').text($rodzSzczepionki.val()); 
          //$('#kontener').html(html_odp);
          /*
          var $schem = $('#copodano_schematTymczasowy');
          $schem.change(function() {
            console.log('schemat '+$schem.val());
          });
          */
        }
      });
      
    });
});
