<?php

namespace App\Http\Middleware;

use App\Models\Request as ModelsRequest;
use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Switch_;
use Symfony\Component\HttpFoundation\Response;

class RequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //get id from /request/{id}
        $id = $request->id;

        $req = ModelsRequest::find($id);

        $task = Task::where('request_id', $id)->get();

        $tech = $task->pluck('technicalStaff_id')->toArray();


        switch (session('user')['role']) {

                //if mis - able to access all of the request
            case 'Mis Staff':
                return $next($request);
                break;


                //if faculty - Only the user’s own request can be accessed
            case 'Faculty':
                if ($req->faculty_id == session('user')['id']) {
                    return $next($request);
                } else {
                    return redirect('/request');
                }
                break;


                //if technical staff - check if tech id is in many task from one request;
            case 'Technical Staff':

                if (in_array(session('user')['id'], $tech)) {
                    return $next($request);
                } else {
                    return redirect('/request');
                }

                break;


            default:
                return redirect('/request');
                break;
        }

    }
}
