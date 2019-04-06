function podmianaSelect($daneOdczytane,$miejscaZmieniane){
    console.log($daneOdczytane[0].val());
    console.log($daneOdczytane[2].val());    
        var $form = $(this).closest('form');
        var daneDoWyslania = {};
        for (i = 0; i < $daneOdczytane.length; i++) {
            daneDoWyslania[$daneOdczytane[i].attr('name')] = $daneOdczytane[i].val();
        }
         $.ajax({
        url : $form.attr('action'),
        type:'POST',
        data : daneDoWyslania,
        success: function(html_odp) {
         for (i = 0; i < $miejscaZmieniane.length; i++) {
            $($miejscaZmieniane[i]).replaceWith($(html_odp).find($miejscaZmieniane[i]));
         }   
        }
      });
}

jQuery(document).ready(function() {
    //var $przycisk = $('#przycisk');
    var $daneOdczytane = [
    $('#copodano_rodzajSzczepionki'),
    $('#copodano_coPodano'),
    $('#copodano_schematTymczasowy'),
    $('#copodano_dataZabiegu_year'),
    $('#copodano_dataZabiegu_month'),
    $('#copodano_dataZabiegu_day')
    ];
    
    $daneOdczytane[0].change(function() {
        podmianaSelect($daneOdczytane,['#copodano_schematTymczasowy','#copodano_coPodano']);
    });
    $daneOdczytane[2].change(function() {
        podmianaSelect($daneOdczytane,['#copodano_coPodano']);
    });
    
});
