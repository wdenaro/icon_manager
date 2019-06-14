<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Show_Images</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>

            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
            }

        </style>
    </head>
    <body>

    @if ($image_data['total_images'] === 0)
        No Images Found
    @else

        @if (isset($image_data['s']))
            <h1>S-Numbers</h1>
            @foreach ($image_data['s'] as $image)
                <img src="https://www.staples-3p.com/s7/is/image/Staples/{{ $image->snumber }}_sc7?wid=200&hei=200" title="{{ $image->snumber }}">
            @endforeach
        @endif

        @if (isset($image_data['m']))
            <h1>M-Numbers</h1>
            @foreach ($image_data['m'] as $image)
                <img src="https://www.staples-3p.com/s7/is/image/Staples/{{ $image->image_id }}_sc7?wid=200&hei=200" title="{{ $image->image_id }}">
            @endforeach
        @endif

    @endif

    </body>
</html>
