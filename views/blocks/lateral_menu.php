<div class="menuContainer">
    <?php if (isset($_SESSION["db"])) :   ?>
        <?php if ($_SESSION["db"] == 'TestDB') :   ?>
            <div style="font-weight:bold;width: 100%;padding-top:10px;padding-bottom:10px;background:yellow;color:black;text-align:center;">
                <p class="mb-0">Entorno de Pruebas</p>
                <span><?= $_SERVER['SERVER_NAME'] ?></span>
            </div>
        <?php endif;  ?>
    <?php endif;  ?>
    <div style="font-weight:bold;width: 100%;padding-top:10px;padding-bottom:10px;margin-top:10px;text-align:center;">
        <p class="mb-0"><?= $_SESSION["db"] ?></p>
    </div>
    <div>
        <div class="perfil mt-3 mb-1">
            <img src="public/assets/img/perfil_no_found.jpg" alt="Perfil">
            <p class="mt-1"><?= isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : 'Usuario' ?></p>
        </div>
    </div>
    <ul class="main_menu" id="main_menu">
        <li>
            <a class="btnSlideDown" href="/dashboard"><span><?= $icons['dashboard'] ?></span><span>Dashboard</span><span class="menu_down"><?= $icons['arrow_down'] ?></span></a>
            <ul class="listitems">
                <li data-functionName="startChars" data-linkto="/dashboard/general" class="dataLink"><span class="spanStyleMenu"></span><span>General</span><span></span></li>
                <li data-functionName="0" data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>General2</span><span></span></li>
                <li data-functionName="0" data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Productos</span><span></span></li>
                <li data-functionName="0" data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Vendedores</span><span></span></li>
                <li data-functionName="0" data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Mensuales</span><span></span></li>
            </ul>
        </li>
        <li>
            <a class="btnSlideDown" href="/dashboard"><span><?= $icons['gear'] ?></span><span>Admin</span><span class="menu_down"><?= $icons['arrow_down'] ?></span></a>
            <ul class="listitems">
                <li data-functionName="0" data-linkto="/admin/general" class="dataLink"><span class="spanStyleMenu"></span><span>General</span><span></span></li>
                <?php if ($_SESSION["idrol"] == 1) : ?>
                    <li data-functionName="0" data-linkto="/admin/gastos" class="dataLink"><span class="spanStyleMenu"></span><span>Gastos</span><span></span></li>
                <?php endif; ?>
                <?php if ($_SESSION["idrol"] == 1) : ?>
                    <li data-functionName="0" data-linkto="/admin/categoriaprecios" class="dataLink"><span class="spanStyleMenu"></span><span>Categorias de precios</span><span></span></li>
                <?php endif; ?>
                <li data-functionName="0" data-linkto="/admin/categoriastallas" class="dataLink"><span class="spanStyleMenu"></span><span>Categorias y Tallas</span><span></span></li>
                <li data-functionName="0" data-linkto="/admin/categoriastallas" class="dataLink"><span class="spanStyleMenu"></span><span>Categorias y Tallas</span><span></span></li>
                <li data-functionName="0" data-linkto="/admin/descuentos" class="dataLink"><span class="spanStyleMenu"></span><span>Descuentos</span><span></span></li>
                <li data-functionName="0" data-linkto="/admin/descuentos/lote" class="dataLink"><span class="spanStyleMenu"></span><span>Descuentos por Lote</span><span></span></li>
                <li data-functionName="0" data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Reportes</span><span></span></li>
            </ul>
        </li>
        <li>
            <a class="btnSlideDown" href="/dashboard"><span><?= $icons['calc'] ?></span><span>Facturacion</span><span class="menu_down"><?= $icons['arrow_down'] ?></span></a>
            <ul class="listitems">
                <li data-functionName="0" data-linkto="/facturacion/facturar" class="dataLink"><span class="spanStyleMenu"></span><span>Facturar</span><span></span></li>
                <li data-functionName="0" data-linkto="/facturacion/cajas" class="dataLink"><span class="spanStyleMenu"></span><span>Cajas</span><span></span></li>
                <li data-functionName="0" data-linkto="/facturacion/pendientes" class="dataLink"><span class="spanStyleMenu"></span><span>Facturas Pendientes</span><span></span></li>
                <li data-functionName="0" data-linkto="/facturacion/historial/diario" class="dataLink"><span class="spanStyleMenu"></span><span>Historial Diario</span><span></span></li>
                <li data-functionName="0" data-linkto="/facturacion/historial/apartados" class="dataLink"><span class="spanStyleMenu"></span><span>Apartados</span><span></span></li>
                <li data-functionName="0" data-linkto="/facturacion/reportes" class="dataLink"><span class="spanStyleMenu"></span><span>Reportes</span><span></span></li>
            </ul>
        </li>
        <li>
            <a class="btnSlideDown" href="/inventario"><span><?= $icons['box'] ?></span><span>Inventario</span><span class="menu_down"><?= $icons['arrow_down'] ?></span></a>
            <ul class="listitems">
                <li data-functionName="0" data-linkto="/inventario/listarproductos" class="dataLink"><span class="spanStyleMenu"></span><span>Lista de Productos</span><span></span></li>
                <li data-functionName="0" data-linkto="/inventario/addstock" class="dataLink"><span class="spanStyleMenu"></span><span>Stock y Precios</span><span></span></li>
                <li data-functionName="0" data-linkto="/inventario/impresion/etiquetas" class="dataLink"><span class="spanStyleMenu"></span><span>Impresion de etiquetas</span><span></span></li>
            </ul>
        </li>
        <li>
            <a class="btnSlideDown" href="/dashboard"><span><?= $icons['clients'] ?></span><span>Clientes</span><span class="menu_down"><?= $icons['arrow_down'] ?></span></a>
            <ul class="listitems">
                <li data-functionName="0" data-linkto="/clientes/lista" class="dataLink"><span class="spanStyleMenu"></span><span>Lista de Clientes</span><span></span></li>
                <li data-functionName="0" data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Reportes</span><span></span></li>
            </ul>
        </li>
        <li>
            <a class="btnSlideDown" href="/dashboard"><span><?= $icons['users'] ?></span><span>Usuarios</span><span class="menu_down"><?= $icons['arrow_down'] ?></span></a>
            <ul class="listitems">
                <li data-functionName="0" data-linkto="/usuarios" class="dataLink"><span class="spanStyleMenu"></span><span>Lista de Usuarios</span><span></span></li>
                <li data-functionName="0" data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Reportes</span><span></span></li>
            </ul>
        </li>
        <li>
            <a class="btnSlideDown" href="/dashboard"><span><?= $icons['lock'] ?></span><span>Permisos</span><span class="menu_down"><?= $icons['arrow_down'] ?></span></a>
            <ul class="listitems">
                <li data-functionName="0" data-linkto="/roles" class="dataLink"><span class="spanStyleMenu"></span><span>Permisos por Rol</span><span></span></li>
            </ul>
        </li>
        <li>
            <a class="btnSlideDown" href="/dashboard"><span><?= $icons['history'] ?></span><span>Historial</span><span class="menu_down"><?= $icons['arrow_down'] ?></span></a>
            <ul class="listitems">
                <li data-functionName="0" data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Historial</span><span></span></li>
                <li data-functionName="0" data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Reporte</span><span></span></li>
            </ul>
        </li>
        <li class="uniq_menu">
            <a href="/logout"><span><?= $icons['exit'] ?></span><span>Cerrar Sesion</span><span class="menu_down"></span></a>
        </li>

    </ul>

</div>