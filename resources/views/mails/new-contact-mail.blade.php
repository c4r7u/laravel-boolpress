<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Hai un nuovo messaggio</h1>

    <div>Nome: {{ $new_lead->name }}</div>

    <div>Email: {{ $new_lead->email }}</div>

    <p>{{ $new_lead->message }}</p>
</body>
</html>