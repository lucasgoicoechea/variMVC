<div class="titulo">
 PagoCheque </div>
<div class="row-center">
<?php  	echo CHtml::link(Yii::t('app', 'Crear Nuevo '),'create',array('class'=>'btn'));
 	echo CHtml::link(Yii::t('app', 'Administrar'),'admin',array('class'=>'btn'));

?>
</div>

<div class="titulo"> Resultados</div>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
