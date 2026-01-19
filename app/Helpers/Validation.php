<?php
namespace App\Helpers;

class Validation
{

    public function modify($validator,$rules)
    {
        $message_errors = [];
            $obj_validators     = $validator->errors();
            foreach(array_keys($rules) as $key => $field){
                if ($obj_validators->has($field)) {
                    $message_errors[] = ['id' => $field , 'message'=> $obj_validators->first($field)];
                }
            }
        return $message_errors;
    }
}