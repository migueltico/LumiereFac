<?php

namespace http\routes;

use config\route;

//------------- +++ RUTAS GET +++ -----------------//

//+++++++++++ LOGIN +++++++++++//
route::get('/', 'loginController@index', ['loginMiddleware@auth']);
route::post('/validateauth', 'loginController@validar');
route::post('/validateauth*', 'loginController@validar');
route::get('/logout', 'loginController@logout');
route::get('/funcion/:char/:format/:valor', 'facturacionController@test');
//+++++++++++ DASHBOARD +++++++++++//
route::get('/dashboard', 'dashboardController@index', ['loginMiddleware@auth']);
route::post('/dashboard/general', 'dashboardController@general', ['loginMiddleware@auth']);
//+++++++++++ SUCURSAL +++++++++++//
route::post('/sucursal', 'sucursalController@index', ['loginMiddleware@auth']);
route::post('/sucursal/addSucursal', 'sucursalController@addSucursal');
route::post('/sucursal/updateSucursal', 'sucursalController@updateSucursal');
route::post('/sucursal/getSucursalById', 'sucursalController@getSucursalById');
route::post('/sucursal/refresh/sucursaltable', 'sucursalController@sucursaltable');
route::post('/sucursal/deleteSucursal', 'sucursalController@deleteSucursal');
//+++++++++++ ADMIN +++++++++++//
route::group('admin', function () {
    route::post('/gastos', 'adminController@indexGastos', ['loginMiddleware@auth']);
    route::post('/gastos/saveGastos', 'adminController@saveGastos');
    route::post('/general', 'adminController@general', ['loginMiddleware@auth']);

    route::post('/general/SaveGeneralInfo', 'adminController@SaveGeneralInfo', ['loginMiddleware@auth']);

    route::post('/categoriaprecios', 'adminController@indexCategoriaPrecios', ['loginMiddleware@auth']);
    route::post('/categoriastallas', 'adminController@indexCategoriasTallas', ['loginMiddleware@auth']);
    route::post('/categoriastallas/AddCategoria', 'adminController@AddCategoria');
    route::post('/categoriastallas/AddTalla', 'adminController@AddTalla');
    route::post('/descuentos', 'adminController@descuentos', ['loginMiddleware@auth']);
    route::post('/descuentos/lote', 'adminController@descuentosPorLote');
    route::post('/descuentos/addnewDescuento', 'adminController@addnewDescuento');
    route::post('/descuentos/EditarDescuento', 'adminController@EditarDescuento');
    route::post('/descuentos/aplicarDescuentoEnLote', 'adminController@aplicarDescuentoEnLote');
    route::post('/categoriastallas/table', 'adminController@tableCategoriaTallas');
    route::post('/categoriastallas/editCategoria', 'adminController@editCategorias');
    route::post('/categoriastallas/editTallas', 'adminController@editTallas');
    route::post('/categoriaprecios/table', 'adminController@tableCategoriaPrecios');
    route::post('/categoriaprecios/add', 'adminController@AddCategoriaPrecios');
    route::post('/categoriaprecios/edit', 'adminController@EditCategoriaPrecios');
    route::post('/categoriaprecios/delete', 'adminController@DeleteCategoriaPrecios');
});
//+++++++++++ INVENTARIO +++++++++++//
route::group('inventario', function () {
    route::post('/listarproductos', 'inventarioController@index', ['loginMiddleware@auth']);
    route::post('/addproduct', 'inventarioController@addproduct', ['loginMiddleware@auth']);
    route::post('/updateProduct', 'inventarioController@updateProduct');
    route::post('/getProductById', 'inventarioController@getProductById');
    route::post('/refresh/producttable', 'inventarioController@producttable');
    route::post('/refresh/RefreshBySucursalTableProduct', 'inventarioController@RefreshBySucursalTableProduct');
    route::post('/generar/codigobarras', 'inventarioController@generarCodigo');
    route::post('/search', 'inventarioController@searchProduct');
    route::post('/search/stock', 'inventarioController@searchProductstock');
    route::post('/addstock', 'inventarioController@addstock', ['loginMiddleware@auth']);
    route::post('/refreshProductstock', 'inventarioController@refreshProductstock');
    route::post('/saveProductPrice', 'inventarioController@saveProductPrice');
    route::post('/updateStock', 'inventarioController@updateStock');
    route::post('/updateMinStock', 'inventarioController@updateMinStock');
    route::post('/calcular/sugerido', 'inventarioController@calcular_sugerido');
    route::post('/impresion/etiquetas', 'inventarioController@indexEtiquetas', ['loginMiddleware@auth']);
});
//+++++++++++ FACTURACION +++++++++++//
route::group('facturacion', function () {
    route::post('/facturar', 'facturacionController@index', ['loginMiddleware@auth','cajasMiddleware@cajaAsignada']);
    route::post('/search/product', 'facturacionController@searchProduct');
    route::post('/search/product/ctrlq', 'facturacionController@searchProductCtrlQ');
    route::post('/facturaVenta', 'facturacionController@getFact');
    route::post('/pendientes', 'facturacionController@pendientes', ['loginMiddleware@auth']);
    route::post('/pendientes/productos', 'facturacionController@pendientesProductos');
    route::post('/pendientes/changeStateFac', 'facturacionController@changeStateFac');
    route::post('/cajas', 'facturacionController@cajas', ['loginMiddleware@auth']);
    route::post('/cajas/abrirCaja', 'facturacionController@abrirCaja');
    route::post('/cajas/abrirCajaEstado', 'facturacionController@abrirCajaEstado');
    route::post('/cajas/obtenerEstadoCajaEstado', 'facturacionController@obtenerEstadoCajaEstado');
    route::post('/cajas/cerrarcajafinal', 'facturacionController@cerrarcajafinal');
    route::post('/apartados/getApartadosHasClient', 'facturacionController@getApartadosHasClient');
    route::post('/apartados/getProductsFromApartado', 'facturacionController@getProductsFromApartado');
    route::post('/apartados/setAbono', 'facturacionController@setAbono');
    route::post('/historial/diario', 'facturacionController@historialDiario', ['loginMiddleware@auth']);
    route::post('/historial/apartados', 'facturacionController@apartadosSinCancelar', ['loginMiddleware@auth']);
});
//+++++++++++ CLIENTES +++++++++++//
route::group('clientes', function () {
    route::post('/lista', 'clientesController@index', ['loginMiddleware@auth']);
    route::post('/addcliente', 'clientesController@addNewClient');
    route::post('/getClienteById', 'clientesController@getClienteById');
    route::post('/updateClienteById', 'clientesController@updateClienteById');
    route::post('/refreshClients', 'clientesController@refreshClients');
    route::post('/search/searchclient', 'clientesController@searchClient');
});
//+++++++++++ USUARIOS +++++++++++//
route::group('usuarios', function () {
    route::post('/', 'usuariosController@index', ['loginMiddleware@auth']);
    route::post('/setUser', 'usuariosController@setUser');
});
//+++++++++++ SERVER +++++++++++//
    route::get('/getPassword/:db/:identificador', 'usuariosController@getNewPassword');
    route::post('/setPassword', 'usuariosController@setNewPassword');
    route::post('/verIdentificador', 'usuariosController@verIdentificador');
//+++++++++++ ROLES +++++++++++//
route::group('roles', function () {
    route::post('/', 'rolesController@index', ['loginMiddleware@auth']);
    route::post('/getRoles', 'rolesController@getRoles');
    route::post('/newRol', 'rolesController@newRol');
    route::post('/saveRoles', 'rolesController@saveRoles');
    route::post('/getRolesPermisos', 'rolesController@getRolesPermisos');
});
//+++++++++++ REPORTES +++++++++++//
route::group('reportes', function () {
    route::get('/etiquetas', 'reportesController@etiquetasTallaEstilo', ['loginMiddleware@auth']);
    route::post('/etiquetas', 'reportesController@etiquetasTallaEstiloPost');
});
//+++++++++++ SUBIDA DE ARCHIVOS +++++++++++//
route::post('/upload/files', 'uploadsController@uploads');
route::post('/remove/img', 'uploadsController@removeImgAdd');
//+++++++++++ FACTURACION +++++++++++//
//route::get('/', 'indexController@dashboard', ["loginMiddleware@validate_login"]);


// route::group('admin', function () {


//     route::get('/', 'indexController@index');
//     route::get('/contact1', 'indexController@index');
//     route::get('/blog/buscar', 'indexController@index');
//     route::get('/tienda/producto1/:id', 'indexController@index');
//     route::middleware(['loginMiddleware@token', 'login@prueba'], function () {
//         route::post('/blog/buscar/id', 'indexController@index', ["login@prueba"]);
//         route::get('/home2', 'indexController@index');
//         route::get('/contact2', 'indexController@index');
//         route::get('/blog/buscar2', 'indexController@index');
//         route::get('/tienda/producto2/:id', 'indexController@index', ['login@prueba', 'login@token']);
//     });
// });
// route::middleware(['loginMiddleware@validate_login', 'loginMiddleware@token'], function () {
//     route::get('/', 'indexController@index', ['loginMiddleware@prueba', 'loginMiddleware@prueba']);
//     route::get('/contact', 'indexController@index');
//     route::get('/blog/buscar', 'indexController@index');
//     route::get('/tienda/producto3/:id', 'indexController@index');
//     route::get('/home/:id', 'indexController@b', ['loginMiddleware@prueba']);
//     route::get('/home', 'indexController@b', ['loginMiddleware@prueba']);
//     route::post('/home/:id', 'indexController@b', ['loginMiddleware@prueba']);
// });
// route::get('/tienda/producto/:idproduct/categoria/:cat_id/user/:userid', 'indexController@index');
// route::get('/tienda/producto5/:idproduct/categoria/:cat_id/user/:userid', 'indexController@index');
// route::get('/tienda/producto/:idproduct/categoria/:cat_id/user/prueba', 'indexController@index');
// route::get('/contact/custom', 'indexController@index');
// route::get('/blog/buscar/id', 'indexController@index');
// route::get('/tienda/producto4/:idproduct/categoria/:cat_id', 'indexController@index', ["loginMiddleware@prueba"]);
// route::post('/tienda/producto', 'indexController@index', ["loginMiddleware@prueba"]);

// route::post('/tienda/producto', 'indexController@index', ["loginMiddleware@prueba"]);
