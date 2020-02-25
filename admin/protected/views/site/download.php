<script>

function obtenerPDF(){
	$.ajax({  		
  		url: <?php echo "'".CController::createUrl('site/downloadPDFAction',array('url'=>Yii::app()->request->getUrl()))."'"; ?>,
	})
  	.done(function( result ) {    	
    	$('#lblHoraServidor').text(result);
  	});
}

</script>
<div id="ejemplo">
<!-- <a target='_blank' 	href=" -->
<?php
		$uri = Yii::app ()->request->hostInfo . Yii::app ()->request->getUrl () . '?renderPartial=word';
		//echo $uri;
		$image = "<img src='".Yii::app ()->theme->baseUrl."/img/icons/descargar-word.png'		width='90'>";
		echo CHtml::link($image,
            //CController::createUrl('site/downloadDOC',array('url'=>$uri))
            $uri
            );
		?>
<!-- 		">  -->
		<br>
	<!--  onclick="obtenerPDF()">-->
	<a target='_blank'
		href="<?php
		$uri = Yii::app ()->request->hostInfo . Yii::app ()->request->getUrl () . '?renderPartial=pdf';
		echo $uri;
		// echo CController::createUrl('site/downloadPDF',array('url'=>.''));
		?>"> <img
		src='<?php echo Yii::app ()->theme->baseUrl ?>/img/icons/download-pdf.jpeg'
		width='90'></a>
	<hr>
	<label id="lblHoraServidor"></label>
</div>