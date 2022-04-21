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
                    <div class="row mb-2">
                        <div class="col-md-2">
                            <a class="btn btn-primary" href="{{ route('getallpdf')}}">Maak Alle Labels</a>
                        </div>
                        <div class="col-md-2 offset-md-5">
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
                    @foreach($allpackages as $a)
                    <div class="card mb-2">
                        <div class="card-header">
                            {{$a->status}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <h5 class="card-title col-md-2">naam: {{$a->name}}</h5>
                                @can('schrijven')
                                <a class="btn btn-primary offset-md-8 col-md-2" href="{{ route('getpdf', $a->id) }}">Download Label</a>
                                @endcan
                            </div>
                            <p class="card-text">zendadres: {{$a->sender_adres}}</p>
                            @can('schrijven')
                            <form action="{{ route('package.destroy', $a->id) }}" method="post" class="flex justify-center">
                            @csrf
                            @method('Delete')
                                <button type="submit" class="block">Verwijderen<button>
                            </form>
                            <a href="" class="block">Aanpassen</a>
                            @endcan
                        </div>
                    </div>
                    @endforeach
                    @if($allpackages != null)
                    {{ $allpackages->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    @hasanyrole('superadmin|administratief medewerker')
    <!-- @role('pakket inpakker')
    @endrole -->
    @can('schrijven')
    <div class="flex justify-center">
        <div>
            <form action="{{ route('package.store') }}" method="post">
            @csrf
                <div class="flex flex-row">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <h2>Verzender:</h2>
                            <label for="name" class="block uppercase">naam</label>
                            <input type="text" name="name"/>

                            <label for="sender_adres" class="block uppercase">adres</label>
                            <input type="text" name="sender_adres"/>

                            <label for="sender_city" class="block uppercase">stad</label>
                            <input type="text" name="sender_city"/>

                            <label for="sender_postalcode" class="block uppercase">postcode</label>
                            <input type="text" name="sender_postalcode"/>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <h2>Ontvanger:</h2>
                            <label for="receiver_adres" class="block uppercase">adres</label>
                            <input type="text" name="receiver_adres"/>

                            <label for="receiver_postalcode" class="block uppercase">postcode</label>
                            <input type="text" name="receiver_postalcode"/>

                            <label for="receiver_city" class="block uppercase">stad</label>
                            <input type="text" name="receiver_city"/>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center">
                    <button type="submit" value="pakket aanmelden" class="btn btn-dark bg-dark mt-2">Pakket aanmelden</button>
                </div>
            </form>
        </div>
        <div>
        <form action="{{ route('store') }}" method="post">
        @csrf
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <h2>webshop account:</h2>
                    <label for="name" class="block uppercase">naam</label>
                    <input type="text" name="name"/>

                    <label for="email" class="block uppercase">email</label>
                    <input type="text" name="email"/>

                    <label for="password" class="block uppercase">wachtwoord</label>
                    <input type="text" name="password"/>
                </div>
            </div>
            <div class="flex justify-center">
                <button type="submit" value="webshop account" class="btn btn-dark bg-dark mt-2">webshop account aanmaken</button>
            </div>
        </form>
        </div>
    </div>
    @endcan
    @endhasanyrole
</x-app-layout>
