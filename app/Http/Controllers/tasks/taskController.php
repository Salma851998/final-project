<?php

namespace App\Http\Controllers\tasks;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use  App\Models\Task;

class taskController extends Controller
{
    function __construct()
    {
          $this->middleware('userCheck');
    }

    public function index()
    {
        $data = DB::table('tasks')
        ->join('users', 'tasks.userId', '=', 'users.id')
        ->select('tasks.*', 'users.name')
        ->where('userId','=',Auth('web')->user()->id)
        ->get(); // get all data from blogs table
        return view('tasks.index', ['title' => "List tasks.", 'data' => $data]);

}


    public function create()
    {
        //
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        //
        $data =   $this->validate($request, [
            "title"    => "required | max : 150",
            "content"  => "required|min:30 | max:15000",
            "startDate" => "required|date",
            "endDate"   => "required|date",
            "image" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ]);

        # Uploading the image to the server
        $imageName = time() . uniqid() . '.' . $request->image->extension();

        # Convert data to timestamp
        $data['startDate'] = strtotime($data['startDate']);
        $data['endDate'] = strtotime($data['endDate']);

        $request->image->move(public_path('images/tasks'), $imageName);

        $data['image'] = $imageName;

        $data['userId'] = auth('web')->user()->id;

        // DB Query Builder . . .
        $op = Task::create($data);

        if ($op) {
            $message = "task Created Successfully";
            session()->flash('Message-success', $message);
        } else {
            $message = "task Not Created";
            session()->flash('Message-error', $message);
        }

        return redirect(url('tasks'));
    }

    public function edit($id)
    {
        //

    }


    public function update(Request $request, $id)
    {
        //
    }


    public function remove($id)
    {
        //
        # Fetch Raw Data . . .
        $data = DB::table('tasks')->find($id);
        # DELETE OP . . .
        $op = DB::table('tasks')->where('id', $id)->delete();

        if ($op) {

            # Remove Image . . .
            unlink(public_path('images/tasks/' . $data->image));

            $message = "task Deleted Successfully";
            session()->flash('Message-success', $message);
        } else {
            $message = "task Not Deleted";
            session()->flash('Message-error', $message);
        }

        return redirect(url('tasks'));
    }
}
