$(document).on("click",".przycisk_menu",function(){
		  $(".zdjecie_tlo").css('opacity','0.3');
			//$(".zdjecie_tlo").css('filter','brightness(0.3)');//nie działa w komórce
			//$(".zdjecie_tlo").css('background','linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)');
			//var id_przycisku=$(this).attr('id');
			
			//$(".napis").text(id_przycisku);
			 $('.tresc').load($(this).attr('adr'));
			var pStart=$("#przycisk_start");
			if(!pStart.length){
			$(".menu").append('<div class="przycisk_menu" id="przycisk_start" adr="start.php">start</div>');
			}
			
			
	});
	$(document).on("click","#przycisk_start ",function(){
		$(".zdjecie_tlo").css('opacity','1.0');
		//$(".zdjecie_tlo").css('filter','brightness(1.0)');//nie działa w komórce
		$(".napis").html("Nocny kwartet<br />muzyka na żywo");
		var pStart=$("#przycisk_start");
		
		if(pStart.length){//skasuje przycis jeśli jest
		$("#przycisk_start").remove();
		}
	//$(document).on("mouseleave",".przycisk_menu",function(){
	//	  $(this).css('text-shadow','none');
			
	});
	$(document).on("click","#przycisk_wyloguj",function(){
		if($("#przycisk_wyloguj").length){//skasuje przycisk jeśli jest
		$("#przycisk_wyloguj").remove();
		}
		if($("#przycisk_opcje").length){//skasuje przycisk jeśli jest
		$("#przycisk_opcje").remove();
		}
	});
	
	
	$(document).on('input',"#kontakt_zwrotny",function(){
		if($("#nie_mozebyc_puste").length && $("#kontakt_zwrotny").length){$("#nie_mozebyc_puste").remove();}
	});
	$(document).on('click',"#id_tekst_wiadomosci",function(){
		$("#id_tekst_wiadomosci").empty();
	});