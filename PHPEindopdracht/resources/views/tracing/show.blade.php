<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="row justify-content-center mt-lg-5">
        <div class="card col-md-6">
            <div class="card-body">
                <h5 class="card-title text-center">{{$package->name}}</h5>
                <p class="card-text font-bold">Status: {{$package->status}}</p>
                <p class="card-text mt-3">Verzender: {{$package->sender_adres}}, {{$package->sender_city}}</p>
                <p class="card-text">{{$package->sender_postalcode}}</p>
                <p class="card-text mt-3">Ontvanger: {{$package->receiver_adres}}, {{$package->receiver_city}}</p>
                <p class="card-text">{{$package->receiver_postalcode}}</p>
            </div>
            <a href="{{Route('index')}}" class="btn btn-link col">Terug</a>
        </div>
    </div>
</body>
</html>