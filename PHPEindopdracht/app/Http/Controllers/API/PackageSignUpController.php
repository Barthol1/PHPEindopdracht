<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Resources\ProgramResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PackageSignUpController extends Controller
{
    // public function index()
    // {
    //     $data = Package::latest()->get();
    //     // return response()->json([ProgramResource::collection($data), 'Programs fetched.']);
    // }
    // function __invoke() {
    //     return 'Testing';
    // }

    public function index()
    {
        return Package::where('users_id', request()->user()->id)->get();
    }

    public function get($productnr)
    {
        return Package::where('name', 'like', '%' . $productnr . '%')->where('users_id', request()->user()->id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'sender_adres'=>'required',
            'sender_city'=>'required',
            'sender_postalcode'=>'required',
            'receiver_name' => 'required',
            'receiver_adres' => 'required',
            'receiver_postalcode' => 'required',
            'receiver_city' => 'required',
        ]);

        $request['status'] = "Aangemeld";
        $request['users_id'] = request()->user()->id;

        return Package::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $package = Package::find($id);
        return $package->update($request->all());
    }

    public function destroy($id)
    {
        return Package::destroy($id);
    }
}
