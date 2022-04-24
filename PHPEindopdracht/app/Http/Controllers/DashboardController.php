<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

use app\enum\status as EnumStatus;
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

use App\enum;
use App\enum\Package_Status;
use App\enum\PackageSorting;
use App\enum\PackageStatus;
use Dompdf\FrameDecorator\Table;
use PHPUnit\Framework\isNull;

use function PHPUnit\Framework\isNull;

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
        $packages = Package::orderBy('status')
        ->orderBy('sender_city')
        ->where('users_id', Auth::user()->id)
        ->paginate(8);

        // $webshopid = auth()->user()->webshops_id;
        // $userid = auth()->user()->id;

        // $query = DB::table('packages');
        // if(!isNull($webshopid)) {
        //     $allpackages = $query
        //         ->join('users', 'packages.users_id', '=', 'users.id')
        //         ->where('users.webshopid', '=', $webshopid);
        // }
        // else {
        //     $allpackages = $query
        //         ->where('packages.users_id', '=', $userid);
        // }

        if($request->Status!="") {
            $allpackages->where('Status', $request->Status);
        }

        if($request->Sorting!="") {
            $allpackages->orderBy('name', 'desc');
        }
        $allpackages = $allpackages->paginate(8);
        $status = PackageStatus::cases();
        $sorting = PackageSorting::cases();

        return view('dashboard', compact('allpackages', 'status', 'sorting'));
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
