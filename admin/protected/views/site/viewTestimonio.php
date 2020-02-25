<?php
?>
<tr>

	<td align="center"><br>
		<div class="slotlet documents_slotlet">
			<div class="title">Testimonio del mes</div>

			<div class="">
				<div class="content" style="padding: 0px 10px 0px 0px;">
					<div
						style="position: relative; float: left; top: 40px; left: 10px; padding: 10px;">
						<img border="0" width="240px" alt="<?php echo $model->titulo; ?>"
							src="<?php echo $model->pathImagen?>"
							style="border-style: none; display: block; position: relative; max-width: 240px">
					</div>
					<div
						style="max-width: 300px; position: relative; float: right; top: 40px">     
	 <?php
		$htmlOptions = array (
				'target' => '_blank',
				'style' => 'font-size: 16px; font-weight: bold;' 
		);
		echo CHtml::link ( utf8_decode ( $model->titulo ), $model->getUrl (), $htmlOptions );
		echo "<p>" . utf8_decode ( $model->texto ) . "</p>";
		?>
	   
	</div>

				</div>
			</div>
		</div> <br></td>
</tr>

