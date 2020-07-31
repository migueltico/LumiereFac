<table class="tableeMain table sortable edition_table" id="sortable">
  <thead>
    <tr>
      <th scope="col" style="text-align: center;">ID</th>
      <th scope="col" style="text-align: center;">Sucursal</th>
      <th scope="col" style="text-align: center;">ubicacion</th>
      <th scope="col" style="text-align: center;">telefono</th>
      <th scope="col">Edicion</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $gravado = array("gravado", "noGravado");
    $estado = array("inhabilitado", "habilitado");
    ?>
    <?php foreach ($sucursales as $sucursal) : ?>
      <?php //$newDate = date("d-M-y", strtotime($product["ultima_modificacion"])); ?>
      <tr>
        <td scope="row" style="text-align: center;"><?=$sucursal["idsucursal"]?></td>
        <td scope="row" style="text-align: center;"><?=$sucursal["descripcion"]?></td>  
        <td scope="row" style="text-align: center;"><?=$sucursal["ubicacion"]?></td>  
        <td scope="row" style="text-align: center;"><?=$sucursal["telefono"]?></td>  
   
        <td scope="row">
          <div class="btn-group Editbuttons" role="group" aria-label="Grupo edicion">
            <button type="button" class="btn btn-success btn-sm">Editar</button>
            <button type="button" class="btn btn-primary btn-sm pl-3 pr-3">Ver</button>
            <button type="button" class="btn btn-danger btn-sm">Eliminar</button>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
