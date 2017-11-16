@extends('form.app')

@section('content')
<h1> Coaching Forms </h1>

    <hr>
    @foreach($coachingForms as $coaching)
    <article>
        <h2>
            <a href="form/{{ $coaching->id }}">{{ $coaching->content }}</a>
        </h2>
        
        <div class="body">{{ $coaching->status }}</div>
    </article>
    @endforeach
@stop