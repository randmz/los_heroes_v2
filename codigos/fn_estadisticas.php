<?php
session_start();

///////////////////////////////////////
//                                   //
//    Código por Hugo Bórquez R.     //
//    pugopugo@hotmail.com           //
//                                   //
///////////////////////////////////////

// FUNCIONES DE ESTADÍSTICAS!!!!

ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

//función para sacar la información de la ficha de un usuario
function get_estadisticas_basicas(){
	
	include 'trash/conn.php';

	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);

	if($conecta){
		session_start();
		
		// sacando los id de las metas para una ficha
		$sql_check = mysql_query("SELECT u.Rut, u.Tipo_afiliado, u.Nombre, u.Nac_dia, u.Nac_mes, u.Nac_anio, u.Edad, u.Telefono, u.Sexo, r.Nombre_region, c.Sucursal, ce.Nombre_centro, u.Correo, f.Id_ficha, f.Evaluador, f.Fecha, f.Hora FROM (SELECT Rut_Pensionado, MAX(Id_ficha) as Max_ficha FROM ficha GROUP BY Rut_pensionado) as x LEFT JOIN ficha as f on f.Rut_pensionado = x.Rut_pensionado AND f.Id_ficha = x.Max_ficha LEFT JOIN usuarios AS u ON u.Rut = x.Rut_pensionado LEFT JOIN info_regiones AS r ON u.Region = r.Numero_region LEFT JOIN info_ciudades AS c ON u.Region = c.Numero_region AND u.Ciudad = c.Numero_ciudad LEFT JOIN info_centros AS ce ON u.Centro = ce.Numero_centro");
		
		$total = mysql_num_rows($sql_check);
		
		if(mysql_num_rows($sql_check)){
			
			for($i = 0; $i < mysql_num_rows($sql_check); $i++){
				$datos[] = mysql_fetch_array($sql_check);
				
			}
			
			$resultado = array($total, $datos);
			
		}else{
			
		}
		
		
	}else{
			header("Location: error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
			
	mysql_free_result($sql_check);
	mysql_close($conecta);
	return $resultado;
}

//función para sacar la información de la ficha de un usuario
function get_estadisticas_fichas(){
	$contador1 = 0; $contador2 = 0; $contador3 = 0; $contador4 = 0; $contador5 = 0; $contador6 = 0; $contador7 = 0; $contador8 = 0;	$contador9 = 0;
	$contador10 = 0; $contador11 = 0; $contador12 = 0; $contador13 = 0; $contador14 = 0; $contador15 = 0; $contador16 = 0; $contador17 = 0;
	$contador18 = 0; $contador19 = 0; $contador20 = 0; $contador21 = 0; $contador22 = 0; $contador23 = 0; $contador24 = 0;
	$contador25 = 0; $contador26 = 0; $contador27 = 0; $contador28 = 0;
	$contador29 = 0; $contador30 = 0; $contador31 = 0; $contador32 = 0;
	$contador33 = 0; $contador34 = 0; $contador35 = 0; $contador36 = 0;
	$contador37 = 0; $contador38 = 0; $contador39 = 0; 
	$contador40 = 0; $contador41 = 0; $contador42 = 0; 
	$contador43 = 0; $contador44 = 0; $contador45 = 0; 
	
	include 'trash/conn.php';

	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);

	if($conecta){
		session_start();
		
		// sacando los id de las metas para una ficha
		//                                       0              1            2            3             4              5             6             7             8               9             10              11            12            13             14          15          16             17           18            19          20            21           22            23            24              25            26             27            28          29        30         31       32        33              34            35       36      37      38
		$sql_check = mysql_query("SELECT e.Id_evaluacion, e.Pregunta1, e.Pregunta1b, e.Pregunta1c, e.Pregunta1d, e.Pregunta41, e.Pregunta42, e.Pregunta43, e.Pregunta43a, e.Pregunta43b, e.Pregunta43c, e.Pregunta43d, e.Pregunta44, e.Pregunta45, e.Pregunta4, e.Pregunta5, e.Pregunta51, e.Pregunta52, e.Pregunta6, e.Pregunta7, e.Pregunta8, e.Pregunta9, e.Pregunta10, e.Pregunta11, e.Pregunta12, e.Pregunta12a, e.Pregunta12b, e.Pregunta12c, e.Pregunta12d, f.Peso, f.Estatura, f.Cintura, f.IMC, f.IMC_riesgo, f.Cintura_riesgo, f.Fecha, f.Hora, u.Edad, u.Sexo FROM (SELECT Rut_Pensionado, MAX(Id_ficha) as Max_ficha FROM ficha GROUP BY Rut_pensionado) as x LEFT JOIN ficha as f on f.Rut_pensionado = x.Rut_pensionado AND f.Id_ficha = x.Max_ficha LEFT JOIN evaluaciones AS e ON e.Id_ficha = x.Max_ficha LEFT JOIN usuarios AS u ON u.Rut = x.Rut_pensionado");
		/*
		SALUD
		1: enfermedad
		2: HTA
		3: cardiovascular
		4: otra enfermedad
		5: lesión o dolor no tratado
		6: cansancio
		7: molestias para orinar o sangramiento - mujer
		8, 9, 10, 11: orinar - hombre
		12: dolores inhabilitantes
		13: dolor no tratado por médico
		
		NUTRICION
		17: intolerante a la lactosa
		14: pan
		15: frutas o verduras
		18: lácteos
		19: carne
		20: sal
		21: azúcar
		22: vino
		23: agua
		
		ACTIVIDAD FISICA
		24: hizo ejercicio
		25: resistencia
		26: fortalecimiento
		27: equilibrio
		28: movilidad articular
		
		DEMOGRÁFICAS
		33: imc riesgo
		34: cintura riesgo
		37: edad
		38: sexo
		*/
		$total = mysql_num_rows($sql_check);
		
		if(mysql_num_rows($sql_check)){
			
			for($i = 0; $i < mysql_num_rows($sql_check); $i++){
				$evaluacion = mysql_fetch_array($sql_check);
				
				//SALUD
				// enfermas
				if($evaluacion[1] == 1){
				$contador1++;
				}
				// HTA
				if($evaluacion[2] == 1){
				$contador2++;
				}
				// cardiovascular
				if($evaluacion[3] == 1){
				$contador3++;
				}
				// lesión o dolor
				if(($evaluacion[5] == 1)||($evaluacion[12] == 1)||($evaluacion[13] == 1)){
				$contador4++;
				}
				// urología y próstata
				if(($evaluacion[7] == 1)||($evaluacion[8] == 1)||($evaluacion[9] + $evaluacion[10] + $evaluacion[11] >= 2)){
				$contador5++;
				}
				
				//NUTRICIÓN
				//intolerancia a la lactosa
				if($evaluacion[17] == 1){
				$contador6++;
				}
				//lacteos (0 = sí)
				if($evaluacion[18] == 0){
				$contador7++;
				}
				//intolerancia lactosa + lacteos
				if(($evaluacion[17] == 1)&&($evaluacion[18] == 0)){
				$contador8++;
				}
				//pan (0 = sí)
				if($evaluacion[14] == 0){
				$contador9++;
				}
				//frutas y verduras (0 = sí)
				if($evaluacion[15] == 0){
				$contador10++;
				}
				//carnes (0 = sí)
				if($evaluacion[19] == 0){
				$contador11++;
				}
				//sal
				if($evaluacion[20] == 1){
				$contador12++;
				}
				//HTA + sal
				if(($evaluacion[2] == 1)&&($evaluacion[20] == 1)){
				$contador13++;
				}
				//azúcar
				if($evaluacion[21] == 1){
				$contador14++;
				}
				//agua (0 = sí)
				if($evaluacion[23] == 0){
				$contador15++;
				}
				
				//ACTIVIDAD FÍSICA
				//hizo ejercicio (0 = sí)
				if($evaluacion[24] == 0){
				$contador16++;
				}
				//resistencia
				if($evaluacion[25] == 1){
				$contador17++;
				}
				//fortalecimiento
				if($evaluacion[26] == 1){
				$contador18++;
				}
				//equilibrio
				if($evaluacion[27] == 1){
				$contador19++;
				}
				//movilidad articular
				if($evaluacion[28] == 1){
				$contador20++;
				}

				//DEMOGRÁFICAS
				// riesgo imc en adulto joven hombre
				if(($evaluacion[33] == 'Normalidad')&&($evaluacion[37] <= 65)&&($evaluacion[38] == 1)){
				$contador21++;
				}
				if(($evaluacion[33] == 'Sobrepeso')&&($evaluacion[37] <= 65)&&($evaluacion[38] == 1)){
				$contador22++;
				}
				if(($evaluacion[33] == 'Obesidad')&&($evaluacion[37] <= 65)&&($evaluacion[38] == 1)){
				$contador23++;
				}
				if(($evaluacion[33] == 'Enflaquecido')&&($evaluacion[37] <= 65)&&($evaluacion[38] == 1)){
				$contador24++;
				}
				// riesgo imc en adulto joven mujer
				if(($evaluacion[33] == 'Normalidad')&&($evaluacion[37] <= 65)&&($evaluacion[38] == 2)){
				$contador29++;
				}
				if(($evaluacion[33] == 'Sobrepeso')&&($evaluacion[37] <= 65)&&($evaluacion[38] == 2)){
				$contador30++;
				}
				if(($evaluacion[33] == 'Obesidad')&&($evaluacion[37] <= 65)&&($evaluacion[38] == 2)){
				$contador31++;
				}
				if(($evaluacion[33] == 'Enflaquecido')&&($evaluacion[37] <= 65)&&($evaluacion[38] == 2)){
				$contador32++;
				}
				// riesgo imc en adulto mayor hombre
				if(($evaluacion[33] == 'Normalidad')&&($evaluacion[37] > 65)&&($evaluacion[38] == 1)){
				$contador25++;
				}
				if(($evaluacion[33] == 'Sobrepeso')&&($evaluacion[37] > 65)&&($evaluacion[38] == 1)){
				$contador26++;
				}
				if(($evaluacion[33] == 'Obesidad')&&($evaluacion[37] > 65)&&($evaluacion[38] == 1)){
				$contador27++;
				}
				if(($evaluacion[33] == 'Enflaquecido')&&($evaluacion[37] > 65)&&($evaluacion[38] == 1)){
				$contador28++;
				}
				// riesgo imc en adulto mayor mujer
				if(($evaluacion[33] == 'Normalidad')&&($evaluacion[37] > 65)&&($evaluacion[38] == 2)){
				$contador33++;
				}
				if(($evaluacion[33] == 'Sobrepeso')&&($evaluacion[37] > 65)&&($evaluacion[38] == 2)){
				$contador34++;
				}
				if(($evaluacion[33] == 'Obesidad')&&($evaluacion[37] > 65)&&($evaluacion[38] == 2)){
				$contador35++;
				}
				if(($evaluacion[33] == 'Enflaquecido')&&($evaluacion[37] > 65)&&($evaluacion[38] == 2)){
				$contador36++;
				}
				// riesgo circunferencia hombre
				if(($evaluacion[34] == 'Saludable')&&($evaluacion[38] == 1)){
				$contador37++;
				}
				if(($evaluacion[34] == 'Riesgo moderado')&&($evaluacion[38] == 1)){
				$contador38++;
				}
				if(($evaluacion[34] == 'Riesgo alto')&&($evaluacion[38] == 1)){
				$contador39++;
				}
				// riesgo circunferencia general
				if($evaluacion[34] == 'Saludable'){
				$contador40++;
				}
				if($evaluacion[34] == 'Riesgo moderado'){
				$contador41++;
				}
				if($evaluacion[34] == 'Riesgo alto'){
				$contador42++;
				}
				// riesgo circunferencia hombre
				if(($evaluacion[34] == 'Saludable')&&($evaluacion[38] == 2)){
				$contador43++;
				}
				if(($evaluacion[34] == 'Riesgo moderado')&&($evaluacion[38] == 2)){
				$contador44++;
				}
				if(($evaluacion[34] == 'Riesgo alto')&&($evaluacion[38] == 2)){
				$contador45++;
				}
			
			}
			
			$resultado = array($total, $contador1, $contador2, $contador3, $contador4, $contador5, $contador6, $contador7, $contador8, $contador9, $contador10, $contador11, $contador12, $contador13, $contador14, $contador15, $contador16, $contador17, $contador18, $contador19, $contador20, $contador21, $contador22, $contador23, $contador24, $contador25, $contador26, $contador27, $contador28, $contador29, $contador30, $contador31, $contador32, $contador33, $contador34, $contador35, $contador36, $contador37, $contador38, $contador39, $contador40, $contador41, $contador42, $contador43, $contador44, $contador45);
			
		}else{
			
		}
		
		
	}else{
			header("Location: error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
			
	mysql_free_result($sql_check);
	mysql_close($conecta);
	return $resultado;
}

//función para ver casi todas las estadísticas
/*
function estadistica_general($tipo){
	
	$contador = 0;
	
	//incluyendo conexión
	include 'trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		// sacando los id de las metas para una ficha
		$sql_check = mysql_query("SELECT Rut FROM usuarios WHERE '1'");
		
		$total = mysql_num_rows($sql_check);
		
		if(mysql_num_rows($sql_check)){
			
			for($i = 0; $i < mysql_num_rows($sql_check); $i++){
				$row = mysql_fetch_array($sql_check);
				
				$fichas = get_ficha($row['Rut'], '');
				$id_ficha = $fichas[0][7];
				
				$evaluacion = get_evaluacion($id_ficha);
				
				//revisando si cumple con la condición
				switch($tipo){
				
				case 'actividad_fisica':
					if($evaluacion[17] == 1){
					$contador++;
					}
					break;
				
				case 'dolor_articular':
					if(($evaluacion[19] == 0)||($evaluacion[20] == 1)){
					$contador++;
					}
					break;
				
				case 'riesgo_osteoarticular':
					if($evaluacion[9] < 3){
					$contador++;
					}
					break;
				
				case 'riesgo_cardiovascular_bajo':
					if(($evaluacion[7] < 3)&&($evaluacion[8] < 3)&&($evaluacion[10] < 3)&&($evaluacion[11] == 0)&&($evaluacion[12] == 0)){
					$contador++;
					}
					break;
				
				case 'riesgo_cardiovascular_alto':
					if(($evaluacion[7] == 6)&&($evaluacion[8] == 6)&&($evaluacion[10] == 7)&&($evaluacion[11] == 1)&&($evaluacion[12] == 1)){
					$contador++;
					}
					break;
				
				case 'enfermedades':
					if($evaluacion[1] == 1){
					$contador++;
					}
					break;
					
				case 'alcohol':
					if($evaluacion[6] == 1){
					$contador++;
					}
					break;
				
				case 'tabaco':
					if($evaluacion[5] == 1){
					$contador++;
					}
					break;
					
				case 'tabaco_y_alcohol':
					if(($evaluacion[5] == 1)&&($evaluacion[6] == 1)){
					$contador++;
					}
					break;
				
				//default
				default:
					break;
				
				} //fin switch
			}
			
			$resultado = array($contador, $total);
			
		}else{
		
		}
		
		
	}else{
			header("Location: error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
			
	mysql_free_result($sql_check);
	mysql_close($conecta);
	
return $resultado;
} // fin actividad física general
*/

//función para ver cuántas personas se reevaluaron
function estadistica_reevaluacion(){
	
	$contador1 = 0;
	$contador2 = 0;
	
	//incluyendo conexión
	include 'trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		// sacando los id de las metas para una ficha
		$sql_check = mysql_query("SELECT Rut_pensionado, count(Rut_Pensionado) as Contando FROM ficha GROUP BY Rut_pensionado ORDER BY contando DESC");
		
		//$total = mysql_num_rows($sql_check);
		
		if(mysql_num_rows($sql_check)){
			
			for($i = 0; $i < mysql_num_rows($sql_check); $i++){
				$row = mysql_fetch_array($sql_check);
				
				
					if($row['Contando'] > 1){
						$contador1++;
						}
					
					if($row['Contando'] > 2){
						$contador2++;
						}
				
			}
			
			$resultado = array($contador1, $contador2);
			
		}else{
		
		}
		
		
	}else{
			header("Location: error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
			
	mysql_free_result($sql_check);
	mysql_close($conecta);
	
return $resultado;
} // fin reevaluacion

// ex función para ver cuántas personas se reevaluaron
/*function estadistica_reevaluacion($tipo){
	
	$contador = 0;
	
	//incluyendo conexión
	include 'trash/conn.php';
		
	$conecta = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($dbname);
	
	if($conecta){
		session_start();
		
		// sacando los id de las metas para una ficha
		$sql_check = mysql_query("SELECT Rut FROM usuarios WHERE '1'");
		
		$total = mysql_num_rows($sql_check);
		
		if(mysql_num_rows($sql_check)){
			
			for($i = 0; $i < mysql_num_rows($sql_check); $i++){
				$row = mysql_fetch_array($sql_check);
				
				$fichas = get_ficha($row['Rut'], '');
				$id_ficha = $fichas[0][7];
				
				
				//revisando si cumple con la condición
				switch($tipo){
				
				case 'una':
					if(($fichas[1][0] != null)&&($fichas[2][0] == null)){
						$contador++;
						}
					break;
				
				case 'dos':
					if($fichas[2][0] != null){
						$contador++;
						}
					break;
				
				//default
				default:
					break;
				}
			}
			
			$resultado = array($contador, $total);
			
		}else{
		
		}
		
		
	}else{
			header("Location: error.php?tipo=bd"); //por si no conecta, manda error.
			exit(1);
			}
			
	mysql_free_result($sql_check);
	mysql_close($conecta);
	
return $resultado;
} // fin reevaluacion
*/
