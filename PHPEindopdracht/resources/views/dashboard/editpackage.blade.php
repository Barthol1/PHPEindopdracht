<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('AdminDashboard') }}
        </h2>
    </x-slot>
<form action="{{ route('updatePackage', $package->id) }}" method="post" class="d-inline-flex flex-col align-items-center m-4">
    @csrf
    @method("PUT")
    <div class="flex">
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
                    <input type="text" name="sender_name" value="{{ $package->sender_name }}">
                    @error('sender_name')
                        <div class="alert alert-danger"> {{ $message }} </div>
                    @enderror

                    <label for="sender_adres">Adres</label>
                    <input type="text" name="sender_adres" value="{{ $package->sender_adres }}">
                    @error('sender_adres')
                        <div class="alert alert-danger"> {{ $message }} </div>
                    @enderror

                    <label for="sender_postalcode">Postcode</label>
                    <input type="text" name="sender_postalcode" value="{{ $package->sender_postalcode }}">
                    @error('sender_postalcode')
                        <div class="alert alert-danger"> {{ $message }} </div>
                    @enderror

                    <label for="sender_city">Stad</label>
                    <input type="text" name="sender_city" value="{{ $package->sender_city }}">
                    @error('sender_city')
                        <div class="alert alert-danger"> {{ $message }} </div>
                    @enderror
                </div>
            @endif
        </div>
        <div class="flex flex-col ml-4">
            <p class="uppercase font-semibold">Ontvanger</p>
            <label for="receiver_name">Naam</label>
            <input type="text" name="receiver_name" value="{{ $package->receiver_name }}">
            @error('receiver_name')
                <div class="alert alert-danger"> {{ $message }} </div>
            @enderror

            <label for="receiver_adres">Adres</label>
            <input type="text" name="receiver_adres" value="{{ $package->receiver_adres }}">
            @error('receiver_adres')
                <div class="alert alert-danger"> {{ $message }} </div>
            @enderror

            <label for="receiver_postalcode">Postcode</label>
            <input type="text" name="receiver_postalcode" value="{{ $package->receiver_postalcode }}">
            @error('receiver_postalcode')
                <div class="alert alert-danger"> {{ $message }} </div>
            @enderror

            <label for="receiver_city">Stad</label>
            <input type="text" name="receiver_city" value="{{ $package->receiver_city }}">
            @error('receiver_city')
                <div class="alert alert-danger"> {{ $message }} </div>
            @enderror
        </div>
    </div>
    <div class="mt-2">
        <input type="submit" class="btn btn-dark bg-dark" value="Wijzigen">
    </div>
</form>
</x-app-layout>
