<h1>CurrencyFiles</h1>
<form action="{{ route('deletecurrencyLog')}}" method="POST">
    @csrf
    @method('POST')
    <button type="submit" class="delete-btn">Delete</button>
</form>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>File Name</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($currency as $currency)
            <tr>
                <td>{{ $currency->id }}</td>
                <td>{{ $currency->file_path }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
