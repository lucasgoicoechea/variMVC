<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div style="width: 100%; text-align: center">
	<img width="100"
		src='<?php echo Yii::app()->theme->baseUrl;?>/img/imgprofesionales/logosintext.png'
		style="text-decoration: none; border: none;"> <img width="670"
		src='<?php echo Yii::app()->theme->baseUrl;?>/img/imgprofesionales/banneryellow.png'
		style="text-decoration: none; border: none;">
</div>
<br>
<?php echo $content; ?>

<?php $this->endContent(); ?>