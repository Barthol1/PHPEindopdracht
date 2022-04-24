<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = User::where('users.id', Auth::user()->id)->first();
        $packages = Package::orderBy('status')
        ->orderBy('sender_city')
        ->where('users_id', Auth::user()->id)
        ->paginate(8);

        return view('dashboard.index', compact('client', 'packages'));
    }

    public function getOrder() {


        return view('dashboard.index', compact('packages'));
    }

    public function addReview(Request $request,$id) {
        $user = auth()->user()->id;

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
