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
                    @foreach($allpackages as $a)
                    @if($allpackages != null)
                    {{ $allpackages->links() }}
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @hasanyrole('superadmin|administratief medewerker')
    <!-- @role('pakket inpakker')
    @endrole -->
    @can('schrijven')
    <div class="flex justify-center">
        <form action="{{ route('admindashboard.update', '$clients->id') }}" method="post">
        @csrf
        @method('PUT')
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <h2>Toevoegen klant aan webshop:</h2>

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
                <button type="submit" value="webshop account" class="btn btn-dark bg-dark mt-2">webshop account aanmaken</button>
            </div>
        </form>
    </div>
    @endcan
    @endhasanyrole
</x-app-layout>
