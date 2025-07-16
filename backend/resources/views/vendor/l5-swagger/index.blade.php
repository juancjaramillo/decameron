<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $documentationTitle }}</title>

    {{-- Assets de Swagger UI --}}
    <link rel="stylesheet" href="{{ l5_swagger_asset($documentation, 'swagger-ui.css') }}">
    <link rel="icon" href="{{ l5_swagger_asset($documentation, 'favicon-32x32.png') }}" sizes="32x32"/>
    <link rel="icon" href="{{ l5_swagger_asset($documentation, 'favicon-16x16.png') }}" sizes="16x16"/>

    <style>
        html{box-sizing:border-box;overflow-y:scroll}
        *,*:before,*:after{box-sizing:inherit}
        body{margin:0;background:#fafafa}
    </style>

    @if(config('l5-swagger.defaults.ui.display.dark_mode'))
        <style>/* … estilos dark mode … */</style>
    @endif
</head>

<body @if(config('l5-swagger.defaults.ui.display.dark_mode')) id="dark-mode" @endif>
<div id="swagger-ui"></div>

<script src="{{ l5_swagger_asset($documentation, 'swagger-ui-bundle.js') }}"></script>
<script src="{{ l5_swagger_asset($documentation, 'swagger-ui-standalone-preset.js') }}"></script>

<script>
window.onload = function () {
  /* ----------------------------------------------------------
   * 1) Instanciar Swagger‑UI
   * ---------------------------------------------------------- */
  const urls = [];
  @foreach($urlsToDocs as $title => $url)
    urls.push({ name: "{{ $title }}", url: "{{ $url }}" });
  @endforeach

  const ui = SwaggerUIBundle({
    dom_id: '#swagger-ui',
    urls,                         // lista de archivos JSON (sólo 1 aquí)
    "urls.primaryName": "{{ $documentationTitle }}",
    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],
    plugins: [ SwaggerUIBundle.plugins.DownloadUrl ],
    layout: "StandaloneLayout",
    docExpansion: "{{ config('l5-swagger.defaults.ui.display.doc_expansion', 'none') }}",
    deepLinking: true,
    filter: {{ config('l5-swagger.defaults.ui.display.filter') ? 'true' : 'false' }},
    persistAuthorization: {{ config('l5-swagger.defaults.ui.authorization.persist_authorization') ? 'true' : 'false' }},
  });

  window.ui = ui;

  /* ----------------------------------------------------------
   * 2) LOGIN AUTOMÁTICO  (VARIANTE C)
   * ---------------------------------------------------------- */
  // ⇨ Ajusta estas credenciales a las que use tu endpoint de login
  const creds = {
    email:    'prueba@prueba.com',
    password: 'prueba123'
  };

  fetch('/api/v1/auth/token', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
    body: JSON.stringify(creds),
  })
  .then(resp => resp.ok ? resp.json() : Promise.reject(resp))
  .then(data => {
    if (!data.token) return;
    const bearer = 'Bearer ' + data.token;

    // Pre‑autoriza en Swagger
    ui.preauthorizeApiKey('bearerAuth', bearer);

    // Guarda por si se recarga
    localStorage.setItem('swagger_token', bearer);
  })
  .catch(console.error);
};
</script>
</body>
</html>
