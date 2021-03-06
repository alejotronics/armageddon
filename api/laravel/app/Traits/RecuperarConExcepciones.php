<?php
namespace App\Traits;
use App\Pedido;
use App\Tienda;
use Auth;

trait RecuperarConExcepciones {

    /**
     * Recuperar objetos y comprovar que devuelven resultados
     * Si NO devuelven resultados, ENVIA UNA RESPUESTA DE ERROR y sale del codigo
     */

    /**
     * Tienda propia (usuario logeado)
     */
    public function recuperarTiendaPropia()
    {
        $tienda = Auth::user()->tienda;
        //$tienda = Tienda::where('id_propietario', Auth::user()->id);
        if($tienda == null) {
            $this->sendErrorNotFound("No has creado ninguna tienda")->send();
            exit();
        }
        return $tienda;
    }

    /**
     * Tienda by ID
     */
    public function recuperarTiendaById($idTienda)
    {
        // Recuperar la tienda por ID
        $tienda = Tienda::where('id', $idTienda)->first();

        if($tienda == null) {
            $this->sendErrorNotFound("Tienda no encontrada")->send();
            exit();
        }

        return $tienda;
    }

    /**
     * Pedido by ID
     */
    public function recuperarPedidoPropioById($idPedido)
    {
        $pedido = Auth::user()->pedidos->where('id', $idPedido)->first();
        if($pedido == null) {
            $this->sendErrorNotFound("No existe el pedido")->send();
            exit();
        }

        return $pedido;
    }

    public function recuperarPedidoPropioByIdSinEager($idPedido)
    {
        $pedido = Pedido::setEagerLoads([])->where('id_usuario', Auth::user()->id)->where('id', $idPedido)->first();
        if($pedido == null) {
            $this->sendErrorNotFound("No existe el pedido")->send();
            exit();
        }

        return $pedido;
    }

}
