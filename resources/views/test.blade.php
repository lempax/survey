<html>
    <head>

    </head>
    <body>
        <h1>
            Page one.           
        </h1>
        {!! $content !!} <br/>
        {{ $name }}

        <ul>
            @foreach($data as $dd)

            <li>{{ $dd }}</li>

            @endforeach
        </ul>
    </body>
</html>