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
                    @foreach($allpackages as $a)
                    <div class="card mb-2">
                        <div class="card-header">
                            {{$a->status}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <h5 class="card-title col-md-2">naam: {{$a->name}}</h5>
                            </div>
                            <p class="card-text">zendadres: {{$a->sender_adres}}</p>
                            @if($a->status == "Bezorgd")
                            <form action="{{route('addreview', $a->id)}}">
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
