<?php namespace Lib\Gestion\User;

use User;
use Input;
use Hash;
use Request;

class UserGestion implements UserGestionInterface {
    
    public function store(){
        $user = new User;
		$user->username = Request::get('username');
		$user->email = Request::get('email');
		$user->password = Hash::make(Request::get('password'));
		$user->active = 0;
		$user->token = md5(time() . ' - ' . uniqid());
		$user->save();
    }
    
    public function show($id){
        return User::find($id);
    }
    
    public function update($id){
        $user = User::find($id);
		$user->username = Request::get('username');
		$user->email = Request::get('email');
		$user->password = Hash::make(Request::get('password'));
		$user->save();
    }
    
    public function destroy($id){
        User::find($id)->delete();
    }
    
    public function login(){
        return User::
				where('username', Request::get('username'))
				->first();
    }
    
    
}