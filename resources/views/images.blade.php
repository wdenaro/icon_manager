
@extends ('partials.layout-shell')

@section ('title')
    Main Page
@endsection

@section ('content')

    <header class="container">
        <div class="row">
            <div class="col-12 text-center">

                <h1>Images Created</h1>
                <br>

            </div>
        </div>
    </header>

    <section class="container">
        <div class="row">
            <div class="col-12 text-center">

                <h2>Individual Layer(s)</h2>
                <a href="{{ asset('storage/images/layer1.jpg') }}" target="_blank"><img src="{{ asset('storage/images/layer1.jpg') }}" width="120" height="120"></a>
                @if(file_exists('storage/images/layer2.jpg'))
                    <a href="{{ asset('storage/images/layer2.jpg') }}" target="_blank"><img src="{{ asset('storage/images/layer2.jpg') }}" width="120" height="120"></a>
                @endif
                @if(file_exists('storage/images/layer3.jpg'))
                    <a href="{{ asset('storage/images/layer3.jpg') }}" target="_blank"><img src="{{ asset('storage/images/layer3.jpg') }}" width="120" height="120"></a>
                @endif

            </div>
        </div>
    </section>

    <section class="container composites comps" style="overflow:hidden;">
        <div class="row">
            <div class="col-12 text-center">

                <h2>Composite Image(s)</h2>
                @if(file_exists('storage/images/composite.png'))
                    <a href="{{ asset('storage/images/composite.png') }}" target="_blank"><img src="{{ asset('storage/images/composite.png') }}" width="300" height="300"></a>
                @endif
                <a href="{{ asset('storage/images/composite_with_dome.png') }}" target="_blank"><img src="{{ asset('storage/images/composite_with_dome.png') }}" width="300" height="300"></a>

            </div>
        </div>
    </section>

    <section class="container composites mask" style="overflow:hidden;">
        <div class="row">
            <div class="col-12 text-center">

                <h2>Composite Image w/HTML Text and CSS Mask</h2>
                <div class="css_comp">
                    <img src="{{ asset('storage/images/composite_with_dome.png') }}" width="474" height="474" style="border-radius: 237px;">
                    <p>{{ $text }}</p>
                </div>

            </div>
        </div>
    </section>

    <script>

        TweenMax.set($('.composites'), {height:48});

        $('.composites.comps').on('click', function() {
            TweenMax.to($('.composites.comps'), 0.5, {height:350});
        })

        $('.composites.mask').on('click', function() {
            TweenMax.to($('.composites.mask'), 0.5, {height:700});
        })

    </script>


@endsection
