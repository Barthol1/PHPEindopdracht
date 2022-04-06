<?php

namespace App\Http\Controllers;

use App\Models\package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $webshopid = auth()->user()->webshops_id;
        $userid = auth()->user()->id;
        if(!isNull($webshopid)) {
            $allpackages = DB::table('packages')
                ->join('users', 'packages.users_id', '=', 'users.id')
                ->where('users.webshopid', '=', $webshopid)
                ->paginate(8);
        }
        else {
            $allpackages = DB::table('packages')
                ->where('packages.users_id', '=', $userid)
                ->paginate(8);
        }
        return view('dashboard', compact('allpackages'));
    }

    public function getPDF($id) {
        $package = package::all()->where('id', '=', $id)->first();
        $data = [
            'id' => $package->id,
            'name' => $package->name,
            'sender_adres' => $package->sender_adres,
            'sender_city' => $package->sender_city,
            'sender_postalcode' => $package->sender_postalcode,
            'receiver_adres' => $package->receiver_adres,
            'receiver_city' => $package->receiver_city,
            'receiver_postalcode' => $package->receiver_postalcode
        ];
        view()->share('package', $data);
        $pdf = PDF::loadView('pdfs.Label', $data);
        return $pdf->download($package->name.'.pdf');
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
