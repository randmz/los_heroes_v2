/*
///////////////////////////////////////
//                                   //
//    Código por Hugo Bórquez R.     //
//    pugopugo@hotmail.com           //
//                                   //
///////////////////////////////////////
*/

var disponibilidad="Revisando si est&aacute; registrado el pensionado";

var bien = 0;

pic1 = new Image(16, 16); 
pic1.src = "imagenes/loader.gif";

var req;

$.ajaxSetup({
    cache: false
});

$(document).ready(function(){

$('#rut').focus();
$('#rut-control').focus();
/* función para revisar el pensionado en la bd */
/* funcion para verificar el nombre */

$("#rut").blur(function() { 

	var usr = $("#rut").val();
	usr = usr.replace(/^\s*|\s*$/g,"");
	var rpta = null;

	if(usr == ""){
	$('#status_rut').fadeOut('slow');

	exit(1);
	}
	var req = $.ajax({  
    type: "POST",  
    url: "codigos/check.php",  
    data: "rut="+ usr +"&aux=rut",
	
    success: function(rpta){  
	
   var msg = rpta.split("&&");
   
   var res = $("#status_rut").ajaxComplete(function(event, request, settings){ 
	
	if(msg[0] == 'OK')
	{
		//cuando no está registrado el pensionado
		queue:false;
		$('#nombre').val('');
		$('#edad').val('');
		$('#telefono').val('');

		document.crear_ficha.sexo[0].checked = true;
		$('#correo').val('');
		
		$('#peso').val('');
		$('#estatura').val('');
		$('#imc').val('');
		$('#imc_riesgo').val('');
		$('#cintura').val('');
		$('#cintura_riesgo').val('');
		
		$('#imc_entero').fadeOut('slow');
		$('#imc_riesgo_tr').fadeOut('slow');
		$('#riesgo_cintura').fadeOut('slow');
		$('#sexo_texto').fadeOut('slow');
		
		document.crear_ficha.nombre.readOnly = false;
		document.crear_ficha.edad.readOnly = false;
		document.crear_ficha.telefono.readOnly = false;
		document.crear_ficha.correo.readOnly = false;
		
		$('#editar').fadeOut('slow');
		$('#regiones').fadeIn('slow');
		$('#centros').fadeIn('slow');
		
		setTimeout(function() { document.getElementById('sexo_radio').style.display = "block"; }, 400);
		
		
        $("#rut").removeClass('object_error'); // if necessary
		$("#rut").addClass("object_ok");
		
		$(this).html('<font color="green">Usuario nuevo</font>');
		
	}  
	else  
	{  
		queue:false;
		$('#editar').fadeIn('slow');
		
		//cuando está registrado el pensionado
		document.crear_ficha.nombre.readOnly = true;
		document.crear_ficha.edad.readOnly = true;
		document.crear_ficha.telefono.readOnly = true;
		document.crear_ficha.correo.readOnly = true;		
		
		document.getElementById('sexo_radio').style.display = "none"; 
		$('#sexo_texto').fadeIn('fast');
		
		$('#regiones').hide();
		$('#ciudades').hide();
		$('#centros').hide();
		$('#div_afiliado').hide();
		$('#div_fecha').hide();
		$('#barra-separadora').hide();
		
		setTimeout(function() { $('#peso').focus(); }, 600);
		
		var nombre = msg[2];
		
		nombre = nombre.replace("&aacute;","\u00e1"); 
		nombre = nombre.replace("&eacute;","\u00e9"); 
		nombre = nombre.replace("&iacute;","\u00ed"); 
		nombre = nombre.replace("&oacute;","\u00f3"); 
		nombre = nombre.replace("&uacute;","\u00fa");
		
		nombre = nombre.replace("&Aacute;","\u00c1"); 
		nombre = nombre.replace("&Eacute;","\u00c9"); 
		nombre = nombre.replace("&Iacute;","\u00cd"); 
		nombre = nombre.replace("&Oacute;","\u00d3"); 
		nombre = nombre.replace("&Uacute;","\u00da"); 
		
		nombre = nombre.replace("&ntilde;","\u00f1"); 
		nombre = nombre.replace("&Ntilde;","\u00d1");
			
		
		$('#nombre').val(nombre);
		$('#edad').val(msg[3]);
		$('#telefono').val(msg[4]);
		//document.crear_ficha.region.selectedIndex=msg[5];
		document.crear_ficha.sexo[msg[6]-1].checked = true;
		
		document.crear_ficha.sexo_texto.readOnly = true;
		
		if(document.crear_ficha.sexo[0].checked == true){
		$('#sexo_texto').val('Masculino');
		}else{
		$('#sexo_texto').val('Femenino');
		}
		
		$('#correo').val(msg[7]);
		
		$('#peso').val(msg[8]);
		$('#estatura').val(msg[9]);
		$('#imc').val(msg[11]);
		$('#imc_riesgo').val(msg[12]);
		$('#cintura').val(msg[10]);
		$('#cintura_riesgo').val(msg[13]);
		
		$('#imc_entero').fadeIn('fast');
		$('#imc_riesgo_tr').fadeIn('fast');
		$('#riesgo_cintura').fadeIn('fast');
		$('#cintura_riesgo').fadeIn('fast');
		
		$("#rut").removeClass('object_ok'); // if necessary
		$("#rut").addClass("object_error");
		$(this).html(msg[0]);
	}  
   
	
   });
   
		
	
 }
   
  }); 
  
	//delete req;
	
}); /* fin #rut */


$("#rut-control").blur(function() { 

	var usr = $("#rut-control").val();
	usr = usr.replace(/^\s*|\s*$/g,"");
	var rpta = null;

	if(usr == ""){
	$('#status_rut').fadeOut('slow');

	exit(1);
	}
	var req = $.ajax({  
    type: "POST",  
    url: "codigos/check.php",  
    data: "rut="+ usr +"&aux=rut-control",
	
    success: function(rpta){  
	
   var msg = rpta.split("&&");
   
   var res = $("#status_rut").ajaxComplete(function(event, request, settings){ 
	
	if(msg[0] == 'OK')
	{
		//cuando no está registrado el pensionado
		$('#no_hay').fadeIn('slow');
	}  
	else  
	{  			
		var nombre = msg[2];
		var fecha = msg[14] + ', ' + msg[15];
		
		nombre = nombre.replace("&aacute;","\u00e1"); 
		nombre = nombre.replace("&eacute;","\u00e9"); 
		nombre = nombre.replace("&iacute;","\u00ed"); 
		nombre = nombre.replace("&oacute;","\u00f3"); 
		nombre = nombre.replace("&uacute;","\u00fa");
		
		nombre = nombre.replace("&Aacute;","\u00c1"); 
		nombre = nombre.replace("&Eacute;","\u00c9"); 
		nombre = nombre.replace("&Iacute;","\u00cd"); 
		nombre = nombre.replace("&Oacute;","\u00d3"); 
		nombre = nombre.replace("&Uacute;","\u00da"); 
		
		nombre = nombre.replace("&ntilde;","\u00f1"); 
		nombre = nombre.replace("&Ntilde;","\u00d1");
			
		document.getElementById('link-metas-antiguo').href="metas-control-antiguo.php?rut=" + usr;
		
		$('#nombre-antiguo').html(nombre);
		$('#fecha-antiguo').html(fecha);
		
		$('#edad-control').val(msg[3]);
		$('#sexo-control').val(msg[6]);
		
		$('#peso-antiguo').html(msg[8] + ' Kilogramos');
		$('#peso-anterior').val(msg[8]);
		$('#estatura-antiguo').html(msg[9] + ' Metros');
		$('#estatura-anterior').val(msg[9]);
		$('#estatura-control').val(msg[9]);
		$('#imc-antiguo').html(msg[11]);
		$('#imc-anterior').val(msg[11]);
		$('#imc_riesgo-antiguo').html(msg[12]);
		$('#imc_riesgo-anterior').val(msg[12]);
		$('#cintura-antiguo').html(msg[10] + ' Cent&iacute;metros');
		$('#cintura-anterior').val(msg[10]);
		$('#cintura_riesgo-antiguo').html(msg[13]);
		$('#cintura_riesgo-anterior').val(msg[13]);
		
		/* actividades = 16 */
		var actividades = msg[16].split(";");

		if(actividades[0] == '1'){
			$('#sub3a').fadeIn('slow');
		}
		if(actividades[1] == '1'){
			$('#sub3b').fadeIn('slow');
		}
		if(actividades[2] == '1'){
			$('#sub3c').fadeIn('slow');
		}
		if(actividades[3] == '1'){
			$('#sub3d').fadeIn('slow');
		}
		
		$("#rut").removeClass('object_ok'); // if necessary
		$("#rut").addClass("object_error");
		$(this).html(msg[0]);
		queue:false;
		
		//sacando las 6 semanas
		
		
		if(msg[17] == 0){
			$('#no_semanas').fadeIn('slow');
		}else{
			$('#si_hay').fadeIn('slow');
			setTimeout(function() { $('#peso-control').focus(); }, 600);
		}
	}  
   
	
   });
   
		
	
 }
   
  }); 
  
	//delete req;
	
}); /* fin #rut control */

//mostrar el control igual, sin 6 semanas
$('#btn-realizar-igual').click(function(){
		$('#no_semanas').fadeOut('slow');
		$('#si_hay').fadeIn('slow');
		setTimeout(function() { $('#peso-control').focus(); }, 600);	
}); // fin btn semanas

//cambiar el valor al seleccionar el radiobutton
$('#continuar').click(function(){
		
	if(document.getElementById('rut').value != ""){
	$('#campo_login').fadeOut('slow');
	$('#campo_login2').delay(100).fadeOut('slow');
	$('#link-login').delay(300).fadeIn('slow');
	$('#reload').delay(700).fadeIn('slow');
	
	queue:false;
	
	$('#campo_login').delay(300).hide();
	$('#campo_login2').delay(300).hide();
	//$('#rut').blur();
	
	//$('#status_rut').delay(500).fadeIn('slow');
	$('#todo').delay(500).fadeIn('slow');	
	
	setTimeout(function() { $('#nombre').focus(); }, 600);
	
	$('#subir_ficha').delay(100).fadeOut('slow');
	
	}else{
	$('#status_rut').html('<font color="red">Debe ingresar el rut del pensionado para continuar</font>');
	$('#status_rut').fadeIn('slow');
	}
}); // fin continuar

//al apretar continuar control
$('#continuar-control').click(function(){
		
	if(document.getElementById('rut-control').value != ""){
	$('#campo_login-control').fadeOut('slow');
	$('#campo_login2').delay(100).fadeOut('slow');
	$('#link-login').delay(300).fadeIn('slow');
	$('#reload').delay(700).fadeIn('slow');
	
	queue:false;
	
	$('#campo_login-control').delay(300).hide();
	$('#campo_login2').delay(300).hide();
	//$('#rut').blur();
	
	//$('#status_rut').delay(500).fadeIn('slow');
	$('#todo2').delay(500).fadeIn('slow');	
	
	setTimeout(function() { $('#peso').focus(); }, 600);
	
	//$('#subir_ficha').delay(100).fadeOut('slow');
	
	}else{
	$('#status_rut').html('<font color="red">Debe ingresar el rut del pensionado para continuar</font>');
	$('#status_rut').fadeIn('slow');
	}
}); // fin continuar

//efecto al borrar las llamadas
$('#resetear_contactados').click(function(){
		
	$('#id_resetear_contactados').fadeOut('slow');
	//queue:false;
	
	$('#loading').delay(500).fadeIn('slow');
	
	var req = $.ajax({  
    type: "POST",  
    url: "codigos/check.php",  
    data: "aux=contactados",  
    success: function(msg){  
		   
		   $("#status_contactado").ajaxComplete(function(event, request, settings){ 
			
				if(msg == 'OK')
				{	
					
					$('#loading').delay(1000).fadeOut('slow');
					$('#loading_listo').delay(3000).fadeIn('slow');
					
				}  
				else  
				{  	}  	
		   });
		}
	   
	  }); 

}); // fin resetear contactos

//para que aparezca el man
$('#man').css({'opacity' : 0});
$('#man').animate({
    opacity: 1,
    left: '-=100',
	filter: ''
}, 1000);

//para que aparezca el man
$('#man2').css({'opacity' : 0});
$('#man2').animate({
    opacity: 1,
    left: '+=100',
	filter: ''
}, 1000);

//para que aparezca el man
$('#man-intro, #man-estadisticas').css({'opacity' : 0});
$('#man-intro, #man-estadisticas').animate({
    opacity: 1,
    left: '+=100',
	filter: ''
}, 1000);

//cambiar el valor al seleccionar el radiobutton
$('#btn_subir_ficha').click(function(){
	queue:false;
	$('#txt_subir_ficha').fadeOut('slow');
	
	$('#loading').delay(600).fadeIn('slow');

}); // fin subir ficha

/* funcion para verificar el peso */
$("#peso").blur(function() { 

	var peso = $("#peso").val();
	peso = peso.replace(/^\s*|\s*$/g,"");

	if(peso == ""){
	$('#imc_riesgo_tr').fadeOut('slow');
	$('#imc_entero').fadeOut('slow');
	$('#imc_riesgo_tr').style.display = "none";
	$('#imc_entero').style.display = "none";
	}

	if(document.getElementById('estatura').value != ""){

		var estatura = document.getElementById('estatura').value;
		
		//fecha de nacimiento
		var fecha = document.getElementById("date1").value;
		var n = fecha.split("-");
		
		var nac_dia = parseFloat(n[2]);
		var nac_mes = parseFloat(n[1]);
		var nac_anio = parseFloat(n[0]);
		
		var ahora = new Date();
		
		var dia_actual = ahora.getDate();
		var mes_actual = ahora.getMonth() + 1;
		var anio_actual = ahora.getFullYear();
		
		var edad = anio_actual - nac_anio;
		if(mes_actual == nac_mes){
			if(dia_actual < nac_dia){
				edad--;
			}
		}else if(mes_actual < nac_mes){
			edad--;
		}
		
		estatura = estatura.replace(/,/,".");
		peso = peso.replace(/,/,".");

		var imc = peso/(estatura*estatura);
		imc = imc.toFixed(1);
		var riesgo = 0;
		
		if(edad > 65){
			if((imc>= 23,1)&&(imc<=27,9)){
			riesgo = "Normalidad";
			}
			if(imc<=23){
			riesgo = "Enflaquecido";
			}
			if((imc>= 28)&&(imc<=31,9)){
			riesgo = "Sobrepeso";
			}
			if(imc>= 32){
			riesgo = "Obesidad";
			}
		}else{
			if((imc>= 18,5)&&(imc<=24,9)){
			riesgo = "Normalidad";
			}
			if(imc<=18,5){
			riesgo = "Enflaquecido";
			}
			if((imc>= 25)&&(imc<=29,9)){
			riesgo = "Sobrepeso";
			}
			if(imc>= 30){
			riesgo = "Obesidad";
			}
		}
		
		$('#imc_riesgo_tr').fadeIn('slow');
		$('#imc_entero').fadeIn('slow');
		document.getElementById('imc').value = imc;
		document.getElementById('imc_riesgo').value = riesgo;
		
	}else{
		document.getElementById('imc').value = "";
		document.getElementById('imc_riesgo').value = "";
	}

}); /* fin #peso */

/* funcion para verificar el peso-control */
$("#peso-control").blur(function() { 

	var peso = $("#peso-control").val();
	peso = peso.replace(/^\s*|\s*$/g,"");

	if(peso == ""){
	$('#imc_riesgo_tr').fadeOut('slow');
	$('#imc_entero').fadeOut('slow');
	$('#imc_riesgo_tr').style.display = "none";
	$('#imc_entero').style.display = "none";
	}

	if(document.getElementById('estatura-control').value != ""){

		var estatura = document.getElementById('estatura-control').value;
		var edad = document.getElementById('edad-control').value;
		
		estatura = estatura.replace(/,/,".");
		peso = peso.replace(/,/,".");

		var imc = peso/(estatura*estatura);
		imc = imc.toFixed(1);
		var riesgo = 0;
		
		if(edad > 65){
			if((imc>= 23,1)&&(imc<=27,9)){
			riesgo = "Normalidad";
			}
			if(imc<=23){
			riesgo = "Enflaquecido";
			}
			if((imc>= 28)&&(imc<=31,9)){
			riesgo = "Sobrepeso";
			}
			if(imc>= 32){
			riesgo = "Obesidad";
			}
		}else{
			if((imc>= 18,5)&&(imc<=24,9)){
			riesgo = "Normalidad";
			}
			if(imc<=18,5){
			riesgo = "Enflaquecido";
			}
			if((imc>= 25)&&(imc<=29,9)){
			riesgo = "Sobrepeso";
			}
			if(imc>= 30){
			riesgo = "Obesidad";
			}
		}
		
		$('#imc_riesgo_tr').fadeIn('slow');
		$('#imc_entero').fadeIn('slow');
		document.getElementById('imc-control').value = imc;
		document.getElementById('imc_riesgo-control').value = riesgo;
		
	}else{
		document.getElementById('imc-control').value = "";
		document.getElementById('imc_riesgo-control').value = "";
	}

}); /* fin #peso */

/* funcion para la estatura */
$("#estatura").blur(function() { 

	var estatura = $("#estatura").val();
	estatura = estatura.replace(/^\s*|\s*$/g,"");

	if(estatura == ""){
	$('#imc_riesgo_tr').fadeOut('slow');
	$('#imc_entero').fadeOut('slow');
	$('#imc_riesgo_tr').style.display = "none";
	$('#imc_entero').style.display = "none";
	}

	if(document.getElementById('peso').value != ""){

		var peso = document.getElementById('peso').value;
		
		//fecha de nacimiento
		var fecha = document.getElementById("date1").value;
		var n = fecha.split("-");
		
		var nac_dia = parseFloat(n[2]);
		var nac_mes = parseFloat(n[1]);
		var nac_anio = parseFloat(n[0]);
		
		var ahora = new Date();
		
		var dia_actual = ahora.getDate();
		var mes_actual = ahora.getMonth() + 1;
		var anio_actual = ahora.getFullYear();
		
		var edad = anio_actual - nac_anio;
		if(mes_actual == nac_mes){
			if(dia_actual < nac_dia){
				edad--;
			}
		}else if(mes_actual < nac_mes){
			edad--;
		}
		
		estatura = estatura.replace(/,/,".");
		peso = peso.replace(/,/,".");

		var imc = peso/(estatura*estatura);
		imc = imc.toFixed(1);
		var riesgo = 0;

		if(edad > 65){
			if((imc>= 23,1)&&(imc<=27,9)){
			riesgo = "Normalidad";
			}
			if(imc<=23){
			riesgo = "Enflaquecido";
			}
			if((imc>= 28)&&(imc<=31,9)){
			riesgo = "Sobrepeso";
			}
			if(imc>= 32){
			riesgo = "Obesidad";
			}
		}else{
			if((imc>= 18,5)&&(imc<=24,9)){
			riesgo = "Normalidad";
			}
			if(imc<=18,5){
			riesgo = "Enflaquecido";
			}
			if((imc>= 25)&&(imc<=29,9)){
			riesgo = "Sobrepeso";
			}
			if(imc>= 30){
			riesgo = "Obesidad";
			}
		}

		//queue:false;
		$('#imc_riesgo_tr').fadeIn('slow');
		$('#imc_entero').fadeIn('slow');
		document.getElementById('imc').value = imc;
		document.getElementById('imc_riesgo').value = riesgo;
		
	}else{
		document.getElementById('imc').value = "";
		document.getElementById('imc_riesgo').value = "";
	}

}); /* fin #estatura */

/* funcion para la estatura-control */
$("#estatura-control").blur(function() { 

	var estatura = $("#estatura-control").val();
	estatura = estatura.replace(/^\s*|\s*$/g,"");

	if(estatura == ""){
	$('#imc_riesgo_tr').fadeOut('slow');
	$('#imc_entero').fadeOut('slow');
	$('#imc_riesgo_tr').style.display = "none";
	$('#imc_entero').style.display = "none";
	}

	if(document.getElementById('peso-control').value != ""){

		var peso = document.getElementById('peso-control').value;
		var edad = document.getElementById('edad-control').value;
		
		
		
		estatura = estatura.replace(/,/,".");
		peso = peso.replace(/,/,".");

		var imc = peso/(estatura*estatura);
		imc = imc.toFixed(1);
		var riesgo = 0;

		if(edad > 65){
			if((imc>= 23,1)&&(imc<=27,9)){
			riesgo = "Normalidad";
			}
			if(imc<=23){
			riesgo = "Enflaquecido";
			}
			if((imc>= 28)&&(imc<=31,9)){
			riesgo = "Sobrepeso";
			}
			if(imc>= 32){
			riesgo = "Obesidad";
			}
		}else{
			if((imc>= 18,5)&&(imc<=24,9)){
			riesgo = "Normalidad";
			}
			if(imc<=18,5){
			riesgo = "Enflaquecido";
			}
			if((imc>= 25)&&(imc<=29,9)){
			riesgo = "Sobrepeso";
			}
			if(imc>= 30){
			riesgo = "Obesidad";
			}
		}

		//queue:false;
		$('#imc_riesgo_tr').fadeIn('slow');
		$('#imc_entero').fadeIn('slow');
		document.getElementById('imc-control').value = imc;
		document.getElementById('imc_riesgo-control').value = riesgo;
		
	}else{
		document.getElementById('imc-control').value = "";
		document.getElementById('imc_riesgo-control').value = "";
	}

}); /* fin #estatura */

/* funcion para la cintura */
$("#cintura").change(function() { 

	var cintura = $("#cintura").val();
	cintura = cintura.replace(/^\s*|\s*$/g,"");
	cintura = cintura.replace(/,/,".");

	if(cintura == ""){
		$('#riesgo_cintura').fadeOut('slow');
		$('#riesgo_cintura').style.display = "none";
	}

	if(document.getElementById('sexo').value != ""){

		for (var i=0; i < document.crear_ficha.sexo.length; i++)
	   {
	   if (document.crear_ficha.sexo[i].checked)
		  {
		  var valor_sexo = document.crear_ficha.sexo[i].value;
		  }
	   }

		var riesgo_sexo = 0;
		if((valor_sexo == 1)||(valor_sexo == 2)){

		if(valor_sexo == 1){
		
			if(cintura<94){
			riesgo_sexo = "Saludable";
			}
			if((cintura>= 94)&&(cintura<102)){
			riesgo_sexo = "Riesgo moderado";
			}
			if(cintura>= 102){
			riesgo_sexo = "Riesgo alto";
			}
		}else{
		
			if(cintura<80){
			riesgo_sexo = "Saludable";
			}
			if((cintura>= 80)&&(cintura<87)){
			riesgo_sexo = "Riesgo moderado";
			}
			if(cintura>= 88){
			riesgo_sexo = "Riesgo alto";
			}
		}
		
		$('#cintura_riesgo').val(riesgo_sexo);
		$('#riesgo_cintura').fadeIn('slow');

		} 
	
	}else{
		document.getElementById('cintura_riesgo').value = "";
	}

}); /* fin #cintura */

/* funcion para la cintura-control */
$("#cintura-control").change(function() { 

	var cintura = $("#cintura-control").val();
	cintura = cintura.replace(/^\s*|\s*$/g,"");
	cintura = cintura.replace(/,/,".");

	if(cintura == ""){
		$('#riesgo_cintura').fadeOut('slow');
		$('#riesgo_cintura').style.display = "none";
	}

	var valor_sexo = document.getElementById('sexo-control').value;

		var riesgo_sexo = 0;
		if((valor_sexo == 1)||(valor_sexo == 2)){

		if(valor_sexo == 1){
		
			if(cintura<94){
			riesgo_sexo = "Saludable";
			}
			if((cintura>= 94)&&(cintura<102)){
			riesgo_sexo = "Riesgo moderado";
			}
			if(cintura>= 102){
			riesgo_sexo = "Riesgo alto";
			}
		}else{
		
			if(cintura<80){
			riesgo_sexo = "Saludable";
			}
			if((cintura>= 80)&&(cintura<87)){
			riesgo_sexo = "Riesgo moderado";
			}
			if(cintura>= 88){
			riesgo_sexo = "Riesgo alto";
			}
		}
		
		$('#cintura_riesgo-control').val(riesgo_sexo);
		$('#riesgo_cintura').fadeIn('slow');

		} 

}); /* fin #cintura-control */

//cambiar el valor al seleccionar el radiobutton sexo
$('input[name="sexo"]').click(function(){

for (var i=0; i < document.crear_ficha.sexo.length; i++)
   {
   if (document.crear_ficha.sexo[i].checked)
      {
      var valor_sexo = document.crear_ficha.sexo[i].value;
      }
   }

if(document.getElementById('cintura').value != ""){

var cintura = document.getElementById('cintura').value;
var riesgo_sexo = 0;
	if(valor_sexo == 1){
		if(cintura<94){
		riesgo_sexo = "Saludable";
		}
		if((cintura>= 94)&&(cintura<102)){
		riesgo_sexo = "Riesgo moderado";
		}
		if(cintura>= 102){
		riesgo_sexo = "Riesgo alto";
		}
	}else{
		if(cintura<80){
		riesgo_sexo = "Saludable";
		}
		if((cintura>= 80)&&(cintura<87)){
		riesgo_sexo = "Riesgo moderado";
		}
		if(cintura>= 88){
		riesgo_sexo = "Riesgo alto";
		}
	}
	$('#riesgo_cintura').fadeIn('slow');
	document.getElementById('cintura_riesgo').value = riesgo_sexo;
	
}

}); // fin radiobutton sexo

//cambiar el valor al seleccionar el radiobutton sexo
$('input[name="sexo"]').click(function(){

for (var i=0; i < document.crear_ficha.sexo.length; i++)
   {
   if (document.crear_ficha.sexo[i].checked)
      {
      var valor_sexo = document.crear_ficha.sexo[i].value;
      }
   }

	if(valor_sexo == 1){
		$('#urologo').fadeIn('slow');
		$('#ginecologo').fadeOut('slow');
	}else{
		$('#urologo').fadeOut('slow');
		$('#ginecologo').fadeIn('slow');
	}

}); // fin radiobutton pregunta51

//cambiar el valor al seleccionar el radiobutton sexo
$('input[name="pregunta52"]').click(function(){

for (var i=0; i < document.crear_ficha.pregunta52.length; i++)
   {
   if (document.crear_ficha.pregunta52[i].checked)
      {
      var valor = document.crear_ficha.pregunta52[i].value;
      }
   }

	if(valor == 1){
		$('#lacteos').fadeOut('slow');
	}else{
		$('#lacteos').fadeIn('slow');
	}

}); // fin radiobutton sexo

//cambiar el valor al seleccionar el radiobutton sexo
$('input[name="pregunta12"]').click(function(){

for (var i=0; i < document.crear_ficha.pregunta12.length; i++)
   {
   if (document.crear_ficha.pregunta12[i].checked)
      {
      var valor = document.crear_ficha.pregunta12[i].value;
      }
   }

	if(valor == 1){
		$('#act_fisica').fadeOut('slow');
	}else{
		$('#act_fisica').css('visibility','visible').fadeIn('slow');
	}

}); // fin radiobutton sexo

//cambiar el valor al seleccionar el radiobutton pregunta1
$('input[name="pregunta1"]').click(function(){

for (var i=0; i < document.crear_ficha.pregunta1.length; i++)
   {
   if (document.crear_ficha.pregunta1[i].checked)
      {
      var valor = document.crear_ficha.pregunta1[i].value;
      }
   }

	if(valor == 1){
		$('#subpregunta1a, #subpregunta1b, #subpregunta1c, #subpregunta1d').fadeIn('slow');
	}else{
		$('#subpregunta1a, #subpregunta1b, #subpregunta1c, #subpregunta1d').fadeOut('slow');
	}
	
}); // fin radiobutton pregunta1

//cambiar el valor al seleccionar el radiobutton pregunta9
$('input[name="pregunta9"]').click(function(){

for (var i=0; i < document.crear_ficha.pregunta9.length; i++)
   {
   if (document.crear_ficha.pregunta9[i].checked)
      {
      var valor = document.crear_ficha.pregunta9[i].value;
      }
   }

	if(valor == 1){
		$('#tipo_sal').fadeIn('slow');
	}else{
		$('#tipo_sal').fadeOut('slow');
	}
	
}); // fin radiobutton pregunta9

//cambiar el valor al seleccionar el radiobutton pregunta11
$('input[name="pregunta11"]').click(function(){

for (var i=0; i < document.crear_ficha.pregunta11.length; i++)
   {
   if (document.crear_ficha.pregunta11[i].checked)
      {
      var valor = document.crear_ficha.pregunta11[i].value;
      }
   }

	if(valor == 0){
		$('#actividad').fadeIn('slow');
	}else{
		$('#actividad').fadeOut('slow');
	}
	
}); // fin radiobutton pregunta11

//cambiar el valor al seleccionar el radiobutton pregunta12
$('input[name="pregunta12"]').click(function(){

for (var i=0; i < document.crear_ficha.pregunta12.length; i++)
   {
   if (document.crear_ficha.pregunta12[i].checked)
      {
      var valor = document.crear_ficha.pregunta12[i].value;
      }
   }

	if(valor == 1){
		$('#intensidad').fadeIn('slow');
	}else{
		$('#intensidad').fadeOut('slow');
	}
	
}); // fin radiobutton pregunta12

//cambiar el valor al seleccionar el radiobutton control1
$('input[name="control1"]').click(function(){

for (var i=0; i < document.crear_ficha.control1.length; i++)
   {
   if (document.crear_ficha.control1[i].checked)
      {
      var valor = document.crear_ficha.control1[i].value;
      }
   }

	if(valor == 0){
		$('#div-control11').fadeIn('slow');
	}else{
		$('#div-control11').fadeOut('slow');
	}
	
}); // fin radiobutton control1

//cambiar el valor al seleccionar el radiobutton control2
$('input[name="control2"]').click(function(){

for (var i=0; i < document.crear_ficha.control2.length; i++)
   {
   if (document.crear_ficha.control2[i].checked)
      {
      var valor = document.crear_ficha.control2[i].value;
      }
   }

	if(valor == 0){
		$('#div-control21').fadeIn('slow');
	}else{
		$('#div-control21').fadeOut('slow');
	}
	
}); // fin radiobutton control2

//cambiar el valor al seleccionar el radiobutton control3
$('input[name="control3"]').click(function(){

for (var i=0; i < document.crear_ficha.control3.length; i++)
   {
   if (document.crear_ficha.control3[i].checked)
      {
      var valor = document.crear_ficha.control3[i].value;
      }
   }

	if(valor == 0){
		$('#div-control31').fadeIn('slow');
		$('#div-control32').fadeOut('slow');
	}else{
		$('#div-control31').fadeOut('slow');
		$('#div-control32').fadeIn('slow');
	}
	
}); // fin radiobutton control3

//cambiar el valor al seleccionar el drop de regiones
$('#region').change(function(){

	var region = $("#region").val();
	//usr = usr.replace(/^\s*|\s*$/g,"");
	
	
	if(region != '999999'){
	
	var req = $.ajax({  
    type: "POST",  
    url: "codigos/check.php",  
    data: "region="+ region +"&aux=region",  
    success: function(rpta){  
	
		   var msg = rpta.split("%");
		   
		   $("#status_region").ajaxComplete(function(event, request, settings){ 
			
				if(msg[0] == 'OK')
				{	
					
					var options = '';
      					
					for(var i=1;i < msg.length; i++){
					options += '<option value="' + (i-1) + '">' + msg[i] + '</option>';
					$("#ciudad").html(options);
					
					}
					$('#region').val(region);
				}  
				else  
				{  	}  	
		   });
		}
	   
	  }); 
		
		$('#ciudades').fadeIn('slow');
		
	}else{
		$('#ciudades').fadeOut('slow');
	}
	
}); // fin drop regiones

//cambiar el valor al seleccionar el drop de regiones del call center
$('#call_region').change(function(){

	var region = $("#call_region").val();
	//usr = usr.replace(/^\s*|\s*$/g,"");
	
	
	if(region != '999999'){
	
	var req = $.ajax({  
    type: "POST",  
    url: "codigos/check.php",  
    data: "region="+ region +"&aux=call_region",  
    success: function(rpta){  
	
		   var msg = rpta.split("-");
		   
		   $("#status_region").ajaxComplete(function(event, request, settings){ 
			
				if(msg[0] == 'OK')
				{	
					
					var options = '';
      					
					for(var i=1;i <= (msg.length / 2); i++){
					options += '<option value="' + (i-1) + '">' + msg[(2*i)-1] + ' - '+ msg[2*i] +' persona(s)</option>';
					$("select#call_ciudad").html(options);
					
					}
					$('#call_region').val(region);
				}  
				else  
				{  	}  	
		   });
		}
	   
	  }); 
		
		$('#ciudades').fadeIn('slow');
		
	}else{
		$('#ciudades').fadeOut('slow');
	}
	
}); // fin drop call center regiones

//función para colocar en 0 el valor de pregunta10a al hacer click
$('#pregunta10a').focus(function(){

if($('#pregunta10a').val() == 0)
$('#pregunta10a').val('');

});

//función para colocar en 0 el valor de pregunta10a al hacer click
$('#pregunta10a').blur(function(){

if($('#pregunta10a').val()=='')
	$('#pregunta10a').val('0');

});

//función para colocar en 0 el valor de pregunta10b al hacer click
$('#pregunta10b').focus(function(){

if($('#pregunta10b').val() == 0)
$('#pregunta10b').val('');

});

//función para colocar en 0 el valor de pregunta10a al hacer click
$('#pregunta10b').blur(function(){

if($('#pregunta10b').val()=='')
	$('#pregunta10b').val('0');

});

//función para colocar en 0 el valor de pregunta10c al hacer click
$('#pregunta10c').focus(function(){

if($('#pregunta10c').val() == 0)
$('#pregunta10c').val('');

});

//función para colocar en 0 el valor de pregunta10a al hacer click
$('#pregunta10c').blur(function(){

if($('#pregunta10c').val()=='')
	$('#pregunta10c').val('0');

});


});

 /* funcion para ver que no se dejen campos vacíos y estén correctos los campos*/
function validate(f)
	 {
		var defaultFocus=null;
		var datos="Debe llenar todos los campos obligatorios para crear la ficha";

		for(var i=0,limit=f.elements.length; i < limit; ++i )
		{
			if((i != 10)&&(i < 18)&&(i != 6)){
					if( f.elements[i].value=="" )
					{
						f.elements[i].style.border="1px solid";
						f.elements[i].style.borderColor="#ffa302";
						if( defaultFocus == null )
						{
							defaultFocus=f.elements[i];
						}
					}
					else
					{
						/*f.elements[i].style.backgroundColor="#ffffff";*/
					}
				}
		}
		if( defaultFocus )
		{
			alert(datos);
			defaultFocus.focus();
			return false;
		}else{
						
		}
return true;
	 }
	 
function searchKeyPress(e)
        {
                // look for window.event in case event isn't passed in
                if (window.event) { e = window.event; }
                if (e.keyCode == 13)
                {
						document.getElementById('continuar').click();
						document.getElementById('continuar-control').click();
						e.preventDefault();						
                }
        }

function disableEnterKey(e)
{
     var key;

     if(window.event)
          key = window.event.keyCode;     //IE
     else
          key = e.which;     //firefox

     if(key == 13)
          return false;
     else
          return true;
}

//habilitar los campos al editar
function editar(){

	document.crear_ficha.nombre.readOnly = false;
	document.crear_ficha.edad.readOnly = false;
	document.crear_ficha.telefono.readOnly = false;
	document.crear_ficha.correo.readOnly = false;
	
	$('#editar').fadeOut('slow');
	
	setTimeout(function() { document.getElementById('sexo_radio').style.display = "block"; }, 400);
	 
	$('#sexo_texto').fadeOut('fast');
} // fin editar

//poner visible el campo para editar el peso
function editar_peso(){
	
	$('#peso_plano').fadeOut('slow');
	$('#span_peso').fadeIn('slow');
	
	$('#imc_plano').fadeOut('slow');
	$('#span_imc').fadeIn('slow');
	
	$('#riesgo_imc_plano').fadeOut('slow');
	$('#span_riesgo_imc').fadeIn('slow');
	
	$('').fadeIn('slow');
	$('').fadeIn('slow');
	
	$('#boton_editar_peso').fadeOut('slow');
	
	
} // fin editar

$(function() {
	$("#icoHelp").mouseover(function(event) {
		$("#capaHelp").animate({width: 'toggle'});
	});
	$("#icoHelp").mouseout(function(event) {
	setTimeout(function() { $("#capaHelp").animate({width: 'toggle'}); }, 1500);
		
	});
});

$(function() {
	$("#icoHelp2").mouseover(function(event) {
		$("#capaHelp2").animate({width: 'toggle'});
	});
	$("#icoHelp2").mouseout(function(event) {
	setTimeout(function() { $("#capaHelp2").animate({width: 'toggle'}); }, 1500);
		
	});
});

$(function() {
	$("#icoHelp2").mouseover(function(event) {
		$("#capaHelp2b").animate({width: 'toggle'});
	});
	$("#icoHelp2").mouseout(function(event) {
	setTimeout(function() { $("#capaHelp2b").animate({width: 'toggle'}); }, 1500);
		
	});
});

$(function() {
	$("#icoHelp3").mouseover(function(event) {
		$("#capaHelp3").animate({width: 'toggle'});
	});
	$("#icoHelp3").mouseout(function(event) {
	setTimeout(function() { $("#capaHelp3").animate({width: 'toggle'}); }, 1500);
		
	});
});

$(function() {
	$("#icoHelp4").mouseover(function(event) {
		$("#capaHelp4").animate({width: 'toggle'});
	});
	$("#icoHelp4").mouseout(function(event) {
	setTimeout(function() { $("#capaHelp4").animate({width: 'toggle'}); }, 1500);
		
	});
});

/* FUNCIONES PARA LA PÁGINA DE LAS ESTADÍSTICAS */
function mostrar(tipo){
	
	$('#'+tipo).slideToggle('slow');
	
} // fin mostrar tipo
