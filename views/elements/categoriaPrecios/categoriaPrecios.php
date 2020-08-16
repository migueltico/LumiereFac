<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12">


        <div class="card mb-5">
            <div class="card-header">
                <h4>Categoria de precios</h4>
            </div>
            <div class="card-body">
                <div class="input-group mt-3 mb-3 col-lg-12 col-md-12 col-sm-12">
                    <div class="input-group-prepend">
                        <button class="btn btn-info" type="button" id="addNewLineCategoriaPrecio">Agregar Nuevo</button>
                    </div>
                    <input type="text" id="txtDescripcionCategoriaPrecio" class="form-control" placeholder="Descripcion">
                    <input type="text" id="txtFactorCategoriaPrecio" class="form-control" placeholder="Factor">
                </div>
                <div class="row tableJoin">
                    <?php include(self::element('categoriaPrecios/categoriaPreciosTable')) ?>
                </div>
            </div>
        </div>
        <?php include(self::modal('modalEditCategoriaPrecios')) ?>
    </div>
</div>