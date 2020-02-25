		<div class="contenedor-fila">
			<div class="contenedor-columna">
				<label for="FormaPago">Forma Pago</label><?php
				$this->widget ( 'application.components.Relation', array (
						'model' => $model,
						'relation' => 'formaPago',
						'fields' => 'Nombre',
						'allowEmpty' => false,
						'style' => 'dropdownlist',
						'showAddButton' => false 
				) );
				?>
			</div>
			<div class="contenedor-columna">
				<label for="Cuenta">Cuenta</label><?php
				$this->widget ( 'application.components.Relation', array (
						'model' => $model,
						'relation' => 'cuenta',
						'fields' => 'descripcion',
						'allowEmpty' => false,
						'style' => 'dropdownlist',
						'showAddButton' => false 
				) );
				?>
			</div>
			<div class="contenedor-columna">
				<label for="Contrato">Sub-Contrato</label><?php
				$this->widget ( 'application.components.Relation', array (
						'model' => $model,
						'relation' => 'contrato',
						'fields' => 'descripcion',
						'allowEmpty' => false,
						'style' => 'dropdownlist',
						'showAddButton' => false 
				) );
				?>
			</div>
			<div class="contenedor-columna">
				<label for="Cheque">Cheque</label><?php
				$this->widget ( 'application.components.Relation', array (
						'model' => $model,
						'relation' => 'cheque',
						'fields' => 'descripcion',
						'allowEmpty' => true,
						'style' => 'dropdownlist',
						'showAddButton' => false 
				) );
				?>
			</div>
			<div class="contenedor-columna"></div>
		</div>