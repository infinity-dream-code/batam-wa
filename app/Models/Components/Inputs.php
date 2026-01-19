<?php

namespace App\Models\Components;

use Illuminate\Database\Eloquent\Model;

class Inputs extends Model
{
    public static function Input($id, $name, $value): string
    {
        return "<input data-id='" . $id . "' type='text' class='form-control d-none' name='" . $name . "' id='input-" . $name . "-" . $id . "'aria-describedby='emailHelp' value = '" . $value . "'><div class='invalid-feedback'>Invalid feedback</div>
        ";
    }
}
