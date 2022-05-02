<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Package;
use App\enum\PackageStatus;

class PackageCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Package Command Executed Successfully!';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        $packages = Package::where('pick_up_time', '<=', Carbon::now()->addDays(2));

        $packages->each(function($p) {
            $p->status = PackageStatus::VERZONDEN;
            $p->save();
        });

        // $client = new \GuzzleHttp\Client();
        // $request = $client->get('https://127.0.0.1:8000/api/packages/status');
        // $response = $request->getBody()->getContents();
        // return json_decode($response, true);
    }
}
