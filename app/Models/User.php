<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable { use Notifiable; protected $fillable=['name','email','password','role']; protected $hidden=['password','remember_token']; protected function casts():array{return ['password'=>'hashed'];} public function projects(){return $this->hasMany(Project::class);} public function tasks(){return $this->hasMany(Task::class);} public function taskMembers(){return $this->hasMany(TaskMember::class);} public function isAdmin():bool{return $this->role==='admin';} }
