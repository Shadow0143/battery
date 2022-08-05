@if(\Illuminate\Support\Facades\Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{\Illuminate\Support\Facades\Session::get('success')}}
    </div>
@endif
@if(\Illuminate\Support\Facades\Session::has('error'))
    <div class="alert alert-danger" role="alert">
        {{\Illuminate\Support\Facades\Session::get('error')}}
    </div>
@elseif(isset($error))
    <div class="alert alert-danger" role="alert">
        {{$error}}
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
