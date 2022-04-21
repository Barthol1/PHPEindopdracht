<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Resources\ProgramResource;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

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
        $http = new \GuzzleHttp\Client();

        $response = $http->post('http://127.0.0.1:8000/oauth/token', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json'
            ],
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '8',
                'client_secret' => 'dHF9SBkGQge9sFWmGCDNjCC1gBbwvoR0jbkrEKpD',
                'username' => 'test@test.nl',
                'password' => 'testtest',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
        // return view('/');


        // $user = Auth::user();

        // //  'headers' => [
        // //  'Accept' => 'application/json',
        // //  'Authorization' => 'Bearer '.$accessToken,
        // // ],
        //  $token=$request->post('/oauth/token', [
        //      'content-type' => 'application/json',
        //      'Accept' => 'application/json',
        //      'Authorization' => 'Bearer '.'mahgf1234567890',
        //  ]);
        //  //$token=$request->header('Authorization');


        //  return response()->json(['success' => $user,'token' => $token], $this-> successStatus);

        // // return response()->json(['user' => auth()->user()], 200);
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
            'receiver_adres' => 'required',
            'receiver_postalcode' => 'required',
            'receiver_city' => 'required',
        ]);

        $request['status'] = "Aangemeld";

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
