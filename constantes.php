<?php
$rut = $_SESSION['rut'];
$nombre = $_SESSION['nombre'];

$userbox = ($nombre != null)? "<div id=\"barra-separadora-header\" class=\"span-1\"></div><div id=\"userbox\" class=\"span-3\"><span class=\"texto-userbox span-2\">$nombre</span><div id=\"btn-salir\" class=\"span-1\"><a href=\"codigos/success.php?tipo=logout\"></a></div></div>":"";

$logo = '<img src="images/logo-comunidad-losheroes-top.png" width="242" height="139" alt="Comunidad Los H&eacute;roes" />';
$logo2 = '<img src="images/logo-losheroes-top.png" width="242" height="139" alt="Los H&eacute;roes" />';
$homepage = 'http://www.comunidadlh.cl';
$footer = 'Todos los derechos reservados a SpeedWorks S.A. | Si tienes alg&uacute;n problema con la utilizaci&oacute;n de esta plataforma, cont&aacute;ctanos a <a href="mailto:soporte@comunidadlh.cl">soporte@comunidadlh.cl</a>';
$empresa = 'Comunidad Los H&eacute;roes';

$pagina2 = basename($_SERVER['PHP_SELF'], ".php");

function get_header($titulo){
  global $logo, $logo2, $homepage, $empresa, $userbox, $pagina, $pagina2;

	$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">';
	if($pagina2 == 'exito'):
		$header.='<meta http-equiv="refresh" content="5; URL='.$pagina.'">';
	endif;
	$header.= '<head>
<!-- *****************************************
	 *										 *
   	 *		Software desarrollado por		 *
	 *		Hugo Borquez R.					 *
 	 *		hugo.borquez@xap.cl 			 *
	 *										 *
	 ***************************************** -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Expires" content="-1">
<title>'.$titulo.' | '.$empresa.'</title>
<!-- incluyendo jquery -->
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="js/jquery.min-1.7.2.js"></script>
<script type="text/javascript" src="js/jquery-1.4.1.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
<link href="calendar/calendar.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	<script type="text/javascript">
		$(document).ready(function() {

			$("#various2").fancybox({
				width				: 850,
				height			: 550,
				autoScale			: false,
				transitionIn	: \'elastic\',
				transitionOut	: \'elastic\',
				type				: \'iframe\'
			});
			
			$(".botonExcel").click(function(event) {
					$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
					$("#FormularioExportacion").submit();
			});
		});
	</script>
<script type="text/javascript" src="js/jquery.pngfix.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("img[@src$=png], #contenido").pngfix();			
		// $.miseAlphaImageLoader("sdsd");
	});
</script>

<!-- Framework CSS -->  
    <link rel="stylesheet" href="blueprint/screen.css" type="text/css" media="screen, projection" />  
	<link rel="stylesheet" href="blueprint/print.css" type="text/css" media="print" />  
  <!--[if IE]><link rel="stylesheet" href="blueprint/ie.css" type="text/css" media="screen, projection" /><![endif]-->  
  <!--[if lte IE 7]><link rel="stylesheet" href="blueprint/ie6.css" type="text/css" media="screen, projection" /><![endif]-->
  
  <!-- Import fancy-type plugin. -->  
  <link rel="stylesheet" href="blueprint/plugins/fancy-type/screen.css" type="text/css" media="screen, projection" />

<SCRIPT type="text/javascript">
<!--
$(document).ready(function(){
$(\'#login_rut\').focus();
});
//-->
</SCRIPT>
<!-- script para imprimir el div-->
<script type="text/javascript">
	function PrintContent()
	{
		var DocumentContainer = document.getElementById(\'parte_imprimir\');
		var printDivCSS = new String (\'<link rel="stylesheet" href="blueprint/screen.css" type="text/css" media="screen, projection" /><link rel="stylesheet" href="blueprint/print.css" type="text/css" media="print" /><!--[if IE]><link rel="stylesheet" href="blueprint/ie.css" type="text/css" media="screen, projection" /><![endif]--><!--[if lte IE 7]><link rel="stylesheet" href="blueprint/ie6.css" type="text/css" media="screen, projection" /><![endif]--><link rel="stylesheet" href="blueprint/plugins/fancy-type/screen.css" type="text/css" media="screen, projection" />\'); 
		var WindowObject = window.open(\'\', "PrintWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		WindowObject.document.writeln(printDivCSS + DocumentContainer.innerHTML);
		WindowObject.document.close();
		WindowObject.focus();
		WindowObject.print();
		WindowObject.close();
		
		';
		if($pagina2 == 'metas-control-antiguo'):
			$header.='window.close()';
		else:
			$header.='window.setTimeout(\'location.href="evaluar.php";\',5000)';
		endif;
		$header.='
	}
	
	</script>
</head>
<body id="parte_imprimir" class="bg">
<div id="header_bg">
	<div id="header" class="container">
		<div class="span-24">
			<div id="logo" class="span-4"><a href="'.$homepage.'">';
			if($pagina2 == 'index'):
				$header.= $logo2;
			else:
				$header.= $logo;
			endif;
			$header.='</a></div>
			<div id="espacio-medio" class="span-11"><h1></h1></div>
			<div id="espacio-user" class="span-8">'.$userbox.'</div>
		</div>
	</div>
</div>
<div class="container"><div id="sombra-header"></div></div>
<div id="marco">';

    echo $header;
}

function get_header_estadisticas($titulo){
	global $logo, $logo2, $homepage, $empresa, $userbox, $pagina, $pagina2;

	$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">';

	$header.= '<head>
<!-- *****************************************
	 *										 *
   	 *		Software desarrollado por		 *
	 *		Hugo Borquez R.					 *
 	 *		hugo.borquez@xap.cl 			 *
	 *										 *
	 ***************************************** -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Expires" content="-1">
<title>'.$titulo.' | '.$empresa.'</title>
<!-- incluyendo jquery -->
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="js/excanvas.js"></script><![endif]-->
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="js/jquery.min-1.7.2.js"></script>
<script type="text/javascript" src="js/jquery-1.4.1.js"></script>

<!-- BEGIN: load jqplot -->
<script language="javascript" type="text/javascript" src="js/jquery.jqplot.js"></script>
<script language="javascript" type="text/javascript" src="js/jqplot.pieRenderer.js"></script>
<!-- END: load jqplot -->

<script type="text/javascript" src="js/funciones.js"></script>';

echo $header;
}

function get_header_estadisticas2(){
global $logo, $logo2, $homepage, $empresa, $userbox, $pagina, $pagina2;

$header2 = '<link href="calendar/calendar.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script type="text/javascript" src="js/jquery.pngfix.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("img[@src$=png], #contenido").pngfix();			
		// $.miseAlphaImageLoader("sdsd");
	});
</script>

<!-- Framework CSS -->  
    <link rel="stylesheet" href="blueprint/screen.css" type="text/css" media="screen, projection" />  
	<link rel="stylesheet" href="blueprint/print.css" type="text/css" media="print" />  
  <!--[if IE]><link rel="stylesheet" href="blueprint/ie.css" type="text/css" media="screen, projection" /><![endif]-->  
  <!--[if lte IE 7]><link rel="stylesheet" href="blueprint/ie6.css" type="text/css" media="screen, projection" /><![endif]-->
  
  <!-- JQPLOT CSS -->
  <link href="css/jquery.jqplot.css" rel="stylesheet" type="text/css" media="screen, projection"/>
  
  <!-- Import fancy-type plugin. -->  
  <link rel="stylesheet" href="blueprint/plugins/fancy-type/screen.css" type="text/css" media="screen, projection" />

<SCRIPT type="text/javascript">
<!--
$(document).ready(function(){
$(\'#login_rut\').focus();
});
//-->
</SCRIPT>

</head>
<body id="parte_imprimir" class="bg">
<div id="header_bg">
	<div id="header" class="container">
		<div class="span-24">
			<div id="logo" class="span-4"><a href="'.$homepage.'">';
			
			$header2.= $logo;
			
			$header2.='</a></div>
			<div id="espacio-medio" class="span-11"><h1></h1></div>
			<div id="espacio-user" class="span-8">'.$userbox.'</div>
		</div>
	</div>
</div>
<div class="container"><div id="sombra-header"></div></div>
<div id="marco">';

    echo $header2;
}

function get_footer(){
	global $footer, $empresa, $logo;
	
	echo '</div>
	<div id="footer_bg">
		<div id="footer_bg_barras">
			<div id="footer" class="container">
				<div id="footer_bg2" class="span-24 centrado">
					<div id="footer_barras" class="span-2"></div>
					<div id="footer_logo" class="span-18 push-4"></div>
					<div id="footer_logo-original" class="span-4 push-4">'.$logo.'</div>
					<div id="footer_cuadro" class="span-2 push-9">
						<div class="texto-cuadro-footer">Si tienes alg&uacute;n problema con la utilizaci&oacute;n de esta plataforma, cont&aacute;ctanos a <a href="mailto:soporte@comunidadlh.cl">soporte@comunidadlh.cl</a></div>
					</div>
				</div>
				<div class="texto-footer span-24" id="datos">'.$footer.'</div>
			</div>
		</div>
	</div>
	</body>
	</html>';
}
