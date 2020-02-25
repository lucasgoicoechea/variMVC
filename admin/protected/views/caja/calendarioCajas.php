<div class="titulo">Calendario de Cierres Diarios</div>
<div id="time">
<?php 

$this->widget('ext.EFullCalendar.EFullCalendar', array(
    'lang'=>'es',
    'themeCssFile'=>'cupertino/theme.css',
    // raw html tags
    'htmlOptions'=>array(
        // you can scale it down as well, try 80%
        'style'=>'width:90%'
    ),
    'options'=>array(
        'header'=>array(
            'left'=>'prev,next',
            'center'=>'title',
            'right'=>'today'
        ),
        'lazyFetching'=>true,
        'events'=>Yii::app()->createUrl('caja/calendarEvents', array()),
        //'eventMouseover'=>new CJavaScriptExpression("js_function_callback"),
    )
));
?>
</div>