<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use  App\Models\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    //


    function __construct()
    {
          $this->middleware('userCheck',['except' => ['create','store']]);
    }


    public function index()
    {


        $users =  User::get(); // get all users
        return view('users.index', ['data' => $users]);

    }

    #############################################################################################################
    public function create()
    {

        return view('users.create');
    }

    ##############################################################################################################

    public function store(Request $request)
    {

        $data =  $this->validate($request, [
            'name'     => "required",
            'email'    => "required|email",
            'password' => "required|max:10",
        ]);


        # Hashing the password before saving it to the database
        $data['password']  = bcrypt($data['password']);




        $op =  User::create($data);    // insert into users (name,email,passsowrd) values ($data['name'],$data['email'],$data['password'])

        if ($op) {
            $message = "user Created Successfully";
            session()->flash('Message-success', $message);
        } else {
            $message = "user Not Created";
            session()->flash('Message-error', $message);
        }

        return redirect(url('users/create'));
    }

    ##############################################################################################################
    public function edit($id)
    {

        # Fetch data
        //  $student = student :: where('id',$id)->get();    // $student[0]->name
        $user = User::find($id);                // $student->name

        return view('users.edit', ['data' => $user]);
    }

    ##############################################################################################################

    public function update(Request $request, $id)
    {
        // update . . .


        $data =  $this->validate($request, [
            'name'     => "required",
            'email'    => "required|email",
            'password' => 'nullable|min:6',
        ]);


        if ($request->has('changePassword')) {

            $data['password']  = bcrypt($request->password);
        } else {
            unset($data['password']);
        }



        $op = User::where('id', $id)->update($data);

        if ($op) {
            $message = "user Updated Successfully";
            session()->flash('Message-success', $message);
        } else {
            $message = "user Not Updated";
            session()->flash('Message-error', $message);
        }

        return redirect(url('users'));
    }

    public function remove($id)
    {

        # DELETE OP . . .
        $op = User::where('id', $id)->delete();

        if ($op) {
            $message = "user Deleted Successfully";
            session()->flash('Message-success', $message);
        } else {
            $message = "user Not Deleted";
            session()->flash('Message-error', $message);
        }

        return redirect(url('users'));
    }
    ##############################################################################################################










}
