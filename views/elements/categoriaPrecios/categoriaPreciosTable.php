<div class="table-responsive">

    <table class="table sort" id="sortable">
        <thead>
            <tr>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">ID</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Descripcion</th>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Factor</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: center;">Ultima Modificacion</th>
                <th data-type="0" data-inner="0" scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody data-sorts="DESC">
            <?php
            $gravado = array("noGravado", "gravado");
            $estado = array("inhabilitado", "habilitado");
            ?>
            <?php foreach ($categorias_precios as $CatePrice) : ?>

                <?php $newDate = date("d-M-y", strtotime($CatePrice["ultima_modificacion"])); ?>
                <tr class="TrRow">
                    <td scope="row" style="text-align: center;"><?= $CatePrice["idCategoriaPrecio"] ?></td>
                    <td scope="row" style="text-align: left;"><?= $CatePrice["descripcion"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $CatePrice["factor"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $newDate ?></td>
                    <td scope="row">
                        <div class="btn-group Editbuttons" aria-label="Grupo edicion">
                            <button type="button" class="btn btn-success EditCategoriaPreciosBtn" data-descripcion="<?= $CatePrice["descripcion"] ?>" data-factor="<?= $CatePrice["factor"] ?>" data-toggle="modal" data-target="#editCategoriaPrecios" data-id='<?= $CatePrice["idCategoriaPrecio"] ?>'><?= $icons['edit'] ?></button>
                            <button type="button" class="btn btn-danger DeleteCategoriaPreciosBtn" data-id='<?= $CatePrice["idCategoriaPrecio"] ?>'><?= $icons['trash'] ?></button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>