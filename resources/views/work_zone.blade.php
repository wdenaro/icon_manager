
@extends ('partials.layout-shell')

@section ('title')
    Work Zone ({{ $image_info['sku_data']->hash_id }})
@endsection

@section ('content')

    <div class="work_zone">


        <div class="header">
            <a href="{{ route('splash') }}"><img class="home" src="{{ asset('images/icon-home.png') }}"></a>
            Reorder App Icon Manager
        </div>


        <div class="details">
            <fieldset>
                <label for="sku">SKU:</label><br>
                <input class="sku" type="text" value="{{ $image_info['sku_data']->sku }}" disabled>
            </fieldset>
            <fieldset>
                <label for="description1">Text Line 1:</label><br>

                @isset ($image_info['telemetry'])
                    <input class="description line1" name="description1" type="text" autocomplete="off" value="{{ $image_info['line_1'] }}" disabled="disabled">
                @else
                    <input class="description line1" name="description1" type="text" autocomplete="off" value="{{ $image_info['sku_data']->description }}" disabled="disabled">
                @endisset

            </fieldset>
            <fieldset>
                <label for="description2">Text Line 2:</label><br>

                @isset ($image_info['telemetry'])
                    <input class="description line2" name="description2" type="text" autocomplete="off" value="{{ $image_info['line_2'] }}" disabled="disabled">
                @else
                    <input class="description line2" name="description2" type="text" autocomplete="off" value="" disabled="disabled">
                @endisset

            </fieldset>
        </div>


        <div class="toggle">
            <img src="{{ asset('images/icon_text.png') }}">
            <label class="switch">
                <input class="active" type="checkbox" checked>
                <span class="slider round"></span>
            </label>
            <img src="{{ asset('images/icon_picture.png') }}">
        </div>


        <div class="blockers">
            <img class="canvas_block" src="{{ asset('images/trans.gif') }}">
            <img class="slider_block" src="{{ asset('images/trans.gif') }}">
        </div>


        <div class="slider_wrapper">
            @if (isset($image_info['image_numbers']))
                <p><b>{{ $image_info['total_images'] }}</b> Image(s) Available</p>
            <div class="slider">
                @foreach ($image_info['image_numbers'] as $image_number)
                    <div>
                        <img data-lazy="https://www.staples-3p.com/s7/is/image/Staples/{{ $image_number }}_sc7?wid=1000&hei=1000" title="{{ $image_number }}">
                    </div>
                @endforeach
            @endif
            </div>
        </div>


        @isset ($related_images)
        <div class="related">
            <p>Recently Created</p>
            <div>

                @foreach ($related_images as $image)
                <div class="button">
                    <img src="{{ asset('storage/images/' .$image['sku']. '_' .$image['hash_id']. '.png') }}">
                    <img src="{{ asset('images/dome-mask.png') }}" title="SKU: {{ $image['sku'] }} - BATCH: {{ $image['batch_id'] }}">
                    <span class="line1">{{ $image['line1'] }}</span>
                    <span class="line2">{{ $image['line2'] }}</span>
                </div>
                @endforeach

            </div>
        </div>
        @endisset


        <div class="layers_tracker"></div>


        <div class="image_tools">
            <div class="rotate">
                <img class="anti" src="{{ asset('images/anti-clockwise.png') }}">
                <img class="anti inset" src="{{ asset('images/anti-clockwise.png') }}">
            </div>
            <div class="rotate">
                <img class="clock" src="{{ asset('images/clockwise.png') }}">
                <img class="clock inset" src="{{ asset('images/clockwise.png') }}">
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


        <div class="work_canvas">
            <img id="glass_slide" src="{{ asset('images/circle_mask_2.png') }}" width="474" height="474">
        </div>


        <div class="text_overlay_wrapper">
            <img id="dome_mask" src="{{ asset('images/dome-mask.png') }}" width="474" height="474">
            <p class="overlay1">Lorem Ipsum.</p>
            <p class="overlay2">Sed ut Perspiciatis.</p>
        </div>


        <form class="telemetry" method="post" action="{{ route('save_and_create') }}">
            {{ csrf_field() }}
            <input type="hidden" class="hash_id" name="hash_id" value="{{ $image_info['sku_data']->hash_id }}">
            <input type="hidden" class="line1_text" name="line1_text" value="">
            <input type="hidden" class="line2_text" name="line2_text" value="">
            <input type="hidden" class="url_0" name="url_0" value="">
            <input type="hidden" class="rotation_0" name="rotation_0" value="">
            <input type="hidden" class="scale_0" name="scale_0" value="">
            <input type="hidden" class="x_offset_js_0" name="x_offset_js_0" value="">
            <input type="hidden" class="y_offset_js_0" name="y_offset_js_0" value="">
            <input type="hidden" class="x_offset_gsap_0" name="x_offset_gsap_0" value="">
            <input type="hidden" class="y_offset_gsap_0" name="y_offset_gsap_0" value="">
            <input type="hidden" class="url_1" name="url_1" value="">
            <input type="hidden" class="rotation_1" name="rotation_1" value="">
            <input type="hidden" class="scale_1" name="scale_1" value="">
            <input type="hidden" class="x_offset_js_1" name="x_offset_js_1" value="">
            <input type="hidden" class="y_offset_js_1" name="y_offset_js_1" value="">
            <input type="hidden" class="x_offset_gsap_1" name="x_offset_gsap_1" value="">
            <input type="hidden" class="y_offset_gsap_1" name="y_offset_gsap_1" value="">
            <input type="hidden" class="url_2" name="url_2" value="">
            <input type="hidden" class="rotation_2" name="rotation_2" value="">
            <input type="hidden" class="scale_2" name="scale_2" value="">
            <input type="hidden" class="x_offset_js_2" name="x_offset_js_2" value="">
            <input type="hidden" class="y_offset_js_2" name="y_offset_js_2" value="">
            <input type="hidden" class="x_offset_gsap_2" name="x_offset_gsap_2" value="">
            <input type="hidden" class="y_offset_gsap_2" name="y_offset_gsap_2" value="">
            <button id="save_button" class="btn btn-primary btn-sm" type="submit">SAVE</button>
        </form>


    </div>


    @isset ($image_info['telemetry'])
        <div id="telemetry">{{ $image_info['telemetry'] }}</div>
    @endisset


@endsection
