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
                    @foreach($packages as $a)
                    <div class="card mb-2">
                        <div class="card-header">
                            {{$a->status}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <h5 class="card-title col-md-2">naam: {{$a->name}}</h5>
                            </div>
                            <p class="card-text">zendadres: {{$a->sender_adres}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center">
            <form action="{{ route('packages.store') }}" method="post">
            @csrf
                <div class="flex flex-row">
                    @if(!empty($webshops_id))
                        <h1>gewone gebruiker</h1>
                            <select>
                                <option>

                                </option>
                            </select>
                        @else
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
                                <label for="receiver_name" class="block uppercase">naam</label>
                                <input type="text" name="receiver_name"/>

                                <label for="receiver_adres" class="block uppercase">adres</label>
                                <input type="text" name="receiver_adres"/>

                                <label for="receiver_postalcode" class="block uppercase">postcode</label>
                                <input type="text" name="receiver_postalcode"/>

                                <label for="receiver_city" class="block uppercase">stad</label>
                                <input type="text" name="receiver_city"/>
                            </div>
                        </div>
                        @endif
                </div>
                <div class="flex justify-center">
                    <button type="submit" value="pakket aanmelden" class="btn btn-dark bg-dark mt-2">Pakket aanmelden</button>
                </div>
            </form>
        </div>
</x-app-layout>
