<?php

namespace http\routes;

use config\route;

//------------- +++ RUTAS GET +++ -----------------//

//+++++++++++ LOGIN +++++++++++//
route::post('/validateauth', 'loginController@validar');
route::post('/validateauth*', 'loginController@validar');
route::get('/logout', 'loginController@logout');
route::get('/', 'loginController@index', ['loginMiddleware@auth']);
//+++++++++++ DASHBOARD +++++++++++//
route::get('/dashboard', 'dashboardController@index', ['loginMiddleware@auth']);
//+++++++++++ SUCURSAL +++++++++++//
route::post('/sucursal', 'sucursalController@index', ['loginMiddleware@auth']);
route::post('/sucursal/addSucursal', 'sucursalController@addSucursal');
route::post('/sucursal/updateSucursal', 'sucursalController@updateSucursal');
route::post('/sucursal/getSucursalById', 'sucursalController@getSucursalById');
route::post('/sucursal/refresh/sucursaltable', 'sucursalController@sucursaltable');
route::post('/sucursal/deleteSucursal', 'sucursalController@deleteSucursal');
//+++++++++++ ADMIN +++++++++++//
route::post('/admin/gastos', 'adminController@indexGastos', ['loginMiddleware@auth']);
route::post('/admin/gastos/saveGastos', 'adminController@saveGastos');
route::post('/admin/categoriaprecios', 'adminController@indexCategoriaPrecios', ['loginMiddleware@auth']);
route::post('/admin/categoriaprecios/table', 'adminController@tableCategoriaPrecios');
route::post('/admin/categoriaprecios/add', 'adminController@AddCategoriaPrecios');
route::post('/admin/categoriaprecios/edit', 'adminController@EditCategoriaPrecios');
route::post('/admin/categoriaprecios/delete', 'adminController@DeleteCategoriaPrecios');
//+++++++++++ INVENTARIO +++++++++++//
route::post('/inventario/listarproductos', 'inventarioController@index', ['loginMiddleware@auth']);
route::post('/inventario/addproduct', 'inventarioController@addproduct');
route::post('/inventario/updateProduct', 'inventarioController@updateProduct');
route::post('/inventario/getProductById', 'inventarioController@getProductById');
route::post('/inventario/refresh/producttable', 'inventarioController@producttable');
route::post('/inventario/refresh/RefreshBySucursalTableProduct', 'inventarioController@RefreshBySucursalTableProduct');
route::post('/inventario/generar/codigobarras', 'inventarioController@generarCodigo');
route::post('/inventario/search', 'inventarioController@searchProduct');
route::post('/inventario/search/stock', 'inventarioController@searchProductstock');
route::post('/inventario/addstock', 'inventarioController@addstock');
route::post('/inventario/refreshProductstock', 'inventarioController@refreshProductstock');
route::post('/inventario/saveProductPrice', 'inventarioController@saveProductPrice');
route::post('/inventario/updateStock', 'inventarioController@updateStock');
route::post('/inventario/updateMinStock', 'inventarioController@updateMinStock');
route::post('/inventario/calcular/sugerido', 'inventarioController@calcular_sugerido');
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