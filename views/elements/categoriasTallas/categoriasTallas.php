<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12">


        <div class="card mb-5">
            <div class="card-header">
                <h4>Categorias de Productos</h4>
            </div>
            <div class="card-body">
                <div class="input-group mt-3 mb-3 col-lg-12 col-md-12 col-sm-12">
                    <div class="input-group-prepend">
                        <button class="btn btn-info" type="button" id="addNewLineCategoriaBtn">Agregar Nueva Categoria</button>
                    </div>
                    <input type="text" id="txtDescripcionCategoria" class="form-control" placeholder="Descripcion de la categoria">
                </div>
                <div class="row tableJoinCategoria">
                    <?php include(self::element('categoriasTallas/categoriasTable')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12">


        <div class="card mb-5">
            <div class="card-header">
                <h4>Tallas de Productos</h4>
            </div>
            <div class="card-body">
                <div class="input-group mt-3 mb-3 col-lg-12 col-md-12 col-sm-12">
                    <div class="input-group-prepend">
                        <button class="btn btn-info" type="button" id="addNewLineTallaBtn">Agregar Nueva Talla</button>
                    </div>
                    <input type="text" id="txtDescripcionTalla" class="form-control" placeholder="Descripcion de la talla">
                    <input type="text" id="txtTallaMedida" class="form-control" placeholder="Talla">
                </div>
                <div class="row tableJoinTalla">
                    <?php include(self::element('categoriasTallas/tallasTable')) ?>
                </div>
            </div>
        </div>
        <?php include(self::modal('modalEditCategoriasTallas')) ?>
    </div>
</div>