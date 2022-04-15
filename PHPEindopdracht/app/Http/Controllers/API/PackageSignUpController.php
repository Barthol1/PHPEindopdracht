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
        return Package::all();
    }

    public function get($user)
    {
        return Package::where('users_id', $user)->get();
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
        $request['users_id'] = 11;
        $request['api_token'] = auth()->guard('api')->user();

        Package::create($request->all());
        return redirect('/admindashboard');
    }

    public function update(Request $request, $id)
    {
        $package = Package::find($id);
        $package->update($request->all());
        return redirect('/admindashboard');
    }

    public function destroy($id)
    {
        Package::destroy($id);
        return redirect('/admindashboard');
    }
}
