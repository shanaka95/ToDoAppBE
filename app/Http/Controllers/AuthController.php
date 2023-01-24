<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends BaseController
{
    /**
    * Register a new user 
    * Inputs: name, email, password, confirm password
    *
    * @return \Illuminate\Http\Response
    */
    public function register(Request $request)
    {
        // Validate Inputs
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        // Sends validation error when inputs are not valid
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->all();

        // Use bcrypt to hash password
        $input['password'] = bcrypt($input['password']);

        // Create a new user
        $user = User::create($input);

        // Create a new access token and add it to the response
        $success['token'] =  $user->createToken('name')->accessToken;

        // Add user's name to the response
        $success['name'] =  $user->name;

        // Sending a success response
        return $this->sendResponse($success, 'Added a new User!');
    }

    /**
    * Login a user
    * Inputs: email, password
    *
    * @return \Illuminate\Http\Response
    */
    public function login(Request $request)
    {
        // Check if email and password are correct
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            // Create current logged in user object
            $user = Auth::user(); 

            // Create a new auth token for the user and add it to the response
            $success['token'] =  $user->createToken('name')-> accessToken; 

            // Add user's name to the response
            $success['name'] =  $user->name;

            // Sending a success response
            return $this->sendResponse($success, 'User login successfully.');
        } 

        // Send error response if email and password do not match
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}

?>