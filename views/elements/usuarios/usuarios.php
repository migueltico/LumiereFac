<div class="col-lg-10 col-md-12 col-sm-12">
    <div class="card mb-5  shadow">
        <div class="card-header">
            <h4>Usuarios</h4>

            <a href="#" class="btn btn-primary btn-sm" id="clientes_newProduct" data-toggle="modal" data-target="#usuarios_addCliente" data-toggle="tooltip" data-placement="bottom" title="Agregar Nuevo Cliente"><?= $icons['plus-circle'] ?> Nuevo</a>
            <a href="#" id="clientes_RefreshClientes" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Refrescar Usuarios">Refrescar</a>
            <div class="row">
                <div class="input-group mb-3 col-lg-6 col-md-8 col-sm-12 mt-3">
                    <input type="text" autocomplete="off" class="form-control" id="usuarios_Search" placeholder="Buscar Usuarios">
                    <div class="input-group-append">
                        <!-- <button class="btn btn-outline-secondary" type="button" id="button-addon2">Buscar</button> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body loadTable">
            <?php include(self::element('usuarios/usuariosTable')) ?>
        </div>
        <?php include_once(self::modal('modalAddUsuario')) ?>
        <?php include_once(self::modal('modalEditUsuario')) ?>

    </div>
</div>