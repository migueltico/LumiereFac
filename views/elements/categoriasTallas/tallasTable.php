<div class="table-responsive">

    <table class="table sort" id="sortable">
        <thead>
            <tr>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">ID</th>
                <th data-type="0" data-inner="0" scope="col" style="text-align: left;">Descripcion</th>
                <th data-type="1" data-inner="0" scope="col" style="text-align: center;">Talla</th>
                <th data-type="0" data-inner="0" scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody data-sorts="DESC">
            <?php
            $gravado = array("noGravado", "gravado");
            $estado = array("inhabilitado", "habilitado");
            ?>
            <?php foreach ($tallas as $talla) : ?>
                <tr class="TrRow">
                    <td scope="row" style="text-align: center;"><?= $talla["idtallas"] ?></td>
                    <td scope="row" style="text-align: left;"><?= $talla["descripcion"] ?></td>
                    <td scope="row" style="text-align: center;"><?= $talla["talla"] ?></td>
                    <td scope="row">
                        <div class="btn-group Editbuttons" aria-label="Grupo edicion">
                            <button type="button" class="btn btn-success EditTallasBtn" data-descripcion="<?= $talla["descripcion"] ?>" data-talla="<?= $talla["talla"] ?>" data-toggle="modal" data-target="#editTallasModal" data-id='<?= $talla["idtallas"] ?>'><?= $icons['edit'] ?></button>
                            <button type="button" class="btn btn-danger DeleteTallasBtn" data-id='<?= $talla["idtallas"] ?>'><?= $icons['trash'] ?></button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>