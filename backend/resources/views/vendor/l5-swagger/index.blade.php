<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $documentationTitle }}</title>
    <link rel="stylesheet" href="{{ l5_swagger_asset($documentation, 'swagger-ui.css') }}">
    <link rel="icon" href="{{ l5_swagger_asset($documentation, 'favicon-32x32.png') }}" sizes="32x32"/>
    <link rel="icon" href="{{ l5_swagger_asset($documentation, 'favicon-16x16.png') }}" sizes="16x16"/>
    <style>
        html { box-sizing: border-box; overflow-y: scroll; }
        *, *:before, *:after { box-sizing: inherit; }
        body { margin:0; background: #fafafa; }
    </style>
    @if(config('l5-swagger.defaults.ui.display.dark_mode'))
    <style>/* estilos dark mode omitidos */</style>
    @endif
</head>
<body @if(config('l5-swagger.defaults.ui.display.dark_mode')) id="dark-mode" @endif>
<div id="swagger-ui"></div>

<script src="{{ l5_swagger_asset($documentation, 'swagger-ui-bundle.js') }}"></script>
<script src="{{ l5_swagger_asset($documentation, 'swagger-ui-standalone-preset.js') }}"></script>
<script>
window.onload = function() {
    const urls = [];
    @foreach($urlsToDocs as $title => $url)
    urls.push({ name: "{{ $title }}", url: "{{ $url }}" });
    @endforeach

    const ui = SwaggerUIBundle({
        dom_id: '#swagger-ui',
        urls: urls,
        "urls.primaryName": "{{ $documentationTitle }}",
        operationsSorter: {!! isset($operationsSorter) ? '"' . $operationsSorter . '"' : 'null' !!},
        configUrl:        {!! isset($configUrl) ? '"' . $configUrl . '"' : 'null' !!},
        validatorUrl:     {!! isset($validatorUrl) ? '"' . $validatorUrl . '"' : 'null' !!},
        oauth2RedirectUrl: "{{ route('l5-swagger.'.$documentation.'.oauth2_callback', [], $useAbsolutePath) }}",
        requestInterceptor: function(request) {
            return request;
        },
        presets: [
            SwaggerUIBundle.presets.apis,
            SwaggerUIStandalonePreset
        ],
        plugins: [
            SwaggerUIBundle.plugins.DownloadUrl
        ],
        layout: "StandaloneLayout",
        docExpansion: "{!! config('l5-swagger.defaults.ui.display.doc_expansion', 'none') !!}",
        deepLinking: true,
        filter: {!! config('l5-swagger.defaults.ui.display.filter') ? 'true' : 'false' !!},
        persistAuthorization: "{!! config('l5-swagger.defaults.ui.authorization.persist_authorization') ? 'true' : 'false' !!}",
    });

    window.ui = ui;

    // ——— INYECCIÓN AUTOMÁTICA DEL TOKEN ———
    const creds = { email: 'prueba@prueba.com', password: 'prueba123' };
    fetch('/api/v1/auth/token', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(creds),
    })
    .then(res => res.json())
    .then(json => {
        if (!json.token) return;
        ui.authActions.authorize({
            sanctum: {
                name: 'Authorization',
                schema: { type: 'apiKey', in: 'header', name: 'Authorization' },
                value: 'Bearer ' + json.token
            }
        });
    })
    .catch(console.error);
};
</script>
</body>
</html>
