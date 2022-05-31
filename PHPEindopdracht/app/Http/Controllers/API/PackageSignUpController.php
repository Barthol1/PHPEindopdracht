<?php

namespace App\Http\Controllers\API;

use App\enum\PackageStatus;
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

    public function get($packagenr)
    {
        return Package::where('name', 'like', '%' . $packagenr . '%')->where('users_id', request()->user()->id)->get();
    }

    public function store(Request $request)
    {
        $webshop = Webshop::find($request->user()->webshops_id);

        if(!is_null($webshop)) {
            $request['sender_name'] = $webshop->name;
            $request['sender_adres'] = $webshop->adres;
            $request['sender_city'] = $webshop->place;
            $request['sender_postalcode'] = $webshop->postalcode;
        }

        $request->validate([
            'sender_name' => 'required|max:255',
            'sender_adres' => 'required|max:255',
            'sender_city' => 'required|max:189',
            'sender_postalcode' => array(
                'required',
                'regex:/^[1-9][0-9]{3} ?(?!sa|sd|ss)[A-Z]{2}$/i'
            ),
            'receiver_name' => 'required|max:255',
            'receiver_adres' => 'required|max:255',
            'receiver_postalcode' => array(
                'required',
                'regex:/^[1-9][0-9]{3} ?(?!sa|sd|ss)[A-Z]{2}$/i'
            ),
            'receiver_city' => 'required|max:189',
        ]);

        $package = new Package();

        $intsString = "";

        for($i = 0; $i < 10; $i++) {
            $intsString .= strval(rand(0,9));
        }

        $package->name = $intsString;

        $package->sender_name = $request['sender_name'];
        $package->sender_adres = $request['sender_adres'];
        $package->sender_city = $request['sender_city'];
        $package->sender_postalcode = trim(strtoupper(substr_replace($request['receiver_postalcode'], ' ', 4, 0)));

        $package->status = PackageStatus::AANGEMELD;
        $package->users_id = request()->user()->id;

        $package->receiver_name = $request['receiver_name'];
        $package->receiver_adres = $request['receiver_adres'];
        $package->receiver_city = $request['receiver_city'];
        $package->receiver_postalcode = trim(strtoupper(substr_replace($request['receiver_postalcode'], ' ', 4, 0)));

        $package->save();

        return response()->json(["result" => "package created " . $package->name]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sender_name' => 'required|max:255',
            'sender_adres' => 'required|max:255',
            'sender_city' => 'required|max:189',
            'sender_postalcode' => array(
                'required',
                'regex:/^[1-9][0-9]{3} ?(?!sa|sd|ss)[A-Z]{2}$/i'
            ),
            'receiver_name' => 'required|max:255',
            'receiver_adres' => 'required|max:255',
            'receiver_postalcode' => array(
                'required',
                'regex:/^[1-9][0-9]{3} ?(?!sa|sd|ss)[A-Z]{2}$/i'
            ),
            'receiver_city' => 'required|max:189',
        ]);

        $package = Package::find($id);
        $package->update();

        if($package) {
            return response()->json(["result" => "updated package " . $package->name]);
        }

        return response()->json(["result" => "failed to update package"]);
    }

    public function destroy($id)
    {
        $package = Package::find($id);
        Package::destroy($id);

        if($package) {
            return response()->json(["result" => "deleted package " . $package->name]);
        }

        return response()->json(["result" => "failed to delete package"]);
    }
}
