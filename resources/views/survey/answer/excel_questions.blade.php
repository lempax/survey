<table>
    <tr>
        <th>Question Number</th>
        <th>Question Title</th>
    </tr>
    
    @foreach($headers AS $header)
    <tr>
        <td>{{ $header['id'] }}</td>
        <td>{{ $header['title'] }}</td>
    </tr>
    @endforeach
</table>