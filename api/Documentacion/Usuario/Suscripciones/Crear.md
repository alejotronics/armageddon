# Crear

Crear una suscripcion a una Tienda si no existe

**URL** : `/tienda/{idTienda}/suscripcion`

**Metodo** : `POST`

**Auth requerida** : SI

**Datos** :

* {idTienda}: ID de la Tienda a la que suscribirse

## Respuesta Correcta

**Codigo** : `200 OK`

**Ejemplo contenido**

Si aun no esta suscrito a la tienda :
```json
{
    "success": true
}
```

Si ja esta suscrito a la tienda :
```json
{
    "success": true,
    "message": "El usuario ja esta suscrito"
}
```


## Respuesta Incorrecta

#### [400 Bad Request](../General/Errores.md#400-bad-request)

#### [404 Not Found](../General/Errores.md#404-not-found)
Mensajes:
* La Tienda especificada no existe

#### [500 Internal Server Error](../General/Errores.md#500-internal-server-error)

## Notas
