<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Un nuovo post è stato creato</h2>

    <div>Titolo del nuovo post: {{ $new_post->title }}</div>

    <div>Per vedere il nuovo post <a href="{{ route('admin.posts.show', ['post' => $new_post->id]) }}">clicca qui</a></div>
</body>
</html>