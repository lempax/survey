@extends('form.app')

@section('content')

    <h1>New Form</h1>
    
    <hr>
    
    <form method="POST" action="{{ url('form')}}">
        {{ csrf_field() }}
        <div class="form-group">
            <label>Type</label>
            <input type="text" name="type">
        </div>
        
        <div class="form-group">
            <label>Agent ID :</label>
            <input type="text" name="agent_id">
            <label>Creator ID :</label>
            <input type="text" name="creator">
        </div>
        
        <div class="form-group">
            <label>CONTENT</label>
            <input type="text" name="content">
        </div>
        
        <div class="form-group">
            <input type="submit" name="submit" value="Submit">
        </div>
    </form>
    
    @if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
         </ul>
    @endif
    
@endsection