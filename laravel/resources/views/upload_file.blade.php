<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>

<body>
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
        <p>Uploaded File Path: {{ session('file') }}</p>
    @endif

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <h1>Hello</h1>
    <form action="/upload" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="document" id="file">
        <button type="submit">Upload</button>
    </form>
</body>

</html>