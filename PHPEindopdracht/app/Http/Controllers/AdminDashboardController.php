<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\User;
use App\Models\Webshop;
use App\Rules\pickupDateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\enum\PackageSorting;
use App\enum\PackageStatus;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $allpackages = null;
        $clients = null;
        $webshops = null;

        if($user->getRoleNames() != null && $user->can("schrijven")) {
            $webshops = Webshop::all();
            $allpackages = Package::select();
            $clients = User::doesntHave('roles')->orderBy('name', 'asc')->where('transporters_id', null)->get();
        }
        else if($user->can("lezen")) {
            $allpackages = Package::where('transporters_id', null)
            ->where('status', 'Aangemeld')
            ->orwhere('transporters_id', Auth::user()->transporters_id)
            ->where('status', 'Onderweg');
        }

        if($request->Status!="") {
            $allpackages->where('Status', $request->Status);
        }

        if($request->Sorting!="") {
            $allpackages->orderBy('name', 'desc');
        }

        $status = PackageStatus::cases();
        $sorting = PackageSorting::cases();

        $allpackages = $allpackages->paginate(8);

        return view('admindashboard.index', compact('clients', 'allpackages', 'webshops', 'status', 'sorting'));
    }

    public function getPDF($id) {
        $package = package::all()->where('id', '=', $id);
        foreach($package as $p) {
            $p->status = "Uitgeprint";
            $p->save();
        }
        $data = compact('package');
        view()->share('package', $data);
        $pdf = PDF::loadView('pdfs.Label', $data);
        return $pdf->download($package->first()->name.'.pdf');
    }

    public function getAllPDF() {
        $package = package::all();
        foreach($package as $p) {
            $p->status = "Uitgeprint";
            $p->save();
        }
        $data = compact('package');
        view()->share('package', $data);
        $pdf = PDF::loadView('pdfs.Label', $data);
        return $pdf->download($package->first()->name.'.pdf');
    }

    public function webshopstore(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // User::create($request->all());
        // return redirect('/admindashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateWebshopClient(Request $request)
    {
        $user = User::find($request->client);
        $user->webshops_id = $request->webshop;
        $user->save();

        return redirect('/admindashboard');
    }

    public function pickupPackage(Request $request) {
        $request->validate([
            'time' => 'required',
            'date' => ['required', new pickupDateTime()],
        ]);

        $selectedPackages = $request->selectedPackage;

        if(!is_null($selectedPackages)) {
            foreach ($selectedPackages as $selected) {
                $package = Package::find($selected);
                $package->transporters_id = Auth::user()->transporters_id;
                $package->pick_up_time = date($request->date . ' ' . $request->time);
                $package->status = "Onderweg";
                $package->save();
            }
        }

        return redirect('/admindashboard');
 }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
