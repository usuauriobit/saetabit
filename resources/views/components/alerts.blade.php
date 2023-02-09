@if (\Session::has('success'))
    @include('components.alert', ['type' => 'success', 'value' => \Session::get('success') ])
@endif
@if (\Session::has('msg'))
    @include('components.alert', ['type' => 'info', 'value' => \Session::get('msg') ])
@endif
@if (\Session::has('warning'))
    @include('components.alert', ['type' => 'warning', 'value' => \Session::get('warning') ])
@endif
@if (\Session::has('danger'))
    @include('components.alert', ['type' => 'danger', 'value' => \Session::get('danger') ])
@endif

@if (session('errors'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Ups!</strong> Se encontraron los siguientes errores:
        <ul>
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
