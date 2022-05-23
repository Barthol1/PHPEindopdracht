<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PackageImport;

use App\enum\PackageSorting;
use App\enum\PackageStatus;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $client = User::where('users.id', $user->id)->first();
        $packages = Package::where('users_id', $user->id);

        if($user->hasrole("pakket inpakker")) {
            $packages = Package::where('status', PackageStatus::SORTEERCENTRUM);
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

        return view('dashboard.index', compact('user', 'client', 'packages', 'status', 'sorting'));
    }

    public function addReview(Request $request,$id) {
        $request->validate([
            'review' => 'required'
        ]);
        $user = auth()->user();
        $package = package::find($id);
        $package->makeReview($user,$request->review, "Review");
        return redirect('/dashboard');
    }

    public function editPackage($id)
    {
        $user = Auth::user();
        $package = Package::where('users_id', $user->id)->find($id);

        if(!is_null($package)) {
            $client = User::where('users.id', $user->id)->first();

            return view('dashboard.editpackage', compact('user', 'client', 'package'));
        }

        return redirect('/dashboard');
    }

    public function importCSV(Request $request) {
        //try {
            if($request->hasFile("csvfile")) {
                Excel::import(new PackageImport, request()->file("csvfile"));
                return redirect()->back()->with('success','Data Geimporteerd');
            }
            else {
                return redirect()->back()->withErrors(['msg' => 'Geen bestand geselecteerd']);
            }
        //}
        // catch(Throwable $e) {
        //     return redirect()->back()->withErrors(['msg' => 'Er ging iets fout, check het bestand en probeer opnieuw']);
        // }
    }

    public function search(Request $request) {
        $user =  Auth::user();
        $client = User::where('users.id', $user->id)->first();
        $packages = Package::where('users_id', $user->id);

        if($request->filled('search')) {
            $packages = Package::search($request->search)->where('users_id', $user->id);
        }
        else {
            return redirect('/dashboard');
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

        return view('dashboard.index', compact('user', 'client', 'packages', 'status', 'sorting'));
    }

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
        //
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
