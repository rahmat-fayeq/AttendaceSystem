<?php

use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AttendanceLogController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){
    Route::get('/', fn() => view('pages.dashboard'));
    Route::get('/locale/{locale}', [LanguageController::class, 'change'])->name('locale.change');
    Route::resource('devices', DeviceController::class)->except('show');
    Route::resource('students', StudentController::class)->except('show');
    Route::get('/attendance/daily', [AttendanceLogController::class,'index'])->name('attendance.daily');
    Route::resource('accounts', AccountController::class)->except(['show']);
    // Profile Route
    Route::get('/profile', [UpdateUserProfileInformation::class,'index'])->name('user-profile-information.index');
});