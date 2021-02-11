<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\HomeController;
Route::get('/', [HomeController::class, 'index']);

use App\Http\Controllers\DashboardController;
Route::get('/dashboard', [DashboardController::class, 'index']);

//Muestra toda la lista de gatos
use App\Http\Controllers\ExpenseReportController;
Route::resource('/expense_reports', ExpenseReportController::class);

//Borra una entrada
Route::get('/expense_reports/{id}/confirmDelete', [ExpenseReportController::class, 'confirmDelete']);

// Crear descripcion de gasto
use App\Http\Controllers\ExpenseController;
Route::get('/expense_reports/{expense_report}/expenses/create', [ExpenseController::class, 'create']);
Route::post('/expense_reports/{expense_report}/expenses', [ExpenseController::class, 'store']);


//Enviar mails
Route::get('/expense_reports/{id}/confirmSendMail', [ExpenseReportController::class, 'confirmSendMail']);
//use App\Http\Controllers\ExpenseController;

Route::post('/expense_reports/{id}/sendMail', [ExpenseReportController::class, 'sendMail']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
