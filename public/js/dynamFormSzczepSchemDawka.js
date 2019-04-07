function podmianaSelect($nazwaSelektora,$miejscaZmieniane){
    console.log($('#'+$nazwaSelektora[0]).val());
    console.log($('#'+$nazwaSelektora[2]).val());    
        var $form = $(this).closest('form');
        var daneDoWyslania = {};
        for (i = 0; i < $nazwaSelektora.length; i++) {
            var $selektor = $('#'+$nazwaSelektora[i]);
            daneDoWyslania[$selektor.attr('name')] = $selektor.val();
        }
         $.ajax({
        url : $form.attr('action'),
        type:'POST',
        data : daneDoWyslania,
        success: function(html_odp) {
         for (i = 0; i < $miejscaZmieniane.length; i++) {
            $($miejscaZmieniane[i]).replaceWith($(html_odp).find($miejscaZmieniane[i]));
         } 
         //$('#kontener').html(html_odp);
        }
      });
}

jQuery(document).ready(function() {
    //var $przycisk = $('#przycisk');
    var $nazwaSelektora = [
    'copodano_rodzajSzczepionki',
    'copodano_coPodano',
    'copodano_schematTymczasowy',
    'copodano_dataZabiegu_year',
    'copodano_dataZabiegu_month',
    'copodano_dataZabiegu_day'
    ];
    
    $('#'+$nazwaSelektora[0]).change(function() {
        //console.log($('#copodano_rodzajSzczepionki').val());
        //console.log($('#copodano_schematTymczasowy').val());
        podmianaSelect($nazwaSelektora,['#copodano_schematTymczasowy','#copodano_coPodano']);//'#copodano_schematTymczasowy',
    });
    $('#'+$nazwaSelektora[2]).change(function() {
        podmianaSelect($nazwaSelektora,['#copodano_coPodano']);
    });
    
});
