$(document).on("click",".nazwa_filmu",function(){
		  //utworzyæ div na film, jesli go nie ma
			var divFilm=$("#id_div_film");
			if(!divFilm.length)$("#id_lista_filmow").before("<div id='id_div_film'></div>");
			
			
			var adrFilmu="https://www.youtube.com/embed/"+$(this).attr('adr');
			//var adrNastZdjecie=$(this).next().attr('src');
			var htmlFilmDuzy="<iframe class='frame_film' width='95%' height='600' src='"+adrFilmu+"' frameborder='0' allowfullscreen></iframe>";
			$("#id_div_film").html(htmlFilmDuzy);
			
			//$("#id_duze_zdjecie").text($(this).attr('src');
	});