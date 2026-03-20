<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| URL completa del endpoint JSON de planes (Laravel intranet back).
| Ejemplo: https://api.tu-dominio-intranet.pe/api/public/curso-membresia/planes
|
| Puedes definir en el servidor:
|   API_CURSO_MEMBRESIA_PLANES_URL=https://.../api/public/curso-membresia/planes
| o solo la base:
|   LARAVEL_API_BASE_URL=https://.../api
| y se concatena la ruta pública automáticamente.
*/
$envFull = getenv('API_CURSO_MEMBRESIA_PLANES_URL');
if ($envFull !== false && $envFull !== '') {
    $config['api_curso_membresia_planes_url'] = $envFull;
} else {
    $base = getenv('LARAVEL_API_BASE_URL');
    if ($base !== false && $base !== '') {
        $config['api_curso_membresia_planes_url'] = rtrim($base, '/') . '/public/curso-membresia/planes';
    } else {
        // Fallback local: Laravel corriendo en localhost:8000 (ajustar en producción)
        $config['api_curso_membresia_planes_url'] = 'http://127.0.0.1:8000/api/public/curso-membresia/planes';
    }
}

/*
| Base para GET /public/ubicacion/* (países, departamentos, provincias, distritos).
| Se deriva de LARAVEL_API_BASE_URL: .../api + /public/ubicacion
| Opcional: API_PUBLIC_UBICACION_BASE_URL (URL completa sin slash final)
*/
$config['api_public_ubicacion_base_url'] = '';
$envUbiOverride = getenv('API_PUBLIC_UBICACION_BASE_URL');
if ($envUbiOverride !== false && $envUbiOverride !== '') {
    $config['api_public_ubicacion_base_url'] = rtrim($envUbiOverride, '/');
} elseif (isset($config['api_curso_membresia_planes_url']) && $config['api_curso_membresia_planes_url'] !== '') {
    // Mismo host que planes: .../api/public/curso-membresia/planes -> .../api/public/ubicacion
    $planesUrl = $config['api_curso_membresia_planes_url'];
    if (preg_match('#^(https?://[^/]+/.+)/public/curso-membresia/planes/?$#i', $planesUrl, $m)) {
        $config['api_public_ubicacion_base_url'] = $m[1] . '/public/ubicacion';
    }
} else {
    $baseApi = getenv('LARAVEL_API_BASE_URL');
    if ($baseApi !== false && $baseApi !== '') {
        $config['api_public_ubicacion_base_url'] = rtrim($baseApi, '/') . '/public/ubicacion';
    }
}

/*
| Montos fallback en PEN para Izipay CreatePayment (se envían ×100 céntimos).
| Solo se usan si la API pública no devuelve price_amount para un tipo_pago.
*/
$config['curso_izipay_pen_montos_fallback'] = array(1 => 200, 2 => 300, 3 => 385);
