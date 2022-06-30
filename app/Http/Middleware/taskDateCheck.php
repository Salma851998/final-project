<?php

namespace App\Http\Middleware;
use  App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class taskDateCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $task = Task::where('id',$request->id)->get();
        $endDate=$task[0]->endDate;
        //$date=date('Y-m-d', strtotime($endDate));
        if($endDate > time()){
            return $next($request);
        }
        else{
            echo "the task can not be deleted";
            return redirect(url('tasks'));
        }

    }
}
