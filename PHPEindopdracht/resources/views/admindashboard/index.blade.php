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
                    <div class="row mb-4">
                        <div class="col-md-2 offset-md-10">
                            <a class="btn btn-primary" href="{{ route('getallpdf')}}">Maak Alle Labels</a>
                        </div>
                    </div>
                    @can("lezen")
                        @unlessrole("pakket inpakker|administratief medewerker|superadmin")
                        <form action="{{ route('pickupPackage') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <div class="flex flex-col align-items-end p-2" style="background: gray;">
                            <p class="h5">Kies een datum voor het ophalen de pakket(ten)</p>
                                <div>
                                    <input type="date" data-date="" data-date-format="DD/MM/YYYY" name="date" class="mb-2">
                                    <input type="time" data-date="" data-date-format="HH:mm" name="time" class="mb-2">
                                </div>
                                <div>
                                    <a class="btn btn-primary">
                                        <input type="submit" value="Pick Up Pakket(ten)">
                                    </a>
                                </div>
                            </div>
                        @endunlessrole
                    @endcan
                    @if(!empty($allpackages))
                        @foreach($allpackages as $ap)
                            <div class="card mb-2">
                                <div class="card-header flex justify-between">
                                    <p class="font-semibold">{{$ap->status}}</p>
                                    @can("lezen")
                                        @unlessrole("pakket inpakker|administratief medewerker|superadmin")
                                            @if($ap->status == "Aangemeld")
                                                <input type="checkbox" name="selectedPackage[]" value="{{ $ap->id }}">
                                            @endif
                                        @endunlessrole
                                    @endcan
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="font-semibold">Verzender</p>
                                            <p>Naam: {{$ap->name}}</p>
                                            <p>Adres: {{$ap->sender_adres}}</p>
                                            <p>Stad: {{$ap->sender_city}}</p>
                                            <p>Postcode: {{$ap->sender_postalcode}}</p>
                                        </div>
                                        <div>
                                            <p class="font-semibold">Ontvanger</p>
                                            <p>Naam: {{$ap->receiver_name}}</p>
                                            <p>Adres: {{$ap->receiver_adres}}</p>
                                            <p>Stad: {{$ap->receiver_city}}</p>
                                            <p>Postcode: {{$ap->receiver_postalcode}}</p>
                                        </div>
                                        <div class="d-flex flex-row align-items-start">
                                            <a class="btn btn-primary mr-2" href="{{ route('getpdf', $ap->id) }}">Download Label</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endforeach
                    @endif
                    @if($allpackages != null)
                    {{ $allpackages->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @hasanyrole('superadmin|administratief medewerker')
    @can('schrijven')
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
                        @foreach($clients as $c)
                            <option value="{{$c->id}}">{{$c->name}} / {{$c->email}}</option>
                        @endforeach
                    </select>
                    @endif

                    <label for="name" class="block uppercase">Webshopnaam</label>
                    @if(!empty($webshops))
                    <select name="webshop" aria-label="webshop" class="form-control">
                        @foreach($webshops as $w)
                            <option value="{{$w->id}}">{{$w->name}}</option>
                        @endforeach
                    </select>
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
                    @foreach ($clients as $u)
                        @if(!empty($u->webshop))
                            <tr>
                                <td>{{$u->name}} / {{$u->email}}</td>
                                <td>{{$u->webshop->name}}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endcan
    @endhasanyrole
</x-app-layout>
