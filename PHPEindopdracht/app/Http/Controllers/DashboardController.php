<?php

namespace App\Http\Controllers;

use App\Models\package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Digikraaft\ReviewRating\Models\Review;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PackageImport;
use Error;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Csv as WriterCsv;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
                ->orderByDesc('created_at')
                ->paginate(8);
        }
        else {
            $allpackages = DB::table('packages')
                ->where('packages.users_id', '=', $userid)
                ->orderByDesc('created_at')
                ->paginate(8);
        }
        return view('dashboard', compact('allpackages'));
    }

    public function addReview(Request $request,$id) {
        $request->validate([
            'review' => 'required'
        ]);
        $user = auth()->user();
        $package = package::find($id);
        $package->makeReview($user,$request->review, "Review");
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
