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
    <div class="row">
        <div class="col-md-1 offset-md-11 mt-2">
            <a href="{{Route('dashboard')}}" class="btn btn-primary">Log in</a>
        </div>
    </div>
    <form action="{{route('getpackage')}}" method="GET">
    <div class="row justify-content-center mt-lg-3">
        <div class="card col-md-6">
        <div class="card-body">
            <h5 class="card-title text-center">Voer uw pakketcode in</h5>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <label for="code">Pakketcode</label>
            <input type="text" class="form-control mt-3 mb-3" id="code" name="code">
            <button type="submit" class="btn btn-primary">Zoek</button>
        </div>
        </div>
    </div>
    </form>
</body>
</html>