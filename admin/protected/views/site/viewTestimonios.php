<?php
foreach ( $testimonios as $testimonio ) :
	?>

<tr>
	<br>
</tr>
<tr>

	<td align="center"><br>
<?php
	echo $this->renderPartial ( '_testimonio', array (
			'testimonio' => $testimonio,
			'muestraFecha' => true 
	) );
	?>
</td>
</tr>
<div class="content-right" style="text-align: right;"></div>
<?php endforeach;?>