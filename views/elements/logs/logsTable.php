<div class="table-responsive">
	<table class="table sort" id="sortable">
		<thead>
			<tr>
				<th data-type="1" data-inner="0" scope="col" style="text-align: center;">#</th>
				<th data-type="1" data-inner="0" scope="col" style="text-align: center;">ID</th>
				<th data-type="0" data-inner="0" scope="col" style="text-align: center;">Accion</th>
				<th data-type="0" data-inner="0" scope="col">modulo</th>
				<th data-type="0" data-inner="0" scope="col">detalle</th>
				<th data-type="0" data-inner="0" scope="col">datos</th>
				<th data-type="0" data-inner="0" scope="col" style="text-align: center;">usuario</th>
				<th data-type="0" data-inner="0" scope="col" style="text-align: center;">fecha</th>
			</tr>
		</thead>
		<tbody data-sorts="DESC" id="logsTable">

		<?php
			$count = 0;
		?>
			<?php foreach ($logs as $log) : ?>
				<?php 
					$newDate = date("d-M-y", strtotime($log["creado_el"])); 
					$count++;
				?>
				<tr class="TrRow">
					<td scope="row" style="text-align: center;"><?= $count ?></td>
					<td scope="row" style="text-align: center;"><?= $log["idlog"] ?></td>
					<td scope="row"><?= $log["accion"] ?></td>
					<td scope="row"><?= $log["modulo"] ?></td>
					<td scope="row"><?= $log["detalle"] ?></td>
					<td scope="row" style="text-align: left; max-width:400px"><pre><?= $log["datos"] ?></pre></td>
					<td scope="row"><?= $log["nombre"] ?> ( id:<?= $log["idusuario"] ?>)</td>
					<td scope="row"><?= $log["creado_el"] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="moreRows"style="text-align: center;margin-bottom: 20px;margin-top: 20px;margin: 0 auto;">
				<input type="hidden" name="" id="currentPage"value="0">
		<button class="btn btn-lg btn-primary" id="btnMoreRows">Cargar más</button>
	</div>
</div>