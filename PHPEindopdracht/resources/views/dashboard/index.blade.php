<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{Route('importcsv')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 offset-md-7">
                                <input class="form-control" type="file" id="csvfile" name="csvfile" accept=".csv">
                            </div>
                            <button type="submit" class="btn btn-link link-dark col-md-1">Upload</button>
                        </div>
                    </form>
                    <form action= " {{route('dashboard')}} ">
                        <div class="row mb-2">
                            <div class="col-md-2 offset-md-7">
                                <select class="form-select" aria-label="Default select example" name="Status">
                                    <option value="" selected>-- Status --</option>
                                    @foreach($status as $s)
                                    <option value="{{$s->value}}">{{$s->value}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" aria-label="Default select example" name="Sorting">
                                    <option value="" selected>-- Filter --</option>
                                    @foreach($sorting as $f)
                                    <option value="{{$f->value}}">{{strtolower($f->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-link link-dark" type="submit">Sorteren</button>
                            </div>
                        </div>
                    </form>
                    @foreach($packages as $p)
                        <div class="card mb-2">
                            <div class="card-header font-semibold">
                                {{$p->status}}
                            </div>
                            <div class="card-body flex justify-content-between align-items-center"">
                                <div>
                                    <p class="font-semibold">Verzender</p>
                                    <p>Naam: {{$p->name}}</p>
                                    <p>Adres: {{$p->sender_adres}}</p>
                                    <p>Stad: {{$p->sender_city}}</p>
                                    <p>Postcode: {{$p->sender_postalcode}}</p>
                                </div>
                                <div>
                                    <p class="font-semibold">Ontvanger</p>
                                    <p>Naam: {{$p->receiver_name}}</p>
                                    <p>Adres: {{$p->receiver_adres}}</p>
                                    <p>Stad: {{$p->receiver_city}}</p>
                                    <p>Postcode: {{$p->receiver_postalcode}}</p>
                                </div>
                                <div class="flex justify-center">
                                    <form action="{{ route('packages.destroy', $p->id) }}" method="post">
                                    @csrf
                                    @method('Delete')
                                    <a class="btn btn-primary mr-2">
                                        <input type="submit" value="Verwijderen">
                                    </a>
                                    </form>
                                    <a href="{{ route('editPackage', $p->id) }}" class="btn btn-primary">Aanpassen</a>
                                </div>
                                @if($p->status == "Bezorgd")
                                    <form action="{{route('addreview', $p->id)}}">
                                        <div class="row mt-3">
                                            <div class="col-md-3">
                                                <select class="form-select" name="review" aria-label="review">
                                                    <option selected>Laat een review achter!</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                            <button class="btn button-primary col-md-1" type="submit">Submit</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @if(!is_null($packages))
                        {{ $packages->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center">
            <form action="{{ route('packages.store') }}" method="post">
            @csrf
                <div class="flex flex-row">
                    @if(!empty($client->webshop))
                        <div>
                            <p>Verzender</p>
                            <p>Naam: {{$client->name}}</p>
                            <p>Webshop: {{$client->webshop->name}}</p>
                        </div>
                        @else
                        <div class="flex flex-col">
                            <p class="font-semibold uppercase">Verzender</p>
                            <label for="name">Naam</label>
                            <input type="text" name="name">

                            <label for="sender_adres">Adres</label>
                            <input type="text" name="sender_adres">

                            <label for="sender_city">Stad</label>
                            <input type="text" name="sender_city">

                            <label for="sender_postalcode">Postcode</label>
                            <input type="text" name="sender_postalcode">
                        </div>
                    @endif
                    <div class="flex flex-col ml-4">
                        <p class="font-semibold uppercase">Ontvanger</p>
                        <label for="receiver_name">Naam</label>
                        <input type="text" name="receiver_name">

                        <label for="receiver_adres">Adres</label>
                        <input type="text" name="receiver_adres">

                        <label for="receiver_postalcode">Postcode</label>
                        <input type="text" name="receiver_postalcode">

                        <label for="receiver_city">Stad</label>
                        <input type="text" name="receiver_city">
                    </div>
                </div>
                <div class="flex justify-center">
                    <input type="submit" value="Pakket aanmelden" class="btn btn-dark bg-dark mt-2">
                </div>
            </form>
        </div>
</x-app-layout>
