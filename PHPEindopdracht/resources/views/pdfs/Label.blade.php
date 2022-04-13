<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head> 
<body>
    @foreach($package as $a)
    <div class="container">
        <p class="mt-5">PACKR</p>
        <p class="mt-5">Verzender: {{$a->sender_adres}}, {{$a->sender_city}}</p>
        <p>{{$a->sender_postalcode}}</p>
        <p class="mt-5">Ontvanger: {{$a->receiver_adres}}, {{$a->receiver_city}}</p>
        <p>{{$a->receiver_postalcode}}</p>
        <div class="mt-5">{!! DNS1D::getBarcodeHTML($a->name, 'PHARMA') !!}</div>
    </div>
    <div class="page-break"></div>
    @endforeach
</body>
</html>