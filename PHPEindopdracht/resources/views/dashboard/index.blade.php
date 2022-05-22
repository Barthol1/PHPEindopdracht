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
                        @csrf
                        <div class="row mb-2">
                            <div class="col-md-2 offset-md-7">
                                <select class="form-select" aria-label="Default select example" name="Status">
                                    <option value="" selected>-- Status --</option>
                                    @if(!empty($status))
                                        @foreach($status as $s)
                                            <option value="{{$s->value}}">{{$s->value}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" aria-label="Default select example" name="Sorting">
                                    <option value="" selected>-- Filter --</option>
                                    @if(!empty($sorting))
                                        @foreach($sorting as $f)
                                            <option value="{{$f->value}}">{{strtolower($f->name)}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-link link-dark" type="submit">Sorteren</button>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('dashboardSearch') }}" method="GET" class="mb-5">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="search" value="{{ request()->get('search') }}" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="button-addon2">
                            <a class="btn btn-primary">
                                <button type="submit" id="button-addon2">Zoeken</button>
                            </a>
                        </div>
                    </form>
                    @foreach($packages as $p)
                        <div class="card mb-2">
                            <div class="card-header font-semibold flex justify-between">
                                <p>{{$p->name}}</p>
                                <p>{{$p->status}}</p>
                            </div>

                            <div class="card-body flex justify-content-between align-items-center"">
                                <div>
                                    <p class="font-semibold">Verzender</p>
                                    <p>Naam: {{$p->sender_name}}</p>
                                    <p>Adres: {{$p->sender_adres}}</p>
                                    <p>Postcode: {{$p->sender_postalcode}}</p>
                                    <p>Stad: {{$p->sender_city}}</p>
                                </div>
                                <div>
                                    <p class="font-semibold">Ontvanger</p>
                                    <p>Naam: {{$p->receiver_name}}</p>
                                    <p>Adres: {{$p->receiver_adres}}</p>
                                    <p>Postcode: {{$p->receiver_postalcode}}</p>
                                    <p>Stad: {{$p->receiver_city}}</p>
                                </div>
                                @if($p->status == "Aangemeld")
                                <div class="flex justify-center">
                                    <form action="{{ route('destroyPackage', $p->id) }}" method="post">
                                    @csrf
                                    @method('Delete')
                                    <a class="btn btn-primary mr-2">
                                        <input type="submit" value="Verwijderen">
                                    </a>
                                    </form>
                                    <a href="{{ route('editPackage', $p->id) }}" class="btn btn-primary">Aanpassen</a>
                                </div>
                                @endif
                                @if($p->status == "Afgeleverd")
                                    <form action="{{route('addreview', $p->id)}}">
                                        @csrf
                                        <div class="flex">
                                            <div>
                                                <select class="form-select" name="review" aria-label="review">
                                                    <option selected>Laat een review achter!</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                            <button class="btn button-primary" type="submit">Submit</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @if(!empty($packages))
                        {{ $packages->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @unlessrole('pakket inpakker')
    @if($user->can('schrijven') || is_null($user->transporters_id))
    <div class="flex justify-center">
            <form action="{{ route('storePackage') }}" method="post">
            @csrf
                <div class="flex flex-row">
                    <div class="flex flex-col">
                        <p class="font-semibold uppercase">Verzender</p>
                        @if(!empty($client->webshop))
                            <div>
                                <p>Naam: {{$client->name}}</p>
                                <p>Webshop: {{$client->webshop->name}}</p>
                                <p>Adres: {{$client->webshop->adres}}</p>
                                <p>Postcode: {{$client->webshop->postalcode}}</p>
                                <p>Stad: {{$client->webshop->place}}</p>
                            </div>
                            @else
                            <div class="flex flex-col">
                                <label for="sender_name">Naam</label>
                                <input type="text" name="sender_name" value="{{old('sender_name')}}">
                                @error('sender_name')
                                    <div class="alert alert-danger"> {{ $message }} </div>
                                @enderror

                                <label for="sender_adres">Adres</label>
                                <input type="text" name="sender_adres" value="{{old('sender_adres')}}">
                                @error('sender_adres')
                                    <div class="alert alert-danger"> {{ $message }} </div>
                                @enderror

                                <label for="sender_postalcode">Postcode</label>
                                <input type="text" name="sender_postalcode" value="{{old('sender_postalcode')}}">
                                @error('sender_postalcode')
                                    <div class="alert alert-danger"> {{ $message }} </div>
                                @enderror

                                <label for="sender_city">Stad</label>
                                <input type="text" name="sender_city" value="{{old('sender_city')}}">
                                @error('sender_city')
                                    <div class="alert alert-danger"> {{ $message }} </div>
                                @enderror
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col ml-4">
                        <p class="font-semibold uppercase">Ontvanger</p>
                        <label for="receiver_name">Naam</label>
                        <input type="text" name="receiver_name" value="{{old('receiver_name')}}">
                        @error('receiver_name')
                            <div class="alert alert-danger"> {{ $message }} </div>
                        @enderror

                        <label for="receiver_adres">Adres</label>
                        <input type="text" name="receiver_adres" value="{{old('receiver_adres')}}">
                        @error('receiver_adres')
                            <div class="alert alert-danger"> {{ $message }} </div>
                        @enderror

                        <label for="receiver_postalcode">Postcode</label>
                        <input type="text" name="receiver_postalcode" value="{{old('receiver_postalcode')}}">
                        @error('receiver_postalcode')
                            <div class="alert alert-danger"> {{ $message }} </div>
                        @enderror

                        <label for="receiver_city">Stad</label>
                        <input type="text" name="receiver_city" value="{{old('receiver_city')}}">
                        @error('receiver_city')
                            <div class="alert alert-danger"> {{ $message }} </div>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-center">
                    <input type="submit" value="Pakket aanmelden" class="btn btn-dark bg-dark mt-2">
                </div>
            </form>
        </div>
        @endif
        @endunlessrole
</x-app-layout>
