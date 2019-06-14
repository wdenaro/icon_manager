
@extends ('partials.layout-shell')

@section ('title')
    Splash Page
@endsection

@section ('content')

    <div class="splash">


        <div class="sample_wrapper">
            <div class="reveal">
                <img src="{{ asset('images/sample.png') }}">
                <img src="{{ asset('images/dome-mask.png') }}">
                <span>Sample Text, For Placement Only</span>
            </div>

            <img class="composite" src="{{ asset('images/sample.png') }}">
            <p>Composite Image<br><i>( 474 x 474px )</i></p>

            <p class="hover">HOVER<br>OVER ME</p>
        </div>


        <div class="inputs">
            <form class="splash_form" method="post" action="{{ route('manual_sku') }}">
                {{ csrf_field() }}
                <input class="sku" name="sku" type="text" placeholder="Enter a SKU" autocomplete="off"><br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            @if ($total !== "0")
                <p>-OR-</p>

                <a href="{{ route('next_available') }}"><button class="btn btn-primary">Work On Next Avaialble</button></a>
            @endif

        </div>

        <p class="count">There are <b>{{ $total }}</b> images in the queue.</p>

    </div>



@endsection
