function podmianaSelect($pole,$miejscaZmieniane){
        var $selektorDaty = [
        '#copodano_dataZabiegu_year',
        '#copodano_dataZabiegu_month',
        '#copodano_dataZabiegu_day'
        ];
        var $form = $(this).closest('form');
        var daneDoWyslania = {};
        for (i = 0; i < $selektorDaty.length; i++) {
            var $d = $($selektorDaty[i]);
            daneDoWyslania[$d.attr('name')] = $d.val();
        }
            var $zmiana = $($pole);
            daneDoWyslania[$zmiana.attr('name')] = $zmiana.val();
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
    
    var $rodzajSzczepionki = '#copodano_rodzajSzczepionki';
    $($rodzajSzczepionki).change(function() {
        console.log('zmiana rodzaj szczepionki');
        podmianaSelect($rodzajSzczepionki,['#copodano_schematTymczasowy','#copodano_coPodano']);//'#copodano_schematTymczasowy',
    });
    var $schemat = '#copodano_schematTymczasowy';
    $($schemat).change(function() {
        console.log('zmiana schemat');
        podmianaSelect($schemat,['#copodano_coPodano']);
    });
});
