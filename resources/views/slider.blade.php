
@extends ('partials.layout-shell')

@section ('title')
    Main Page
@endsection

@section ('content')

    <header class="container">
        <div class="row">
            <div class="col-12 text-center">

                <h1>{{ config('global.site_title') }}</h1>

            </div>
        </div>
    </header>

    <section class="container">
        <div class="row">
            <div class="col-12 text-center">

                <h2>{{ $image_data['total_images'] }} Images Found</h2>

            </div>
        </div>
    </section>

    <section class="container ">
        <div class="row">
            <div class="col-12 text-center">

                <div class="slider_wrapper">
                    @if (isset($image_data['image_numbers']))
                        @foreach ($image_data['image_numbers'] as $image_number)
                            <div>
                                <img data-lazy="https://www.staples-3p.com/s7/is/image/Staples/{{ $image_number }}_sc7?wid=1000&hei=1000" title="{{ $image_number }}">
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    </section>

    <div class="work_canvas">
        <img id="glass_slide" src="{{ asset('images/circle_mask_2.png') }}" width="474" height="474">
    </div>

    <section class="tools_controls">

        <div class="layers_tracker"></div>

        <div class="image_tools">
            <div class="rotate">
                <img class="anti" src="{{ asset('images/anti-clockwise.png') }}">
                <img class="anti inset" src="{{ asset('images/anti-clockwise_sm.png') }}">
            </div>
            <div class="rotate">
                <img class="clock" src="{{ asset('images/clockwise.png') }}">
                <img class="clock inset" src="{{ asset('images/clockwise_sm.png') }}">
            </div>

            <div class="scale">
                <img class="larger" src="{{ asset('images/enlarge.png') }}">
                <img class="larger inset2" src="{{ asset('images/enlarge.png') }}">
            </div>

            <div class="scale">
                <img class="smaller" src="{{ asset('images/reduce.png') }}">
                <img class="smaller inset2" src="{{ asset('images/reduce.png') }}">
            </div>

        </div>

        <form class="image_details" method="post" action="{{ route('process_images') }}">
            {{ csrf_field() }}
            <input type="text" size="40" class="button_text" name="button_text" placeholder="Enter Button Text Here"><br>
            <input type="hidden" class="url_0" name="url_0" value="">
                <input type="hidden" class="rotation_0" name="rotation_0" value="">
                <input type="hidden" class="scale_0" name="scale_0" value="">
                <input type="hidden" class="offsetx_0" name="offsetx_0" value="">
                <input type="hidden" class="offsety_0" name="offsety_0" value="">
            <input type="hidden" class="url_1" name="url_1" value="">
                <input type="hidden" class="rotation_1" name="rotation_1" value="">
                <input type="hidden" class="scale_1" name="scale_1" value="">
                <input type="hidden" class="offsetx_1" name="offsetx_1" value="">
                <input type="hidden" class="offsety_1" name="offsety_1" value="">
            <input type="hidden" class="url_2" name="url_2" value="">
                <input type="hidden" class="rotation_2" name="rotation_2" value="">
                <input type="hidden" class="scale_2" name="scale_2" value="">
                <input type="hidden" class="offsetx_2" name="offsetx_2" value="">
                <input type="hidden" class="offsety_2" name="offsety_2" value="">
            <button class="btn btn-primary btn-sm" type="submit">CREATE</button>
        </form>

    </section>

@endsection
