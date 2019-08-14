<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Polygonal location search demo</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body class="bg-light">
        <div class="container">
            <div class="py-5 text-center">
                <h1>Polygonal map search demo</h1>
                <p class="lead">
                    A demo of the power of Mysql 8 for searching Points within a Polygon for mapping purposes.
                </p>
            </div>
            <div class="d-flex justify-content-center" id="app">
                <demo-map :lat="50.884408" :lon="5.756073" :zoom="16"></demo-map>
            </div>
        </div>
        <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    </body>
</html>
