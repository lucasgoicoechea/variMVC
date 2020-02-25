
<div class="slotlet documents_slotlet">
	<div class="title">Articulo - publicado: <? echo $muestraFecha?$testimonio->fecha:''; ?></div>
	<div class="content">
		<div
			style="position: relative; float: left; top: 10px; left: 10px; padding: 0px 20px 10px 0px;">
			<img border="0" width="140" height="200"
				alt="<?php echo $testimonio->titulo; ?>"
				src="<?php echo $testimonio->pathImagen?>"
				style="border-style: none; text-align: right; display: inline;">
		</div>
		<div style="max-width: 390px; min-height: 200px;">
		<?
		// echo "<a target='_blank' href='index.php?op=viewArticulo&id=".$id."' >".utf8_decode($titulo)."</a>";
		$htmlOptions = array (
				'target' => '_blank',
				'style' => 'font-size: 16px;' 
		);
		echo CHtml::link ( utf8_decode ( $testimonio->titulo ), $testimonio->getUrl (), $htmlOptions );
		?>
      <?
						echo "<p>" . utf8_decode ( $testimonio->resenia ) . "</p>";
						?>
	   
	</div>
	</div>
	<div class="content-right" style="text-align: right;">
	  <?
			
			$htmlOptions = array (
					'target' => '_blank',
					'style' => 'font-size: 16px;' 
			);
			$imageUrl = Yii::app ()->theme->baseUrl . "/img/buttons/vermas3.png";
			$image = CHtml::image ( $imageUrl, '', array (
					'class' => 'deals_product_image',
					'style' => 'border-style: none; text-align: right; display: inline;',
					'width' => "99",
					'height' => "35",
					'border' => "0",
					'alt' => "Ver mas sobre el testimonio" 
			) );
			echo CHtml::link ( $image, $testimonio->getUrl (), $htmlOptions );
			?>
	 </div>
	<div style="text-align: right;" class="footer"></div>
</div>
