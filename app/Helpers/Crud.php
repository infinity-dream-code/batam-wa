<?php
namespace App\Helpers;
use Auth;
use Illuminate\Support\Facades\Validator;

class Crud
{

  public function insert($model, $request, $rules, $title, $uri_redirect)
  {
      $request->offsetUnset('_token');

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
          $message_errors = (new Validation)->modify($validator, $rules);

          return response()->json([
              'status' => false,
              'alert' => 'danger',
              'message' => 'Required Form',
              'validation_errors' => $message_errors,
          ], 200);
      }

      $model::create($request->all());

      $message = 'New '.$title.' Has Been Created Successfully!';

      return $this->responseAction($message, $uri_redirect);
  }


  public function update($model, $request, $rules, $title, $uri_redirect)
  {
      $request->offsetUnset('_token');

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
          $message_errors = (new Validation)->modify($validator, $rules);

          return response()->json([
              'status' => false,
              'alert' => 'danger',
              'message' => 'Required Form',
              'validation_errors' => $message_errors,
          ], 200);
      }

      $model->update($request->all());

      $message = $title.' Has Been Updated Successfully!';

      return $this->responseAction($message, $uri_redirect);
  }

  public function responseAction($message, $uri_redirect)
  {
    session()->flash('message', $message);
    session()->flash('status', 'success');

    return response()->json([
        'status' => true,
        'alert' => 'success',
        'message' => $message,
        'redirect_to' => $uri_redirect,
        'validation_errors' => []
    ], 200);
  }
}
