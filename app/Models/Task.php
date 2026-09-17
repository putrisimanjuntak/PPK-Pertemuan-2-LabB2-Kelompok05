<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Task extends Model { protected $fillable=['project_id','user_id','title','description','priority','status','due_date','completed_at']; protected $casts=['due_date'=>'date','completed_at'=>'datetime']; public function project(){return $this->belongsTo(Project::class);} public function user(){return $this->belongsTo(User::class);} public function members(){return $this->hasMany(TaskMember::class);} public function markAsDone():void{$this->update(['status'=>'done','completed_at'=>now()]);} }
