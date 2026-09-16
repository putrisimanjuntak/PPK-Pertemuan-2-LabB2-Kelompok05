<?php
namespace App\Http\Controllers; use App\Models\{Project,Task};
class DashboardController extends Controller { public function index(){ $u=auth()->user(); return view('dashboard.index',['projectCount'=>Project::where('user_id',$u->id)->count(),'todoCount'=>Task::where('user_id',$u->id)->where('status','todo')->count(),'progressCount'=>Task::where('user_id',$u->id)->where('status','in_progress')->count(),'doneCount'=>Task::where('user_id',$u->id)->where('status','done')->count(),'tasks'=>Task::with('project')->where('user_id',$u->id)->orderBy('due_date')->latest()->take(8)->get()]); } }
