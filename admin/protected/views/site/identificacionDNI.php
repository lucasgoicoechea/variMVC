<?php $form = $this->beginWidget ( 'CActiveForm', array (
		'id' => 'accesos-form',
		'enableAjaxValidation' => true 
) );
?>

<table>
<tr>	<td style="text-align: center;" >
<span
style='font-family: arial  ; font-size: 17px; color: #4453BB; display: block'>Este formulario tiene por finalidad realizar
</span>
<span
style='font-family: arial  ; font-size: 17px; color: #4453BB; display: block'>un seguimiento de los graduados, hacer una evaluación de grado o posgrado,
</span>
<span
style='font-family: arial  ; font-size: 17px; color: #4453BB; display: block'>	promover el contacto con el egresado.
</span>
<span
style='font-family: arial  ; font-size: 17px; color: #4453BB; display: block'>	 Deberá imprimir el certificado que aparece luego de completar el formulario
</span>
<br>
</td>
<br>
</tr>
<tr style="height: 43px;"><td style='border-left: 0 none;border-top: 0 none;'><span style='font-size:12px; font-weight:bold; color:black;'>DNI:  </span>
<?php echo CHtml::activeTextField($model,"dni", array('class'=>'caja','style'=>'width: 20em') );?>
<span id="modificarUsr" style="visibility:hidden;"></span></td>
</tr>
<tr style="height: 23px;"><td>
<?php echo $form->error($model,'dni'); ?></td>
</tr>
<tr><td><span class="validator"><span style="font-size:10px; font-weight:bold; color:grey;">Si tiene algun inconveniente con la carga de la encuesta por favor envie su consulta a </span>graduados@presi.unlp.edu.ar</span></td></tr>
</table>
<table>

<tr class='tns_cell'>
		<td align='center' style='text-align: center;' colspan='10'>
			<p class='botons'>
			<?php echo CHtml::submitButton(Yii::t('app', 'Ingresar'),array('class'=>'botons'));?> 
			</p>
		</td>
	</tr>
	<tr>
		<td colspan="2"><h3 class="titulon">
				<span>Ingrese su DNI para acceder a la opción de encuesta</span>
			</h3></td>
	</tr>
	</table>
	
	 <?php $this->endWidget(); ?>	