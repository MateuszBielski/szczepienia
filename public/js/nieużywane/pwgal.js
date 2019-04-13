function wyszukajSasiadow(adrZdjecia){
	var tablica= new Array(3);
		
	var zbiorWszystkichMiniatur=$("img.zdjecia_miniatury ");
	var nrAktualnegoZdjecia=0;
	var nrPoprzZdjecia=0;
	var nrNastZdjecia=0;
	var ileZdjec=zbiorWszystkichMiniatur.length;
	//var adrNastZeWszystkich=aktualneZeZbioruWszystkich.next().attr('src');
	//alert(zbiorWszystkichMiniatur.first().attr('src'));
	
	for(i=0;i<ileZdjec;i++){
		//wyszukanie aktualnego zdjęcia
		
		if(adrZdjecia==zbiorWszystkichMiniatur.eq(i).attr('src')){
			nrAktualnegoZdjecia=i;
			nrNastZdjecia=(i>=ileZdjec-1)?0:i+1;
			nrPoprzZdjecia=(i<1)?ileZdjec-1:i-1;
			break;
		}
		
	}	
		//kolejne adresy aktualny, poprzedni, następny
		tablica[0]=zbiorWszystkichMiniatur.eq(nrAktualnegoZdjecia).attr('src');
		tablica[1]=zbiorWszystkichMiniatur.eq(nrPoprzZdjecia).attr('src');
		tablica[2]=zbiorWszystkichMiniatur.eq(nrNastZdjecia).attr('src');
		
		return tablica;
}
function dopasujWymiaryZdjecia(adrZdjecia){
	//wymiary diva bezpośrednio nad zdjeciem
	$("#id_duze_zdjecie").width();
}
function wysrodkujZdjecie(){
	var divSel=$("#id_duze_zdjecie");
	var szerokoscDiva=divSel.width();
	var imgSel=$("img.zdjecie_duze");
	var szerokoscImg=imgSel.width();
	var przesun=(szerokoscDiva-szerokoscImg)/2;
	//czy przesunięcie jest dalej niż brzeg strony?
	var lewyBrzeg=divSel.offset().left-5;//margines 5
	if(przesun<(-lewyBrzeg))przesun=-lewyBrzeg;
	imgSel.css( "left", przesun );
	//$("#id_podglad_miniatur").before("brzeg: "+lewyBrzeg);
	//return przesun;
}

function resize_image(img) {
    // jeśli szerokość obrazka jest większa niż dopuszczalna maksymalna szerokość
		var max_width=$("#id_duze_zdjecie").width();
    if(img.width > max_width) {
        // obliczamy proporcje szerokość do wysokość
        factor = img.width / img.height;
        // obliczamy proporcjonalną wysokość, zaokrąglamy ją używając Math.floor();
        height = Math.floor(max_width / factor);
        // nadajemy obrazkowi nowe wymiary
        img.width = max_width;
        img.height = height;
    }
}


$(document).on("click","#przycisk_wyslij_galeria",function(){
		var data = new FormData();
		jQuery.each(jQuery('#plik')[0].files, function(i, file) {
    data.append('file-'+i, file);
		
		});
		jQuery.ajax({
			url: 'ladujPlik.php',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST',
			success: function(data){
					//alert(data);
					$("#dLadowanieZdjecia").html(data);
			}
		});
	});
$(document).on("click",".zdjecia_miniatury",function(){
		  //utworzyć div na duże zdjęcie, jesli go nie ma
			var divDuzeZdjecie=$("#id_duze_zdjecie");
			if(!divDuzeZdjecie.length){
				$("#id_podglad_miniatur").before("<div id='zdjecie_i_przyciski'><div id='id_duze_zdjecie'></div></div>");
				
			}
			
			//var adrZdjecia=$(this).attr('src');
			var adrZdjecia=$(this).attr('src');
			var adrSasiadujace=wyszukajSasiadow(adrZdjecia);
			var adrPoprzZdjecie=adrSasiadujace[1];
			var adrNastZdjecie=adrSasiadujace[2];
			
			
			//console.log();
			//console.log("poprzednie "+zbiorWszystkichMiniatur.eq(nrPoprzZdjecia).attr('src'));
			//console.log("następne "+zbiorWszystkichMiniatur.eq(nrNastZdjecia).attr('src'));
			//console.log("zawartość tablicy: "+wyszukajSasiadow(5).length);
			//var htmlZdjecieDuze="<img src='"+adrZdjecia+"' class='zdjecie_duze' onload='resize_image(this);'/>";
			var htmlZdjecieDuze="<img src='"+adrZdjecia+"' class='zdjecie_duze' />";
			$("#id_duze_zdjecie").html(htmlZdjecieDuze);
			wysrodkujZdjecie();
			//zrobić przyciski
			var divLstrz=$("#lewaStrz");
			var divPstrz=$("#prawaStrz");
			if(!(divLstrz.length+divPstrz.length)){
				var htmlPanelNaw="<div id=panel_naw></div>";
				$("#id_duze_zdjecie").before(htmlPanelNaw);
				var htmlLewaStrz="<div id='lewaStrz' class='nawigacja'>poprzednie</div>";
				var htmlPrawaStrz="<div id='prawaStrz' class='nawigacja'>następne</div>";
				$("#panel_naw").html(htmlLewaStrz+htmlPrawaStrz);
				
			}
			//w przyciskach umieścić adresy innych zdjęć
			$("#lewaStrz").attr('adr',adrPoprzZdjecie);
			$("#prawaStrz").attr('adr',adrNastZdjecie);
			//$("#id_duze_zdjecie").text($(this).attr('src');
	});
	$(document).on("click",".nawigacja",function(){
		//alert($(this).attr('adr'));//
		var nowyAdr=$(this).attr('adr');
		//wyszukać element po atrybucie
		//var wskazywanaMiniatura=$("#id_podglad_miniatur[src='"+nowyAdr+"']");
		var adrSasiadujace=wyszukajSasiadow(nowyAdr);
		var noweL=adrSasiadujace[1];
		var noweP=adrSasiadujace[2];
		//console.log("szerokość div"+$('#id_duze_zdjecie').width()+"szerokość zdjęcia: ");
		
		//alert(noweL+noweP);
		//podmiana adresu
		$("img.zdjecie_duze").attr('src',nowyAdr);
		$("#lewaStrz").attr('adr',noweL);
		$("#prawaStrz").attr('adr',noweP);
		
		wysrodkujZdjecie();
	});
	
	