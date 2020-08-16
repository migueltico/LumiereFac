<table class="tableeMain table sortable edition_table" id="sortable">
  <thead>
    <tr>
      <th scope="col" style="text-align: center;">ID</th>
      <th scope="col" style="text-align: left;">Sucursal</th>
      <th scope="col" style="text-align: left;">Ubicacion</th>
      <th scope="col" style="text-align: center;">Telefono</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $gravado = array("gravado", "noGravado");
    $estado = array("inhabilitado", "habilitado");
    ?>
    <?php foreach ($sucursales as $sucursal) : ?>
      <?php //$newDate = date("d-M-y", strtotime($product["ultima_modificacion"])); 
      ?>
      <tr>
        <td scope="row" style="text-align: center;"><?= $sucursal["idsucursal"] ?></td>
        <td scope="row" style="text-align: left;"><?= $sucursal["descripcion"] ?></td>
        <td scope="row" style="text-align: left;"><?= $sucursal["ubicacion"] ?></td>
        <td scope="row" style="text-align: center;"><?= $sucursal["telefono"] ?></td>

        <td scope="row">
          <div class="btn-group Editbuttons" role="group" aria-label="Grupo edicion">
            <button type="button" class="btn btn-success btn-sm openEditSucursalBtn" data-toggle="modal" data-target="#EditSucursalModal" data-id='<?= $sucursal["idsucursal"] ?>'>Editar</button>
            <button type="button" class="btn btn-danger btn-sm DeleteSucursalBtn" data-id='<?= $sucursal["idsucursal"] ?>'>Eliminar</button>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php include_once(self::modal('modalAddSucursal')) ?>
<?php include_once(self::modal('modalEditSucursal')) ?>