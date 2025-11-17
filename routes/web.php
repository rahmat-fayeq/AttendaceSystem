<?php

use App\Http\Controllers\AttendanceLogController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/locale/{locale}', [LanguageController::class, 'change'])->name('locale.change');

Route::resource('devices', DeviceController::class)->except('show');
Route::resource('students', StudentController::class)->except('show');
Route::get('/attendance/daily', [AttendanceLogController::class,'index'])->name('attendance.daily');

Route::get('/attendance/fetch', function(){
    Artisan::call('attendance:fetch');
    return redirect()->back()->with('success','Attendance fetched!');
})->name('attendance.fetch');