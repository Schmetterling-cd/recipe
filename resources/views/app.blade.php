<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{  env('APP_NAME')  }}</title>

    @vite('resources/css/app.css')
</head>
<body>
<div id="app"></div>

@vite('resources/js/app.js')
</body>
</html>

<script>
    window.Laravel  = @json([
        'name' => config('app.name'),
        'url' => config('app.url'),
        'env' => config('app.env')
    ])
</script>
