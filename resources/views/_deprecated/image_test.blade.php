<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Show_Images</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('/css/styles.css') }}" rel="stylesheet" type="text/css">

        <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
        <script src="{{ asset('js/Greensock/TweenMax.min.js') }}"></script>
        <script src="{{ asset('js/Greensock/Draggable.min.js') }}"></script>

    </head>
    <body>

    <div class="wrapper">

        <div class="production_box"></div>

        <div class="controls">
            <p><a class="right">R</a> <a class="right_s">r</a> <a class="left">L</a> <a class="left_s">l</a>  <a class="q">?</a></p>
        </div>

        <div class="stage">
            <p><img class="akamai" src="https://www.staples-3p.com/s7/is/image/Staples/s1146769_sc7?wid=1000&hei=1000"></p>
            <p><img class="layer1" src="{{ asset('storage/images/layer1.jpg') }}"></p>
            <p><img class="layer2" src="{{ asset('storage/images/layer2.jpg') }}"></p>
            <p><img class="composite" src="{{ asset('storage/images/composite.png') }}"></p>

            <p class="blend_container"></p>
        </div>

    </div>

    <script>

        $(function() {

            $('.layer1').clone().appendTo('.blend_container');
            $('.layer2').clone().appendTo('.blend_container');

            TweenMax.staggerFrom($('img'), 0.5, {opacity:0, y:200, delay:0.2}, 0.2);

            $('.akamai').on('click', function() {

                $('.akamai').off('click');

                $(this).clone().addClass('one').attr('data-rotate', 0).appendTo('.production_box');

                Draggable.create($('.one'));
                TweenMax.set($('.one'), {x:-265, y:-265});

                $('.right').on('click', function() {

                    var curr = $('.one').data('rotate');
                    var rotate = curr + 10;
                    TweenMax.to($('.one'), 0.25, {rotation:rotate});
                    $('.one').data('rotate', rotate);
                })

                $('.right_s').on('click', function() {

                    var curr = $('.one').data('rotate');
                    var rotate = curr + 0.5;
                    TweenMax.to($('.one'), 0.25, {rotation:rotate});
                    $('.one').data('rotate', rotate);
                })

                $('.left').on('click', function() {

                    var curr = $('.one').data('rotate');
                    var rotate = curr - 10;
                    TweenMax.to($('.one'), 0.25, {rotation:rotate});
                    $('.one').data('rotate', rotate);
                })

                $('.left_s').on('click', function() {

                    var curr = $('.one').data('rotate');
                    var rotate = curr - 0.5;
                    TweenMax.to($('.one'), 0.25, {rotation:rotate});
                    $('.one').data('rotate', rotate);
                })

            })

            $('.q').on('click', function() {
                var position = $('.one').position();
                var rotation = $('.one').data('rotate');

                var url = '/image_test/';
                url += rotation +'/';
                url += position.left +'/';
                url += position.top;
                window.location.href = url;
                //alert("rotation: " + rotation + ", left: " + position.left + ", top: " + position.top);
            })

        })

    </script>

    </body>
</html>
