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
        $check = (
            $value >= Carbon::now()->addDays(1)->toDateString()
            && Carbon::now()->timezone('Europe/Amsterdam')->toTimeString() <= Carbon::parse("15:00:00")->format("H:i:s")
        )
        || $value >= Carbon::now()->addDays(2)->toDateString();

        return $check;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Write your own message...';

        // if(Carbon::now()->timezone('Europe/Amsterdam')->toTimeString() > Carbon::parse("15:00:00")->format("H:i:s")) {
        //     return $message += "plan voor de 2e dag";
        // }
        // else if($value != Carbon::now()->addDays(1)->toDateString()) {
        //     return $message += "";
        // }
    }
}
