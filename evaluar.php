<?php
header('P3P: CP="CAO PSA OUR"');
ob_start();
session_start();

ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include 'constantes.php';
include 'codigos/funciones.php';

require_once('calendar/classes/tc_calendar.php');

if($_SESSION['user'] != 'evaluador'){
$_SESSION['rut'] == null;
$_SESSION['nombre'] = null;
header("Location: login.php");
}

$rut = $_SESSION['rut'];
$nombre = $_SESSION['nombre'];

if($rut == null){
header("Location: login.php");
}

//sacando las regiones
$region = get_regiones();  

//sacando los centros
$centro = get_centros();		

?>
<?php get_header('Evaluación de Pensionados'); ?>
<script type="text/javascript">

function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if (evt.keyCode == 13)  {return false;}
}

document.onkeypress = stopRKey;

</script> 

	<div id="contenido" class="container">
		<div id="titulo-evaluacion-pensionados1" class="span-20 push-6">
			<span class="titulo2 amarillo">Encuesta y Mediciones</span>
		</div>
		<div id="bg_rut" class="span-20 push-4">
			<div id="campo_login">
				<span class="titulo-ingrese">Ingrese el rut del pensionado para crear su ficha.</span>
			</div>
			<form name="crear_ficha" id="crear_ficha" method="post" action="codigos/success.php?tipo=crear_ficha">
			<div id="campo_login2">
				<table class="span-20" border="0">
					<tr>
						<td class="span-2"><label for="rut" class="label-rut">RUT:</label></td>
						<td class="span-6"><input id="rut" type="text" name="rut" maxlength="20" onkeypress="searchKeyPress(event);"></td>
						<td class="span-10"><div id="btn-continuar"><a name="continuar" id="continuar" href="#"></a></div></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2"><div class="usuario-nuevo" id="status_rut"></div></td>
						
					</tr>
				</table>
			</div>
			<div id="link-login" class="span-20">
				<div id="reload" class="span-12 push-5 frutiger"><a href="javascript:window.location.reload();">Ingresar otro usuario</a></div>
			</div>
		</div>
      <div style="margin:0;" id="todo" class="span-24 frutiger">
        <br />
        <div id="titulo-informacion-basica" class="span-17 push-7">
			<span class="titulo2 amarillo">Informaci&oacute;n B&aacute;sica</span>
        	<span id="editar"><a id="" href="javascript:editar();"><img src="images/btn-editar.png" width="96" alt="Editar"/></a></span>
		</div>
        <table class="span-20 push-4" border="0">
        <tr><td width="205"></td></tr>
		<tr id="regiones">
        <td class="td-derecha"><label for="region">Lugar de evaluaci&oacute;n:</label></td>
        <td>
        <SELECT id="region" name="region" SIZE="1">
            <OPTION VALUE="999999" selected>Seleccione regi&oacute;n</OPTION>
			<?php 
			
			for($i = 0; $i < count($region); $i++){
			
				echo '<OPTION VALUE="'.$region[$i][0].'">'.$region[$i][1].'</OPTION>';
				
			}?>
        </SELECT> 
        </td><td></td>
		</tr>
		</table>
		<table class="span-20 push-4" border="0">
		<tr id="ciudades">
        <td class="td-derecha"><label for="ciudad">Ciudad/Comuna:</label></td>
        <td>
        <SELECT id="ciudad" name="ciudad" SIZE="1">
            <OPTION VALUE="999999" selected>Seleccione ciudad/comuna</OPTION>
			<?php 
			
			for($i = 0; $i < count($region); $i++){

				echo '<OPTION VALUE="'.$i.'">'.$region[$i].'</OPTION>';
				
			}?>
        </SELECT> 
        </td><td><div class="usuario-nuevo" id="status_region"></div></td>
        </tr>
		</table>
		<table class="span-20 push-4" border="0">
		<tr id="centros">
        <td class="td-derecha"><label for="centro">Centro M&eacute;dico cercano:</label></td>
        <td>
        <SELECT id="centro" name="centro" SIZE="1">
            <OPTION VALUE="999999" selected>Seleccione el centro m&eacute;dico</OPTION>
			<?php 
			
			for($i = 0; $i < count($centro); $i++){

				echo '<OPTION VALUE="'.$centro[$i][0].'">'.$centro[$i][1].'</OPTION>';
				
			}?>
        </SELECT> 
        </td>
        </tr>
		</table>
		<div id="barra-separadora" class="span-24"></div>
		<div id="div_afiliado">
			<table class="span-20 push-4" border="0">
			<tr>
			<td class="td-derecha"><label for="afiliado">Tipo de afiliado:</label></td>
			<td><SELECT id="afiliado" name="afiliado" SIZE="1">
				<option value="0" selected>Pensionado</option>
				<option value="1">Trabajador</option>
				<option value="2">Otros</option>
			</SELECT></td>
			<td></td>
			</tr>
			</table>
		</div>
		<table class="span-20 push-4" border="0">
		<tr>
        <td class="td-derecha"><label for="nombre">Nombre completo:</label></td>
        <td><input id="nombre" type="text" name="nombre"  maxlength="100"></td>
        <td></td>
        </tr>
		</table>
		<div id="cuadro_edad">
			<table class="span-20 push-4" border="0">
			<tr>
			<td class="td-derecha"><label for="edad">Edad:</label></td>
			<td><input id="edad" type="text" name="edad"  maxlength="10"></td>
			<td class="td-izquierda">A&ntilde;os</td>
			</tr>
			</table>
		</div>
		<div id="div_fecha">
		<table class="span-20 push-4" border="0">
		<tr>
			<td class="td-derecha"><label for="fecha_nac">Fecha de nacimiento:</label></td>
			<td><?php
					  $myCalendar = new tc_calendar("date1", true);
					  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
					  $myCalendar->setDate(date('d'), date('m'), date('Y'));
					  $myCalendar->setPath("calendar/");
					  $myCalendar->startMonday(true);
					  $myCalendar->setYearInterval(1900, 2015);
					  $myCalendar->dateAllow('1900-01-01', '2015-03-01');
					  //$myCalendar->setHeight(350);
					  //$myCalendar->autoSubmit(true, "form1");
					  //$myCalendar->setSpecificDate(array("2011-04-01", "2011-04-13", "2011-04-25"), 0, 'month');
					  //$myCalendar->setOnChange("myChanged('test')");
					  //$myCalendar->rtl = true;
					  $myCalendar->writeScript();
					  ?>
			</td>
		
		</tr>
		</table>
		</div>
		<table class="span-20 push-4" border="0">
        <tr>
        <td class="td-derecha"><label for="sexo">Sexo:</label></td>
        <td><input id="sexo_texto" type="text" name="sexo_texto"  maxlength="10"><div id="sexo_radio"><Input type='Radio' id="sexo" name="sexo" value="1" checked="checked">
            Masculino
            <Input type='Radio' id="sexo" name="sexo" value="2">
            Femenino</div></td>
        <td><div id="status_sexo"></div></td>
        </tr>
        <tr>
        <td class="td-derecha"><label for="telefono">Tel&eacute;fono:</label></td>
        <td><input id="telefono" type="text" name="telefono"  maxlength="20"></td>
        </tr>
        <tr>
        <td class="td-derecha"><label for="correo">Correo electr&oacute;nico (opcional):</label></td>
        <td><input id="correo" type="text" name="correo"  maxlength="40"></td>
        
        </tr>
		</table>
        <?php if($_SESSION['permiso']==2){?>
        
        <!-- preguntas sobre salud, nutrición y actividad física / código protegido -->
        
        <?php }?>
        <table class="span-10 push-10" border="0">
        <tr> 
        <td><div id="btn-crear-ficha">
            <input type="image" name="send" id="send" value="Crear ficha" img src="images/btn-crear-ficha.png" width="146" height="36">
        </div></td>
        </tr>
        </table>
        </div>
        </form>
		
		<!-- botón para volver -->
		<div id="texto-volver" class="span-24 centrado frutiger blanco-mediana"><a href="evaluar-opciones.php">Volver</a></div>
	</div>
	<!--start contactable -->
<div id="my-contact-div" class="frutiger"><!-- contactable html placeholder --></div>

<link rel="stylesheet" href="css/contactable.css" type="text/css" />

<script type="text/javascript" src="js/jquery.min-1.7.2.js"></script>
<script type="text/javascript" src="js/jquery.contactable.js"></script>

<script>
	jQuery(function(){
		jQuery('#my-contact-div').contactable(
        {
            
        });
	});
</script>
<!--end contactable -->
<?php get_footer();?>
