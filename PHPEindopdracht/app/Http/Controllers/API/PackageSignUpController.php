<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Webshop;
use Illuminate\Http\Request;

class PackageSignUpController extends Controller
{
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
        $webshop = Webshop::find($request->user()->webshops_id);

        $arrayOfInts = array();
        for($i = 0; $i < 10; $i++) {
            $value = rand(0,9);
            array_push($arrayOfInts, $value);
        }

        $request['name'] = implode('', $arrayOfInts);

        if(!is_null($webshop)) {
            $request['sender_name'] = $webshop->name;
            $request['sender_adres'] = $webshop->adres;
            $request['sender_city'] = $webshop->place;
            $request['sender_postalcode'] = $webshop->postalcode;
        }

        $request->validate([
            'sender_name'=>'required',
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

        $package = Package::create($request->all());

        return response()->json(["result" => "package created " . $package->name]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sender_name'=>'required',
            'sender_adres'=>'required',
            'sender_city'=>'required',
            'sender_postalcode'=>'required',
            'receiver_name' => 'required',
            'receiver_adres' => 'required',
            'receiver_postalcode' => 'required',
            'receiver_city' => 'required',
        ]);

        $package = Package::find($id);
        $package->update($request->all());

        if($package) {
            return response()->json(["result" => "updated package " . $package->name]);
        }

        return response()->json(["result" => "failed to update package"]);
    }

    public function destroy($id)
    {
        $package = Package::find($id);
        $package::destroy($id);

        if($package) {
            return response()->json(["result" => "deleted package " . $package->name]);
        }

        return response()->json(["result" => "failed to delete package"]);
    }
}
