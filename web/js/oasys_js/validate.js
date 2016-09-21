$(document).ready(function(){
	
	var form = $("#formArsip");
	var nomorDokumen = $("#nomor_dokumen");
	var infoNomorDokumen = $("#info_nomor_dokumen");
	var perihal = $("#perihal");
	var infoPerihal = $("#info_perihal");
	var kepada = $("#kepada");
	var infoKepada = $("#info_kepada");
	var institusi = $("#institusi");
	var infoInstitusi = $("#info_institusi");
	var alamat = $("#alamat");
	var infoAlamat = $("#info_alamat");
	var jumlahDokumen = $("#jumlah_dokumen");
	var infoJumlahDokumen = $("#info_jumlah_dokumen");
	var lemari = $("#lemari");
	var infoLemari = $("#info_lemari");
	var rak = $("#rak");
	var infoRak = $("#info_rak");
	var folder = $("#folder");
	var infoFolder = $("#info_folder");
	var map = $("#map");
	var infoMap = $("#info_map");
	var posisi = $("#posisi");
	var infoPosisi = $("#info_posisi");
	
	//On key press
	nomorDokumen.keyup(validateNomorDokumen);
	perihal.keyup(validatePerihal);
	kepada.keyup(validateKepada);
	institusi.keyup(validateInstitusi);
	alamat.keyup(validateAlamat);
	jumlahDokumen.keyup(validateJumlahDokumen);
	lemari.keyup(validateLemari);
	rak.keyup(validateRak);
	folder.keyup(validateFolder);
	map.keyup(validateMap);
	posisi.keyup(validatePosisi);
	
	
	//On Submitting
	form.submit(function(){
		if(validateNomorDokumen() & validatePerihal() & validateKepada() & validateInstitusi() & validateAlamat())
			return true;
		else
			return false;
	});
	
	function validateNomorDokumen(){
		
		if(nomorDokumen.val() == ''){
			nomorDokumen.addClass("error");
			infoNomorDokumen.text("Jangan kosong");
			infoNomorDokumen.addClass("error");
			return false;
		}
		
		else{
			nomorDokumen.removeClass("error");
			infoNomorDokumen.text("");
			infoNomorDokumen.removeClass("error");
			return true;
		}
	}
	
function validatePerihal(){
		
		if(perihal.val() == ''){
			perihal.addClass("error");
			infoPerihal.text("Jangan kosong");
			infoPerihal.addClass("error");
			return false;
		}
		
		else{
			perihal.removeClass("error");
			infoPerihal.text("");
			infoPerihal.removeClass("error");
			return true;
		}
	}

	function validateKepada(){
	
		if(kepada.val() == ''){
			kepada.addClass("error");
			infoKepada.text("Jangan kosong");
			infoKepada.addClass("error");
			return false;
		}
	
		else{
			kepada.removeClass("error");
			infoKepada.text("");
			infoKepada.removeClass("error");
			return true;
		}
	}
	
	function validateInstitusi(){
		
		if(institusi.val() == ''){
			institusi.addClass("error");
			infoInstitusi.text("Jangan kosong");
			infoInstitusi.addClass("error");
			return false;
		}
		
		else{
			institusi.removeClass("error");
			infoInstitusi.text("");
			infoInstitusi.removeClass("error");
			return true;
		}
	}
	
	function validateAlamat(){
		
		if(alamat.val() == ''){
			alamat.addClass("error");
			infoAlamat.text("Jangan kosong");
			infoAlamat.addClass("error");
			return false;
		}
		
		else{
			alamat.removeClass("error");
			infoAlamat.text("");
			infoAlamat.removeClass("error");
			return true;
		}
	}
	
	function validateJumlahDokumen(){
		
		if(jumlahDokumen.val() == ''){
			jumlahDokumen.addClass("error");
			infoJumlahDokumen.text("Jangan kosong");
			infoJumlahDokumen.addClass("error");
			return false;
		}
		
		else{
			jumlahDokumen.removeClass("error");
			infoJumlahDokumen.text("");
			infoJumlahDokumen.removeClass("error");
			return true;
		}
	}
	
	function validateLemari(){
		
		if(lemari.val() == ''){
			lemari.addClass("error");
			infoLemari.text("Jangan kosong");
			infoLemari.addClass("error");
			return false;
		}
		
		else{
			lemari.removeClass("error");
			infoLemari.text("");
			infoLemari.removeClass("error");
			return true;
		}
	}
	
	function validateRak(){
		
		if(rak.val() == ''){
			rak.addClass("error");
			infoRak.text("Jangan kosong");
			infoRak.addClass("error");
			return false;
		}
		
		else{
			rak.removeClass("error");
			infoRak.text("");
			infoRak.removeClass("error");
			return true;
		}
	}
	
	function validateFolder(){
		
		if(folder.val() == ''){
			folder.addClass("error");
			infoFolder.text("Jangan kosong");
			infoFolder.addClass("error");
			return false;
		}
		
		else{
			folder.removeClass("error");
			infoFolder.text("");
			infoFolder.removeClass("error");
			return true;
		}
	}
	
	function validateMap(){
		
		if(map.val() == ''){
			map.addClass("error");
			infoMap.text("Jangan kosong");
			infoMap.addClass("error");
			return false;
		}
		
		else{
			map.removeClass("error");
			infoMap.text("");
			infoMap.removeClass("error");
			return true;
		}
	}
	
	function validatePosisi(){
		
		if(posisi.val() == ''){
			posisi.addClass("error");
			infoPosisi.text("Jangan kosong");
			infoPosisi.addClass("error");
			return false;
		}
		
		else{
			posisi.removeClass("error");
			infoPosisi.text("");
			infoPosisi.removeClass("error");
			return true;
		}
	}
});