<?php include_once(self::block('header')) ?>

<body class="">
    <div class="container" style="min-height: 100vh;">
        <div class="row flex flex-column justify-content-center align-items-center pt-5">
            <h3>Bienvenido <?= ($data['nombre'] != "" ? $data['nombre'] : $data['usuario']) ?></h3>
            <p>Tu usuario es <strong style="color:blue"><?=$data['usuario'] ?></strong></p>
            <p>Por favor asigna una contraseña para tu usuario.</p>
            <div class="col-sm-4 mt-3">
                <form id="setPassUser">
                    <div class="form-group pass_show">
                        <input type="password" name="nPass" id="nPass"  value="" class="form-control" placeholder="Nueva contraseña">
                    </div>
                    <div class="form-group pass_show">
                        <input type="password" value="" name="cPass" id="cPass" class="form-control" placeholder="Confirmar contraseña">
                    </div>
                    <input type="hidden" class="form-control" name="id" value="<?= $data['idusuario'] ?>">
                </form> 
                    <button id="setPasswordBtn" class="btn btn-primary">Actualizar</button>
            
            </div>
        </div>
    </div>
    <?php include_once(self::block('footer')) ?>