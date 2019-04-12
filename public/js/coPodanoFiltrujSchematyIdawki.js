jQuery(document).ready(function() {

    var rodzajSzczepionki = '#copodano_rodzajSzczepionki';
    
    $(rodzajSzczepionki).change(function(){
        var szczepionkaSelektor = $(this);
        //$('#kontener').text(szczepionkaSelektor.val());
        $.ajax({
                url: "/szczepienie/ajaxSchematZeSczepionki",
                type: "GET",
                dataType: "JSON",
                data: {
                    szczepionkaId: szczepionkaSelektor.val()
                },
                success: function (schematy) {
                     var schematySelect = $("#copodano_schematTymczasowy");

                    // Remove current options
                    schematySelect.html('');
                    
                    // Empty value ...
                    schematySelect.append('<option value> Wybierz schemat ' + szczepionkaSelektor.find("option:selected").text() + ' ...</option>');
                    
                    
                    $.each(schematy, function (key, schemat) {
                        schematySelect.append('<option value="' + schemat.id + '">schemat ' + schemat.id + '</option>');
                    });
                },
                error: function (err) {
                    alert("An error ocurred while loading data ...");
                }
        });
    });
});