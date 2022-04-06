<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>{{$name}}</title>
</head> 
<body>
    <div class="container">
        <p class="mt-5">PACKR</p>
        <p class="mt-5">Verzender: {{$sender_adres}}, {{$sender_city}}</p>
        <p>{{$sender_postalcode}}</p>
        <p class="mt-5">Ontvanger: {{$receiver_adres}}, {{$receiver_city}}</p>
        <p>{{$receiver_postalcode}}</p>
        <div class="mt-5">{!! DNS1D::getBarcodeHTML($name, 'PHARMA') !!}</div>
    </div>
</body>
</html>