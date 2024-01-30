<?php
$count = $countFrom;
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
		<td scope="row" style="text-align: left; max-width:400px">
			<pre><?= $log["datos"] ?></pre>
		</td>
		<td scope="row"><?= $log["nombre"] ?> ( id:<?= $log["idusuario"] ?>)</td>
		<td scope="row"><?= $log["creado_el"] ?></td>
	</tr>
<?php endforeach; ?>