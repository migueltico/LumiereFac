<div class="col-lg-10 col-md-12 col-sm-12">
    <div class="card mb-5  shadow">
        <div class="card-header">
            <h4>Usuarios</h4>

            <a href="#" class="btn btn-primary btn-sm" id="usuario_usuario" data-toggle="modal" data-target="#usuarios_addUsuario" data-toggle="tooltip" data-placement="bottom" title="Agregar Nuevo Usuario"><?= $icons['plus-circle'] ?> Nuevo</a>
            <a href="#" id="usuario_RefreshUsuario" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Refrescar Usuarios">Refrescar</a>

        </div>
        <div class="card-body loadTable">
            <?php include(self::element('usuarios/usuariosTable')) ?>
        </div>
        <?php include_once(self::modal('modalAddUsuario')) ?>
        <?php include_once(self::modal('modalEditUsuario')) ?>

    </div>
</div>