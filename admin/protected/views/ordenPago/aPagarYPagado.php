<div id="admin_comprobantes_carga">
<div class="span-10">

<b>COMPROBANTES a PAGAR</b>
<?php
 echo $this->renderPartial('grillaGastos', array('id_cuenta'=>1 , 'id_proveedor'=>$id_proveedor,'pagado'=>0 ));

?>
</div>
<div class="span-19">
<b>COMPROBANTES PAGADOS</b>
<?php

 echo $this->renderPartial('grillaGastos', array('id_cuenta'=>$id_cuenta , 'id_proveedor'=>$id_proveedor,'pagado'=>1 ));

?>
</div>

</div>