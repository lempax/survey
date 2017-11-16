@extends('form.app')

@section('content')

    @foreach ($shits as $shit)
        <div class="form-group">
             {{ $shit }}
            
            
            @foreach($shit as $shi)
              {{ $shi }}
              @endforeach
        </div>
    @endforeach
@stop
