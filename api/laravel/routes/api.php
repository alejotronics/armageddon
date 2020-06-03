<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

// AGRUPAR Y USAR MIDDLEWARE
//Route::middleware('auth:api')->group( function () {
//    Route::get('/productos', 'ProductoController@listar');
//});

// Rutas API (Version 1)
Route::group(['prefix' => 'v1'], function () {

    /**
     * AUTENTICACION
     */
    Route::post('/login', 'AutenticacionController@login');
    Route::post('/register', 'AutenticacionController@register');
    Route::get('/logout', 'AutenticacionController@logout')->middleware('auth:api');
    Route::get('/token', 'AutenticacionController@verificar_token')->middleware('auth:api'); // Probar el token


    /**
     * USUARIO
     */
    Route::group(['prefix' => 'usuario', 'middleware'=>'auth:api'], function () {

        // Informacion
        Route::get('/', 'UsuarioController@info');

        // Subscripciones
        Route::get('/suscripciones', 'SuscripcionController@listar');
        //Route::post('/suscripcion/{id}', 'SuscripcionController@crear'); ===> /v1/tienda/{id}/suscripcion
        Route::delete('/suscripcion/{id}', 'SuscripcionController@eliminar');

        // Favoritos
        Route::get('/favoritos', 'FavoritoController@listar');              // Listar
        Route::post('/pedido/{id}/favorito', 'FavoritoController@crear');   // Crear (Añadir Pedido a Favoritos)
        Route::delete('/favorito/{id}', 'FavoritoController@eliminar');     // Eliminar (Quitar Pedido de Favoritos)

        // Pedidos
        Route::get('/pedidos', 'PedidoController@listar');          // Listar
        Route::get('/pedido/{id}', 'PedidoController@ver');         // Ver
        Route::put('/pedido/{id}', 'PedidoController@editar');      // Editar
        //Route::put('/pedido/{id}', 'PedidoController@editar');    // Editar
        //Route::delete('/pedido/{id}', 'PedidoController@eliminar');
        Route::post('/pedido/{id}/pagar', 'PedidoController@pagar'); // Pagar y generar QR

    });


    /**
     * TIENDA - Propia (como propietario de la tienda)
     */
    Route::group(['prefix' => 'tienda', 'middleware' => 'auth:api'], function () {

        // Tienda
        Route::get('/', 'TiendaPropiaController@ver');          // Ver
        Route::post('/', 'TiendaPropiaController@crear');       // Crear
        Route::put('/', 'TiendaPropiaController@editar');       // Editar
        Route::delete('/', 'TiendaPropiaController@eliminar');  // Eliminar

        // Productos
        Route::get('/productos', 'TiendaPropiaController@productos_listar');                    // Listar
        Route::get('/producto/{idProducto}', 'TiendaPropiaController@productos_ver');           // Ver
        Route::post('/producto', 'TiendaPropiaController@productos_crear');                     // Crear
        Route::put('/producto/{idProducto}', 'TiendaPropiaController@productos_editar');        // Editar
        Route::delete('/producto/{idProducto}', 'TiendaPropiaController@productos_eliminar');   // Eliminar

        // Categorias
        Route::get('/categorias', 'TiendaPropiaController@categorias_listar');
        Route::post('/categoria', 'TiendaPropiaController@categorias_crear');
        Route::delete('/categoria/{idCategoria}', 'ConTiendaPropiaControllertroller@categorias_eliminar');

        // Horario
        Route::get('/horario', 'TiendaPropiaController@horario_ver');
        Route::post('/horario', 'TiendaPropiaController@horario_crear');
        Route::put('/horario', 'TiendaPropiaController@horario_editar');
        Route::delete('/horario', 'TiendaPropiaController@horario_eliminar');

        // Pedidos
        Route::get('/pedidos', 'TiendaPropiaController@pedidos_listar');
        Route::get('/pedido/{idPedido}', 'TiendaPropiaController@pedidos_ver');
        Route::delete('/pedido/{idPedido}', 'TiendaPropiaController@pedidos_eliminar');

    });

    // Listar tiendas
    Route::get('/tiendas', 'TiendasController@listar')->middleware('auth:api');;

    /**
     * TIENDA - Otras (como usuario de la aplicacion)
     */

    Route::group(['prefix' => 'tienda/{id}', 'middleware' => 'auth:api'], function () {

        // Tienda
        Route::get('/', 'TiendasController@ver');   // Ver (Informacion de la Tienda)

        // Productos
        Route::get('/productos', 'TiendasController@productos_listar');             // Listar (Productos de la Tienda)
        Route::get('/producto/{idProducto}', 'TiendasController@productos_ver');    // Ver (Producto de la Tienda)

        // Categorias
        Route::get('/categorias', 'TiendasController@categorias_listar');           // Listar (Categorias de la tienda)

        // Horario
        Route::get('/horario', 'TiendasController@horario_ver');        // Ver  (Horario de la Tienda)

        // Pedidos
        Route::get('/pedidos', 'TiendasController@pedidos_listar');     // Listar (Pedidos realizados en la Tienda)
        //Route::get('/pedido/{idPedido}', 'TiendasController@pedidos_ver');            ===> v1/usuario/pedido/{id}
        Route::post('/pedido', 'PedidoController@pedidos_crear');      // Crear (Pedido en esa Tienda)
        //Route::put('/pedido/{idPedido}', 'TiendasController@pedidos_editar');         ===> v1/usuario/pedido/{id}
        //Route::delete('/pedido/{idPedido}', 'TiendasController@pedidos_eliminar');    ===> v1/usuario/pedido/{id}/

        // Pedidos Favoritos
        Route::get('/pedidos/favoritos', 'TiendasController@favoritos_listar');             // Listar (Pedidos Favoritos de la tienda)
        //Route::post('/pedido/{idPedido}/favorito', 'TiendasController@favoritos_crear');  ===> /v1/usuario/pedidos/{id}/favorito  // Crear (Pedido Favorito)

    });


    /**
     * PRODUCTOS
     */
    Route::get('/productos', 'ProductoController@listar');      // Listar
    Route::get('/producto/{id}', 'ProductoController@ver');     // Ver

});


