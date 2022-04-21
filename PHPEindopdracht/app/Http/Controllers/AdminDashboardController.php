<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\User;
use App\Models\Role;
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
        if(Auth::user()->id == Role::find(1)->id || Auth::user()->id == Role::find(2)->id || Auth::user()->id == Role::find(3)->id) {
            $allpackages = Package::paginate(8);
        }

        $allpackages = Package::where(Auth::user()->webshops_id, '!=', null);

        if($allpackages != null) {
            $allpackages->paginate(8);
        }

        if($request->Status!="") {
            $allpackages->where('Status', $request->Status);
        }

        if($request->Sorting!="") {
            $allpackages->orderBy('name', 'desc');
        }
        $allpackages = $allpackages->paginate(8);
        $status = PackageStatus::cases();
        $sorting = PackageSorting::cases();

        return view('admindashboard.index', compact('allpackages', 'status', 'sorting'));
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

    // public function webshopstore(Request $request)
    // {
    //     //
    // }



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
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
        ]);

        $request['webshops_id'] = 1;

        User::create($request->all());
        return redirect('/admindashboard');
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
    public function update(Request $request, $id)
    {
        //
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
