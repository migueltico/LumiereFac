<div class="table-responsive">

  <table class="table sort" id="sortable">
    <thead>
      <tr>
        <th data-type="1" data-inner="0" scope="col" style="text-align: center;">ID</th>
        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Codigo</th>
        <th data-type="0" data-inner="0" scope="col">Descripcion</th>
        <th data-type="0" data-inner="0" scope="col">Categoria</th>
        <th data-type="0" data-inner="0" scope="col">Marca</th>
        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Estilo</th>
        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Talla</th>
        <th data-type="1" data-inner="1" scope="col" style="text-align: center;">IVA</th>
        <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Stock</th>
        <th data-type="0" data-inner="0" scope="col" style="text-align: center;">fecha modificacion</th>
        <th data-type="0" data-inner="1" scope="col">Activado</th>
        <th data-type="0" data-inner="0" scope="col">Edicion</th>
      </tr>
    </thead>
    <tbody data-sorts="DESC">
      <?php
      $gravado = array("noGravado","gravado");
      $estado = array("inhabilitado", "habilitado");
      ?>
      <!-- <span class="mr-2"><?php //echo$icons["codebar"] 
                              ?></span> -->
      <?php foreach ($products as $product) : ?>
        <?php $newDate = date("d-M-y", strtotime($product["ultima_modificacion"])); ?>
        <tr class="TrRow">
          <td scope="row" style="text-align: center;"><?=$product["idproducto"]?></td>
          <td scope="row" style="text-align: center;"><?=$product["codigo"] ?></td>
          <td scope="row"><?=$product["descripcion"] ?></td>
          <td scope="row"><?=$product["categoria"] ?></td>
          <td scope="row"><?=$product["marca"] ?></td>
          <td scope="row" style="text-align: center;"><?=$product["estilo"] ?></td>
          <td scope="row" style="text-align: center;"><?=$product["talla"] ?></td>
          <td scope="row" data-value="<?= $product["activado_iva"] ?>" style="text-align: center;margin:0 auto">
            <div class="<?=$gravado[$product["activado_iva"]] ?>" data-toggle="tooltip" data-placement="top" title="<?= $product["iva"].' - '.$product["activado_iva"]?>"></div>
          </td>
          <td scope="row" style="text-align: center;margin:0 auto"><?=$product["stock"] ?></td>
          <td scope="row" style="text-align: center;"><?= $newDate ?></td>
          <td scope="row" data-value="<?=$product["estado"] ?>" style="text-align: center;margin:0 auto">
            <div class="<?=$estado[$product["estado"]] ?>"></div>
          </td>
          <td scope="row">
            <div class="btn-group Editbuttons" role="group" aria-label="Grupo edicion">
              <button type="button" class="btn btn-info btn-sm EditProductBtn" data-toggle="modal" data-target="#EditProduct" data-id='<?=$product["idproducto"]?>'>Editar</button>
              <button type="button" class="btn btn-primary btn-sm pl-3 pr-3">Ver</button>
              <button type="button" class="btn btn-danger btn-sm">Eliminar</button>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>