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
                        schematySelect.append('<option value="' + schemat.id + '"> schemat ' + schemat.id + '</option>');//schemat 
                    });
                    
                },
                error: function (err) {
                    alert("An error ocurred while loading data ...");
                }
        });
    });
    
    var schematTymczasowy = '#copodano_schematTymczasowy';
    
    $(schematTymczasowy).change(function(){
        var schematSelektor = $(this);
        var szczepionkaSelektor = $('#copodano_rodzajSzczepionki');
        //$('#kontener').text(szczepionkaSelektor.val());
        $.ajax({
                url: "/szczepienie/ajaxDawkaZeSchematu",
                type: "GET",
                dataType: "JSON",
                data: {
                    schematId: schematSelektor.val()
                },
                success: function (dawki) {
                     var dawkiSelect = $("#copodano_coPodano");

                    // Remove current options
                    dawkiSelect.html('');
                    
                    // Empty value ...
                    dawkiSelect.append('<option value> Wybierz dawkę ' + szczepionkaSelektor.find("option:selected").text() 
                    + ' schemat nr.' + schematSelektor.val() + ' ...</option>');
                    
                    
                    $.each(dawki, function (key, dawka) {
                        dawkiSelect.append('<option value="' + dawka.id + '">' + dawka.nazwa + '</option>');
                    });
                    //schematSelektor.val(schematSelektor.val());
                    $("#copodano_schematTymczasowy option[value=1]").attr('selected', 'selected');
                },
                error: function (err) {
                    alert("An error ocurred while loading data ...");
                }
        });
    });
});