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
                        <div class="row mb-2">
                            <div class="col-md-2 offset-md-7">
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
                    @if($allpackages != null)
                    {{ $allpackages->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
