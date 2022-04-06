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
                    @foreach($allpackages as $a)
                    <div class="card mb-2">
                        <div class="card-header">
                            {{$a->status}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <h5 class="card-title col-md-2">naam: {{$a->name}}</h5>
                                @if($a->status != 'Aangemeld' && $a->status != 'Afgewezen')
                                <a class="btn btn-primary offset-md-8 col-md-2" href="{{ route('getpdf', $a->id) }}">Download Label</a>
                                @elseif($a->status == 'Afgewezen')
                                <p class="offset-md-8 col-md-2">Het pakket is afgewezen.</p>
                                @else
                                <p class="offset-md-8 col-md-2">Label word zo spoedig mogelijk gemaakt.</p>
                                @endif
                            </div>
                            <p class="card-text">zendadres: {{$a->sender_adres}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
