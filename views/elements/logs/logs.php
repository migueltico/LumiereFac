<div class="card mb-5 shadow">
	<div class="card-header">
		<?php //var_dump($_SESSION)  
		?>
		<h4>Logs</h4>
	</div>
	<div>
		<!-- Agrega start date, end date y filtros adicionales para acción, módulo y usuario -->
		<div class="card-body">
			<h5 class="card-title">Filtros</h5>
			<hr>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="startDate">Fecha Inicio</label>
					<?php
					// Calcula la fecha 7 días antes de la fecha actual
					$defaultStartDate = date('Y-m-d', strtotime('-7 days'));
					// Calcula la fecha actual
					$endDate = date('Y-m-d');
					?>
					<input type="date" class="form-control" id="startDate" value="<?= $defaultStartDate ?>">
				</div>
				<div class="form-group col-md-6">
					<label for="endDate">Fecha Fin</label>
					<input type="date" class="form-control" id="endDate" value="<?= $endDate ?>">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="accion">Acción</label>
					<select class="form-control" id="accion">
						<option value="" selected>Seleccione una acción</option>
						<?php foreach ($acciones as $accion) : ?>
							<option value="<?= $accion['accion'] ?>"><?= $accion['accion'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="modulo">Módulo</label>
					<select class="form-control" id="modulo">
						<option value="" selected>Seleccione un módulo</option>
						<?php foreach ($modulos as $modulo) : ?>
							<option value="<?= $modulo['modulo'] ?>"><?= $modulo['modulo'] ?></option>
						<?php endforeach; ?>


					</select>
				</div>
				<div class="form-group col-md-4">
					<label for="usuario">ID Usuario</label>
					<input type="text" class="form-control" id="usuario" placeholder="Filtrar por ID de usuario">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-12">
					<button class="btn btn-primary" id="btnSearchLogs">Buscar</button>
				</div>
			</div>
		</div>




	</div>

	<div class="card-body loadTable">
		<?php include(self::element('logs/logsTable')) ?>
	</div>
</div>