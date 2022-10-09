<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notícias</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>Título</th>
                <th>Notícia</th>
            </tr>
        </thead>        
        <tbody>
            @foreach($noticias as $noticia)            
                <tr>
                    <td>{{ $noticia->titulo }}</td>
                    <td>{{ $noticia->noticia }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>