<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\users\userController;
use App\Http\Controllers\users\authUserController;
use App\Http\Controllers\tasks\taskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route :: get('users',[userController :: class , 'index']);
Route :: get('users/create',[userController :: class , 'create']);
Route :: post('users/store',[userController :: class , 'store']);
Route :: get('users/index',[userController :: class , 'index']);
Route :: get('users/edit/{id}',[userController :: class , 'edit']);
Route :: put('users/update/{id}',[userController :: class , 'update']);
Route :: delete('users/Delete/{id}',[userController :: class , 'remove']);
//Route :: delete('Students/Delete',[studentController :: class , 'remove']);

Route :: get('Logout',[authUserController :: class , 'Logout']);
Route :: get('Login',[authUserController :: class , 'login']);
Route :: post('DOLogin',[authUserController :: class , 'doLogin']);

Route :: get('tasks',[taskController :: class , 'index']);
Route :: get('tasks/create',[taskController :: class , 'create']);
Route :: post('tasks/store',[taskController :: class , 'store']);
Route :: delete('tasks/Delete/{id}',[taskController :: class , 'remove'])->middleware('taskCheck');
