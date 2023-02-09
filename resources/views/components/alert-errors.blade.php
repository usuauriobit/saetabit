@if ($errors->any())
    <div class="mb-2 alert alert-warning">
        <ul class="menu">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
