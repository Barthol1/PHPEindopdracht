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
                <form action= " {{route('customers.index')}} ">
                    <div class="row mb-2">
                        <div class="col-md-2 offset-md-7">
                            <select class="form-select" aria-label="Default select example" name="Webshop">
                                <option value="" selected>-- Webshop --</option>
                                @foreach($webshops as $s)
                                <option value="{{$s->id}}">{{$s->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" aria-label="Default select example" name="Sorting">
                                <option value="" selected>-- Filter --</option>
                                @foreach($webshopsorting as $f)
                                <option value="{{$f->value}}">{{strtolower($f->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-link link-dark" type="submit">Sorteren</button>
                        </div>
                    </div>
                </form>
                @foreach($customers as $a)
                    <div class="card mb-2">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <h5 class="card-title col-md-4">naam: {{$a->name}}</h5>
                            </div>
                            <p class="card-text">email: {{$a->email}}</p>
                            @if(!is_null($a->webshop))
                            <p class="card-text">webshop: {{$a->webshop->name}}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
                @if($customers != null)
                    {{ $customers->links() }}
                @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
