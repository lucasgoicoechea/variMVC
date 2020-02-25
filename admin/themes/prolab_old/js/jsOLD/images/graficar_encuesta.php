<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Grafico estadistico de la pregunta</title>
<?php
require_once "../../../includes/conexion.php";
$strNombres = '';
echo "pase 1";
$strRespuestas = 'categories: [';
$datos=array();
$totalesRespuestasPorCarrera=array();
$totalesPorRptaPorCarrera=array();
$totalesPorRpta=array();
$totalRespuestasDadas=0;
 for($i=0; $i<20; $i++){$totalesPorRpta[$i]=0;}

if(isset($_GET['id_facultad'])){//ACA HAGO POR CARRERAS DE UNA FACULTAD
/*$consultaSQL = "SELECT fac.id,fac.nombre FROM facultades fac  WHERE fac.id='".$_GET['idFacultad']."'";		   
$QFacus = $link->query($consultaSQL);		    
$lafacu = $QFacus -> fetchRow(DB_FETCHMODE_ASSOC);
$totalPor = 'Titulo en '.$lafacu['nombre'];


 $QPreguntas = $link->query("SELECT * FROM questions WHERE id  = '".$_GET['id_pregunta']."' ");		
 $pregunta = $QPreguntas -> fetchRow(DB_FETCHMODE_ASSOC));
 $descripcionPregunta= $pregunta['pregunta'];

$cantOpciones = $link->query("SELECT count(*) FROM answers  WHERE id_pregunta  = '".$pregunta['id']."' ");
		$cantOpc = $cantOpciones -> fetchRow(DB_FETCHMODE_ORDERED);//cantidad respuestas
		
 if($pregunta['padre']!=0){
	   $QPreguntasPadre = $link->query("SELECT * FROM questions WHERE id  = '".$pregunta['padre']."' order by orden ");		
           $preguntaPadre = $QPreguntasPadre -> fetchRow(DB_FETCHMODE_ASSOC); 
           $descripcionPregunta = $preguntaPadre['pregunta']."<br />".$descripcionPregunta;		
         }		 
echo "pase 2";
 if($pregunta['type']=='agrupa'){ 
                       $descripcionPregunta .= "<BR />(NO SE PUEDE GRAFICAR PREGUNTAS QUE AGRUPAN A OTRAS)";
		 }
		 else {		 	
		 if($pregunta['type']=='libre'){
                       $descripcionPregunta .= "<BR />(NO SE PUEDE GRAFICAR PREGUNTAS DESCRIPTIVAS)";
		 }else{
                 //cantidad de respuestas por carrera, me va a servir para sacar porcentajes    
	         $qCantRespuestas = $link->query("SELECT count(c.id) as cantResp, pi.id_objeto, pi.tabla,c.nombre, c.id as c_id FROM answers_selected au, answers a, poll_instance pi, carreras c WHERE au.id_respuesta = a.id AND a.id_pregunta = '".$pregunta['id']."' AND pi.id=au.id_instancia AND c.idFacultad='".$lafacu['id']."' AND c.id=pi.id_objeto GROUP BY c.id");
	 echo "pase 3";
    	 while ($queryCantResp_objeto = $qCantRespuestas -> fetchRow(DB_FETCHMODE_ASSOC)){       
			$totalesRespuestasPorCarrera[$queryCantResp_objeto['c_id']]= $queryCantResp_objeto['cantResp'];  //cantidad de rptas por carrera
                        $totalRespuestasDadas= $totalRespuestasDadas + $queryCantResp_objeto['cantResp'];  
			$Qrespuestas = $link->query("SELECT * FROM answers  WHERE id_pregunta  = '".$pregunta['id']."' ");
                        $strRespuestas = 'categories: ['; //inicializo siempre por haragan y no hacer un for luego.
			//recupero respuestas por cada pregunta
			while ($respuesta = $Qrespuestas -> fetchRow(DB_FETCHMODE_ASSOC)){//itero respuestas
  				//ahora calculo la cantidad de respuestas para esa respuesta especifica
                                $strRespuestas .= "'".$respuesta['descripcion']."',";				
$qRespEspecifica = $link->query("SELECT count(*) as totalRespEspec FROM answers_selected ar, poll_instance pi, carreras c where ar.id_respuesta = '".$respuesta['id']."' AND ar.id_instancia=pi.id AND pi.id_objeto = c.id AND c.id=".$queryCantResp_objeto['c_id'] );
				$queryResp = $qRespEspecifica->fetchRow(DB_FETCHMODE_ASSOC);
				$totalRespEspec = $queryResp['totalRespEspec'];
                                $totalesPorRpta[$respuesta['id']] = $totalesPorRpta[$respuesta['id']] + $totalRespEspec; 
				$totalesPorRptaPorCarrera[$queryCantResp_objeto['c_id']][$respuesta['id']] = $totalRespEspec;
         		}//fin del while por objeto
		
                              foreach($linea as $facu=>$valores){//(clave, valor)=(facultad, resto del arreglo)
				$mostrar = $facu;
				foreach($valores as $rpta=>$valor){//(respuestas, resto del arreglo)
					//resto del arreglo = (total=>valor_total, porcentaje=>valor_porcentaje)
				}
				echo "<td >".number_format(($totalesRespuestas[$i]*100/$_SESSION['totalPregunta'.$pregunta['id']]),2)."%"."</td>";
			      }
 }
echo "pase 5";
 $qCantRespuestas = $link->query("SELECT count(c.id) as cantResp, pi.id_objeto, pi.tabla,c.nombre, c.id as c_id FROM answers_selected au, answers a, poll_instance pi, carreras c WHERE au.id_respuesta = a.id AND a.id_pregunta = '".$pregunta['id']."' AND pi.id=au.id_instancia AND c.idFacultad='".$lafacu['id']."' AND c.id=pi.id_objeto GROUP BY c.id");
         $columnas = "";	 
         $strTortasPorcionCarrera = "data: [";
    	 while ($queryCantResp_objeto = $qCantRespuestas -> fetchRow(DB_FETCHMODE_ASSOC)){       
                $columnas .= "{ type: 'column',";	 
    	 	$columnas .= " name: '".$queryCantResp_objeto['nombre']."',";	
    	 	$columnas .= " data: [";
	        $Qrespuestas = $link->query("SELECT * FROM answers  WHERE id_pregunta  = '".$pregunta['id']."' ");
          		//recupero respuestas por cada pregunta
                        $strValoresColumnas= "";
			while ($respuesta = $Qrespuestas -> fetchRow(DB_FETCHMODE_ASSOC)){//itero respuestas
                          $strValoresColumnas .= $totalesPorRptaPorCarrera[$queryCantResp_objeto['c_id']][$respuesta['id']].",";    
                        }
                $strValoresColumnas = substr($strValoresColumnas, 0, -1);
                $columnas .= $strValoresColumnas;
                $columnas .= "]},";
                $strTortasPorcionCarrera .= "{ name: '".$queryCantResp_objeto['nombre']."',y: ";
                $nroPorc =number_format(($totalesRespuestasPorCarrera[$queryCantResp_objeto['c_id']]*100/$totalRespuestasDadas),2);
                $strTortasPorcionCarrera .=$nroPorc.",color: '#4572A7'},";
          }
          $Qrespuestas = $link->query("SELECT * FROM answers  WHERE id_pregunta  = '".$pregunta['id']."' ");
          $strTortasPorcionRespuestas = "data: [";
          while ($respuesta = $Qrespuestas -> fetchRow(DB_FETCHMODE_ASSOC)){//itero respuestas              
                $strTortasPorcionRespuestas .= "{ name: '".$respuesta['descripcion']."',y: ";
                $nroPorc =number_format(($totalesPorRpta[$respuesta['id']]*100/$totalRespuestasDadas),2);
                $strTortasPorcionRespuestas .=$nroPorc.",color: '#457AAA'},";    
               }      
*/	


}
else { //ACA HAGO POR FACULTADES Y PORCENTAJES PREGUNTAS
$totalPor = 'Facultad';
}

$strTortasPorcionCarrera = substr($strTortasPorcionCarrera, 0, -1);
$strTortasPorcionRespuestas = substr($strTortasPorcionRespuestas, 0, -1);
//$columnas = substr($columnas, 0, -1);
$strRespuestas = substr($strRespuestas, 0, -1);
$strRespuestas .= ']';
$strTortasPorcionCarrera .= ']';
$strTortasPorcionRespuestas.= ']'; 
?>	
		
		
		<!-- 1. Add these JavaScript inclusions in the head of your page -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="./js/highcharts.js"></script>
		<!--[if IE]>
			<script type="text/javascript" src="./js/excanvas.compiled.js"></script>
		<![endif]-->
		
		
		<!-- 2. Add the JavaScript to initialize the chart on document ready -->
		<script type="text/javascript">
		var chart;
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'container'
				},
				title: {
<?php
					echo "text: '".$descripcionPregunta."'";
?>
				},
				xAxis: {
<?php
					echo $strRespuestas;
?>
					
				},
				tooltip: {
					formatter: function() {
						var s;
						if (this.point.name) { // the pie chart
							s = '<b>Total por carrera</b><br/>'+
								this.point.name +': '+ this.y +' fruits';
						} else {
							s = '<b>'+ this.series.name +'</b><br/>'+
								this.x  +': '+ this.y;
						}
						return s;
					}
				},
				labels: {
					items: [{
<?php
					echo "html: 'Total por ".$totalPor."',";
?>
						
						style: {
							left: '40px',
							top: '8px',
							color: 'black'				
						}
					}]
				},
				series: [
<?php      
    echo $columnas;                    
 ?>     
                        {
					type: 'spline',
					name: 'Promedio',
					data: [3, 2.67, 3, 6.33, 3.33]
				}, {
					type: 'pie',
					name: 'Porcentaje del Titulo',
<?php      
    echo $strTortasPorcionCarrera;                    
 ?>     
                                ,
					center: [100, 80],
					size: 100,
					showInLegend: false
				},{
					type: 'pie',
					name: 'Porcentaje de la Respuesta',
<?php   
   echo $strTortasPorcionRespuestas;                    
 ?>     	               ,
					center: [200, 80],
					size: 100,
					showInLegend: false
				}]
			});
			
			
		});
		</script>
		
	<script type="text/javascript" src="http://www.highcharts.com/highslide/highslide-full.min.js"></script>
<script type="text/javascript" src="http://www.highcharts.com/highslide/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="http://www.highcharts.com/highslide/highslide.css" />
</head>
	<body>
		
		<!-- 3. Add the container
		<div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>  -->
		<div id="container" class="highcharts-container" style="height:410px; width: 800px; margin: 0 auto; clear:both"></div>

				
	</body>
</html>
