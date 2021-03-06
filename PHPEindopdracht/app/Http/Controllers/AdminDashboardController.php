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
        $packages = null;
        $clients = null;
        $webshops = null;

        if(!is_null($user->getRoleNames()) && $user->can("schrijven")) {
            $webshops = Webshop::all();
            $packages = Package::select();
            $clients = User::doesntHave('roles')->orderBy('name', 'asc')->where('transporters_id', null)->get();
        }
        else if($user->can("lezen")) {
            $packagesUser = Package::where('transporters_id', null)
            ->whereIn('status', [PackageStatus::AANGEMELD, PackageStatus::UITGEPRINT]);

            $packagesTransporter = Package::where('transporters_id', Auth::user()->transporters_id)
            ->whereIn('status', [PackageStatus::VERZONDEN, PackageStatus::SORTEERCENTRUM, PackageStatus::UITGEPRINT]);

            $packages = $packagesUser->union($packagesTransporter);
        }

        if($request->Status!="") {
            $packages->where('Status', $request->Status);
        }
        if($request->Sorting!="") {
            $packages->orderBy($request->Sorting, 'desc');
        }

        $status = PackageStatus::cases();
        $sorting = PackageSorting::cases();

        $packages = $packages->paginate(8);

        return view('admindashboard.index', compact('clients', 'packages', 'webshops', 'status', 'sorting'));
    }

    public function getPDF($id) {
        $package = Package::all()->where('id', '=', $id);
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
        $package = Package::all();
        foreach($package as $p) {
            $p->status = "Uitgeprint";
            $p->save();
        }
        $data = compact('package');
        view()->share('package', $data);
        $pdf = PDF::loadView('pdfs.Label', $data);

        return $pdf->download($package->first()->name.'.pdf');
    }

    public function search(Request $request) {
        $user = Auth::user();
        $packages = null;
        $clients = null;
        $webshops = null;

        if(!is_null($user->getRoleNames()) != null && $user->can("schrijven")) {
            $webshops = Webshop::all();
            $packages = Package::select();
            $clients = User::doesntHave('roles')->orderBy('name', 'asc')->where('transporters_id', null)->get();

            if($request->filled('search')) {
                $packages = Package::search($request->search);
            }
        }
        else if($user->can("lezen")) {
            $packagesUser = Package::where('transporters_id', null)
            ->whereIn('status', [PackageStatus::AANGEMELD, PackageStatus::UITGEPRINT]);

            $packagesTransporter = Package::where('transporters_id', Auth::user()->transporters_id)
            ->whereIn('status', [PackageStatus::VERZONDEN, PackageStatus::SORTEERCENTRUM, PackageStatus::UITGEPRINT]);

            $packages = $packagesUser->union($packagesTransporter);

            $packagesAangemeld = Package::search($request->search)
            ->where('transporters_id', null)
            ->whereIn('status', [PackageStatus::AANGEMELD, PackageStatus::UITGEPRINT]);

            $packagesTransporter = Package::search($request->search)
            ->where('transporters_id', Auth::user()->transporters_id)
            ->whereIn('status', [PackageStatus::VERZONDEN, PackageStatus::SORTEERCENTRUM, PackageStatus::UITGEPRINT]);

            if($request->filled('search') && !empty(count($packagesAangemeld->get()))) {
                $packages = $packagesAangemeld;
            }
            else if($request->filled('search') && !empty(count($packagesTransporter->get()))) {
                $packages = $packagesTransporter;
            }
        }

        if($request->Status!="") {
            $packages->where('Status', $request->Status);
        }
        if($request->Sorting!="") {
            $packages->orderBy('name', 'desc');
        }

        $status = PackageStatus::cases();
        $sorting = PackageSorting::cases();

        $packages = $packages->paginate(8);

        return view('admindashboard.index', compact('clients', 'packages', 'webshops', 'status', 'sorting'));
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
        $request->validate([
            'client' => 'required|not_in:0',
            'webshop' => 'required|not_in:0',
        ]);

        $user = User::find($request->client);
        $user->webshops_id = $request->webshop;
        $user->save();

        return redirect('/admindashboard');
    }

    public function pickupPackage(Request $request) {
        $request->validate([
            'date' => ['required', new pickupDateTime],
            'time' => 'required',
            'selectedPackage' => 'required',
        ]);

        $selectedPackages = $request->selectedPackage;

        if(!is_null($selectedPackages)) {
            foreach ($selectedPackages as $selected) {
                $package = Package::find($selected);
                $package->transporters_id = Auth::user()->transporters_id;
                $package->pick_up_time = date($request->date . ' ' . $request->time);
                $package->status = PackageStatus::SORTEERCENTRUM;
                $package->save();
            }
        }

        return redirect('/admindashboard');
    }
}
