<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('AdminDashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action= " {{route('admindashboard.index')}} ">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-md-2">
                                <a class="btn btn-primary" href="{{ route('getallpdf')}}">Maak Alle Labels</a>
                            </div>
                            <div class="col-md-2 offset-md-5">
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
                    <form action="{{ route('adminSearch') }}" method="GET" class="mb-5">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="search" value="{{ request()->get('search') }}" class="form-control" placeholder="Zoeken..." aria-label="Search" aria-describedby="button-addon2">
                            <a class="btn btn-primary">
                                <button type="submit" id="button-addon2">Zoeken</button>
                            </a>
                        </div>
                    </form>
                    @can("lezen")
                        @unlessrole("pakket inpakker|administratief medewerker|superadmin")
                        <form action="{{ route('pickupPackage') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <div class="flex flex-col align-items-end p-2" style="background: gray;">
                            <p class="h5">Kies een datum voor het ophalen de pakket(ten)</p>
                                <div>
                                    <input type="date" data-date="" data-date-format="DD/MM/YYYY" name="date" class="mb-2" value="{{old('date')}}">
                                    @error('date')
                                        <div class="alert alert-danger"> {{ $message }} </div>
                                    @enderror
                                    <input type="time" data-date="" data-date-format="HH:mm" name="time" class="mb-2" value="{{old('time')}}">
                                    @error('time')
                                        <div class="alert alert-danger"> {{ $message }} </div>
                                    @enderror
                                    @error('selectedPackage')
                                        <div class="alert alert-danger"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <div>
                                    <a class="btn btn-primary">
                                        <input type="submit" value="Pick Up Pakket(ten)">
                                    </a>
                                </div>
                            </div>
                        @endunlessrole
                    @endcan
                    @if(!empty($packages))
                        @foreach($packages as $p)
                            <div class="card mb-2">
                                <div class="card-header flex justify-between">
                                <p>{{$p->name}}</p>
                                <p class="font-semibold">{{$p->status}}</p>
                                    @can("lezen")
                                        @unlessrole("pakket inpakker|administratief medewerker|superadmin")
                                            @if($p->status == "Uitgeprint")
                                                <input type="checkbox" name="selectedPackage[]" value="{{ $p->id }}" {{ (is_array(old('selectedPackage')) && in_array($p->id, old('selectedPackage'))) ? ' checked' : '' }}>
                                            @endif
                                        @endunlessrole
                                    @endcan
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
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
                                            <div class="d-flex flex-row align-items-start">
                                                <a class="btn btn-primary mr-2" href="{{ route('getpdf', $p->id) }}">Download Label</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </form>
                    @endif
                    @if(!empty($packages))
                        {{ $packages->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @hasanyrole('superadmin|administratief medewerker')
    @can('schrijven')
    @if($clients->count() > 0)
    <div class="flex justify-center">
        <form action="{{ route('updateWebshopClient') }}" method="post">
        @csrf
        @method('PUT')
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <p>Toevoegen klant aan webshop:</p>

                    <label for="name" class="block uppercase">Klantnaam</label>
                    @if(!empty($clients))
                        <select name="client" aria-label="client" class="form-control">
                            <option value="0">-- selecteer klant --</option>
                            @foreach($clients as $c)
                                <option value="{{$c->id}}" {{ (old('client') == $c->id ? 'selected': '') }}>{{$c->name}} / {{$c->email}}</option>
                            @endforeach
                        </select>
                        @error('client')
                            <div class="alert alert-danger"> {{ $message }} </div>
                        @enderror
                    @endif

                    <label for="name" class="block uppercase">Webshopnaam</label>
                    @if(!empty($webshops))
                        <select name="webshop" aria-label="webshop" class="form-control">
                            <option value="0">-- selecteer webshop --</option>
                            @foreach($webshops as $w)
                                <option value="{{$w->id}}" {{ (old('webshop') == $w->id ? 'selected': '') }}>{{$w->name}}</option>
                            @endforeach
                        </select>
                        @error('webshop')
                            <div class="alert alert-danger"> {{ $message }} </div>
                        @enderror
                    @endif
                </div>
            </div>
            <div class="flex justify-center">
                <button type="submit" class="btn btn-dark bg-dark mt-2">webshop account aanmaken / wijzigen</button>
            </div>
        </form>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Klantnaam</th>
                        <th>Webshop</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($clients))
                        @foreach ($clients as $u)
                            @if(!empty($u->webshop))
                                <tr>
                                    <td>{{$u->name}} / {{$u->email}}</td>
                                    <td>{{$u->webshop->name}}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @endif
    @endcan
    @endhasanyrole
</x-app-layout>
