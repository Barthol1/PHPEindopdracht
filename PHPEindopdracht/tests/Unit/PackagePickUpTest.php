<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Package;
use App\enum\PackageStatus;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;

class PackagePickUpTest extends TestCase
{
    use WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_pick_up_package()
    {
        $user = User::find(5);

        $package = Package::factory()->create([
            'status' => PackageStatus::UITGEPRINT,
            'transporters_id' => $user->transporters_id,
        ]);

        $this->actingAs($user, 'web');

        $formData = [
            'date' => Carbon::now()->timezone('Europe/Amsterdam')->addDays(2)->toDateString(),
            'time' => Carbon::now()->timezone('Europe/Amsterdam')->toTimeString(),
            'selectedPackage' => [$package->id],
        ];

        $this->put(route('pickupPackage'), $formData)
        ->assertRedirect('/admindashboard');

        Package::destroy($package->id);
    }
}
