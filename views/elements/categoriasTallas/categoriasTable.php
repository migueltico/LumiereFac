<div class="table-responsive">

    <table class="table sort" id="sortable">
        <thead>
            <tr>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">ID</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Descripcion</th>
                <th data-type="0" data-inner="0" scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody data-sorts="DESC">
            <?php
            $gravado = array("noGravado", "gravado");
            $estado = array("inhabilitado", "habilitado");
            ?>
            <?php foreach ($categorias as $categoria) : ?>
                <tr class="TrRow">
                    <td scope="row" style="text-align: center;"><?= $categoria["idcategoria"] ?></td>
                    <td scope="row" style="text-align: left;"><?= $categoria["descripcion"] ?></td>
                    <td scope="row">
                        <div class="btn-group Editbuttons" aria-label="Grupo edicion">
                            <button type="button" class="btn btn-success EditCategoriaBtn" data-descripcion="<?= $categoria["descripcion"] ?>" data-toggle="modal" data-target="#editCategoriasModal" data-id='<?= $categoria["idcategoria"] ?>'><?= $icons['edit'] ?></button>
                            <button type="button" class="btn btn-danger DeleteCategoriaBtn" data-id='<?= $categoria["idcategoria"] ?>'><?= $icons['trash'] ?></button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>