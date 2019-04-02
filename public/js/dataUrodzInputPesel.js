jQuery(document).ready(function() {
    //var $przycisk = $('#przycisk');
    var $inputPesel = $('#pacjent_pesel');//
    var $div_data_urodz = $('#div_data_urodz');
    var $inputImie = $('#pacjent_imie');
    var $inputNazwisko = $('#pacjent_nazwisko');
    
    $inputPesel.on('input',function() {
        
        var $pesel = $inputPesel.val();
        if($pesel.length < 11) return;
        //console.log($pesel.length);
        
        var $form = $(this).closest('form');
        var data = {};
        data[$inputPesel.attr('name')] = $pesel;
        data[$inputImie.attr('name')] = $inputImie.val();
        data[$inputNazwisko.attr('name')] = $inputNazwisko.val();
        $div_data_urodz.text($pesel); 
         $.ajax({
        url : $form.attr('action'),
        type:'POST',
        data : data,
        success: function(html_odp) {
          $('#div_data_urodz').replaceWith(
            $(html_odp).find('#div_data_urodz')
          );
          //$('#kontener').text($rodzSzczepionki.val()); 
          //$('#kontener').html(html_odp);
        }
      });
    });
    
});
