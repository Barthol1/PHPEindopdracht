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
        $client = User::where('users.id', Auth::user()->id)->first();
        $packages = Package::where('users_id', Auth::user()->id);

        if($request->Status!="") {
            $packages->where('Status', $request->Status);
        }

        if($request->Sorting!="") {
            $packages->orderBy('name', 'desc');
        }

        $status = PackageStatus::cases();
        $sorting = PackageSorting::cases();

        $packages = $packages->paginate(8);

        return view('dashboard.index', compact('client', 'packages', 'status', 'sorting'));
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
        $package = Package::where('users_id', Auth::user()->id)->find($id);

        if(is_null($package)) {
            $packages = Package::orderBy('status')
            ->orderBy('sender_city')
            ->where('users_id', Auth::user()->id)
            ->paginate(8);

            return view('dashboard.index', compact('packages'));
        }

        return view('dashboard.editpackage', compact('package'));
    }

    public function updatePackage(Request $request, $id)
    {
        Package::find($id)->update($request->all());
        return redirect('/');
    }

    public function importCSV(Request $request) {
        if($request->hasFile("csvfile")) {
            Excel::import(new PackageImport, request()->file("csvfile"));
            return redirect()->back()->with('success','Data Geimporteerd');
        }
        else {
            return redirect()->back()->withErrors(['msg' => 'Geen bestand geselecteerd']);
        }
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
