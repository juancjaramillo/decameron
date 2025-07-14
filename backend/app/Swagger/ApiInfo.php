<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Decameron API",
 *     description="Documentación de la API de gestión de hoteles y configuraciones de habitación",
 *     @OA\Contact(
 *         email="soporte@decameron.com",
 *         name="Equipo de Desarrollo Decameron"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Servidor local de desarrollo"
 * )
 */
class ApiInfo
{
    
}
