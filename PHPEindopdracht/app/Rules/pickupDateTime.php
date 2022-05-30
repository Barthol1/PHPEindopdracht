<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class pickupDateTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    var $value;

     public function __construct()
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->value = $value;

        $check = (
            $value >= Carbon::now()->timezone('Europe/Amsterdam')->addDays(1)->toDateString()
            && Carbon::now()->timezone('Europe/Amsterdam')->toTimeString() <= Carbon::parse("15:00:00")->format("H:i:s")
        )
        || $value >= Carbon::now()->timezone('Europe/Amsterdam')->addDays(2)->toDateString();

        return $check;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $message = null;
        $defaultTime = Carbon::parse("15:00:00")->format("H:i:s");

        if(Carbon::now()->timezone('Europe/Amsterdam')->toTimeString() > $defaultTime && $this->value < Carbon::now()->timezone('Europe/Amsterdam')->addDays(2)->toDateString()) {
            $message = "plan voor de 2e dag of later vanaf vandaag in";
        }
        else if($this->value < Carbon::now()->timezone('Europe/Amsterdam')->addDays(1)->toDateString() && $defaultTime > Carbon::now()->timezone('Europe/Amsterdam')->toTimeString()) {
            $message = "plan voor de volgende dag of later in";
        }

        return $message;
    }
}
