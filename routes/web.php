<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
// creditial -tabs
use App\Livewire\CredentialIndex;
use App\Livewire\CredentialsVerification;
use App\Livewire\FoundingInfo;
use App\Livewire\CredentialComplete;
use App\Livewire\CompanyProfile;
use App\Livewire\ChatWithCompany;


//company
use App\Livewire\CompanyDashboard;

//ageny
use App\Livewire\AgencyDashboard;

//Admin
use App\Livewire\AdminDashboard;



Route::get('/', function () {
    return view('welcome');
})->name('home');

// not authenticated page . connected sa login form 
Route::get('/credentials', function () {
    return view('credentials'); 
});
// credential complete page not autheticated page
Route::get('/complete', function () {
    return view('complete'); 
});


// credential verification  - sugpon ni gro ka login based sa figma nila
Route::get('/credentials-verification', CredentialsVerification::class)->name('credentials-verification');
Route::get('/credential-complete', CredentialComplete::class)->name('credential-complete');

Route::get('/loginform', Login::class)->name('loginform');





Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])  ->name('dashboard');
Route::view('companies', 'company')->middleware(['auth', 'verified'])->name('company');
Route::get('/company-profile', CompanyProfile::class)->name('company-profile');
Route::get('/chat-with-company', ChatWithCompany::class)->name('chat-with-company');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});


Route::prefix('dashboard')
    ->middleware(['auth', 'verified', 'role:Admin|Agency|Company'])
    ->group(function () {
        Route::view('/', 'dashboard')->name('dashboard');
    });



// Admin Dashboard
//Route::middleware(['auth', 'role:Admin'])->group(function () {
   // Route::get('/admin', AdminDashboard::class)->name('admin-dashboard'); 
//});

// Agency Dashboard
//Route::middleware(['auth', 'role:Agency'])->group(function () {
//    Route::get('/agency', AgencyDashboard::class)->name('agency-dashboard'); 
//});

// Company Dashboard
//Route::middleware(['auth', 'role:Company'])->group(function () {
//Route::get('/company', CompanyDashboard::class)->name('company-dashboard'); 
//});

require __DIR__.'/auth.php';
