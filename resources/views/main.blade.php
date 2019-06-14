
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

                <h2>Main Page</h2>

            </div>
        </div>
    </section>

    <section class="container">
        <div class="row">
            <div class="col-12 text-center">

                <h3>Create New Image</h3>

                <p>To create a new Reorder App Icon Image, enter a SKU below.</p>

                <form method="POST" action="{{ route('validate_sku') }}">
                    {{ csrf_field() }}
                    <input type="text" name="sku" size="40" placeholder="Enter SKU"><br>
                    <button class="btn btn-primary btn-sm" type="submit">BEGIN</button>
                </form>

            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <p>Scotch-Brite Pad: 517899</p>
                <p>Tru-Red Gel Pen: 24377032</p>
                <p>Nestlé® Coffee Creamer: 910546</p>
            </div>
        </div>
    </div>


@endsection
