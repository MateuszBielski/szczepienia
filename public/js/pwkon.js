$(document).on("click","#przycisk_wyslij_kontakt",function(){
		var trescWiadomosci=$('textarea[name=pole_wiadomosci]').val();
		var kontaktZwrotny=$('input[name=kontakt_zwrotny]').val();
		//kasuje ostrzeżenie jeśli jest
		if($("#nie_mozebyc_puste").length){$("#nie_mozebyc_puste").remove();}
		if(kontaktZwrotny != ''){
			$.ajax({
			url: "wyslij_mail.php",
			type: "POST",
			//dataType : 'json',
			data: {kontakt:kontaktZwrotny,tresc : trescWiadomosci},
			//data: "kontakt="+kontaktZwrotny+"&tresc="+trescWiadomosci,
			success: function(msg) {
				$("#wyslij_wiadomosc").html('odebrane dane przed parse: '+msg);//wyświetla się na chwilę i znika, chyba że jest problem
				
				var odebrane = JSON.parse(msg);
				//$("#wyslij_wiadomosc").append('wyodrębnione z json: '+odebrane['tresc']+'koniec');
				if(odebrane['czyPrzekierowac']=='true'){
					if(!$("#przycisk_wyloguj").length)$(".menu").prepend(odebrane['przycisk']);
					$(".tresc").load(odebrane['tresc']);
					//$(".tresc").html(odebrane['tresc']);
				}else{
					$("#wyslij_wiadomosc").html(odebrane['tresc']);
				}
					
			},
			error: function(msg){
				$("#wyslij_wiadomosc").html('ajax błąd'+msg);
			}
			});
		}else{
			$("#wyslij_wiadomosc").append('<div id="nie_mozebyc_puste">Pole powyżej nie może być puste</div> ');
		}
		
	});