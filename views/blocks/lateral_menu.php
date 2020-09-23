<div class="menuContainer">
    <p><?php echo $_SESSION['sucursal'] ?></p>
    <p>Menu</p>
    <ul class="main_menu" id="main_menu">
        <li>
            <a class="btnSlideDown" href="/dashboard"><span><?= $icons['dashboard'] ?></span><span>Dashboard</span><span class="menu_down"><?= $icons['arrow_down'] ?></span></a>
            <ul class="listitems">
                <li data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>General</span><span></span></li>
                <li data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Productos</span><span></span></li>
                <li data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Vendedores</span><span></span></li>
                <li data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Mensuales</span><span></span></li>
            </ul>
        </li>
        <li>
            <a class="btnSlideDown" href="/dashboard"><span><?= $icons['gear'] ?></span><span>Admin</span><span class="menu_down"><?= $icons['arrow_down'] ?></span></a>
            <ul class="listitems">
                <li data-linkto="/sucursal" class="dataLink"><span class="spanStyleMenu"></span><span>Sucursales</span><span></span></li>
                <li data-linkto="/admin/gastos" class="dataLink"><span class="spanStyleMenu"></span><span>Gastos</span><span></span></li>
                <li data-linkto="/admin/categoriaprecios" class="dataLink"><span class="spanStyleMenu"></span><span>Categorias de precios</span><span></span></li>
                <li data-linkto="/admin/categoriastallas" class="dataLink"><span class="spanStyleMenu"></span><span>Categorias y Tallas</span><span></span></li>
                <li data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Reportes</span><span></span></li>
            </ul>
        </li>
        <li>
            <a class="btnSlideDown" href="/dashboard"><span><?= $icons['calc'] ?></span><span>Facturacion</span><span class="menu_down"><?= $icons['arrow_down'] ?></span></a>
            <ul class="listitems">
                <li data-linkto="/facturacion/facturar" class="dataLink"><span class="spanStyleMenu"></span><span>Facturar</span><span></span></li>
                <li data-linkto="/facturacion" class="dataLink"><span class="spanStyleMenu"></span><span>Cajas</span><span></span></li>
                <li data-linkto="/facturacion" class="dataLink"><span class="spanStyleMenu"></span><span>Reportes</span><span></span></li>
                <li data-linkto="/facturacion" class="dataLink"><span class="spanStyleMenu"></span><span>Apartados</span><span></span></li>
            </ul>
        </li>
        <li>
            <a class="btnSlideDown" href="/inventario"><span><?= $icons['box'] ?></span><span>Inventario</span><span class="menu_down"><?= $icons['arrow_down'] ?></span></a>
            <ul class="listitems">
                <li data-linkto="/inventario/listarproductos" class="dataLink"><span class="spanStyleMenu"></span><span>Lista de Productos</span><span></span></li>
                <li data-linkto="/inventario/addstock" class="dataLink"><span class="spanStyleMenu"></span><span>Stock y Precios</span><span></span></li>
                <li data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Reportes</span><span></span></li>
            </ul>
        </li>
        <li>
            <a class="btnSlideDown" href="/dashboard"><span><?= $icons['clients'] ?></span><span>Clientes</span><span class="menu_down"><?= $icons['arrow_down'] ?></span></a>
            <ul class="listitems">
                <li data-linkto="/clientes/lista" class="dataLink"><span class="spanStyleMenu"></span><span>Lista de Clientes</span><span></span></li>
                <li data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Reportes</span><span></span></li>
            </ul>
        </li>
        <li>
            <a class="btnSlideDown" href="/dashboard"><span><?= $icons['users'] ?></span><span>Usuarios</span><span class="menu_down"><?= $icons['arrow_down'] ?></span></a>
            <ul class="listitems">
                <li data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Agregar Usuario</span><span></span></li>
                <li data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Lista de Usuarios</span><span></span></li>
                <li data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Reportes</span><span></span></li>
            </ul>
        </li>
        <li class="uniq_menu">
            <a href="/dashboard"><span><?= $icons['lock'] ?></span><span>Permisos</span><span></span></a>
        </li>
        <li>
            <a class="btnSlideDown" href="/dashboard"><span><?= $icons['history'] ?></span><span>Historial</span><span class="menu_down"><?= $icons['arrow_down'] ?></span></a>
            <ul class="listitems">
                <li data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Historial</span><span></span></li>
                <li data-linkto="/" class="dataLink"><span class="spanStyleMenu"></span><span>Reporte</span><span></span></li>
            </ul>
        </li>
        <li class="uniq_menu">
            <a href="/logout"><span><?= $icons['exit'] ?></span><span>Cerrar Sesion</span><span class="menu_down"></span></a>
        </li>
        <li class="uniq_menu2">
            <a target='_blank' href="C:\xampp\php\logs"><span><?= $icons['exit'] ?></span><span>Log</span><span class="menu_down"></span></a>
        </li>

    </ul>

</div>