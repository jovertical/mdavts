<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>
            @yield('title')
        </title>

        <style>
            html, body {
                font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif
            }

            body {
                margin: 0;
                padding: 0;
            }

            .heading {
                text-align: center;
            }

            .table {
                width: 100%;
            }
        </style>
    </head>

    <body>
        @yield('content')
    </body>
</html>