<div class="row">
    <div class="col-lg-10 col-md-8 col-sm-12">
        <div class="card mb-2">
            <div class="card-body">
                <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <h1 class="display-4">No se puede facturar</h1>
                        <p class="lead"><?= $msg ?></p>
                        <p>Solicite a su encargado que le genere una caja para iniciar a facturar.</p>
                        <button class="btn btn-primary" onclick="loadPage(null,'/facturacion/cajas')">Ir a Cajas</button>
                        <pre>
                            <?php  var_dump($data) ?>
                            <?php // var_dump($_SESSION) ?>
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>