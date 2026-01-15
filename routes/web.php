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
use App\Livewire\AgenciesMessages;
use App\Livewire\CreatePost;
use App\Livewire\JobPosting;
use App\Livewire\CompanyPosted;
use App\Livewire\MostPopular;
use App\Livewire\PostApplied;
use App\Livewire\SearchControl;
use App\Livewire\Pricingpage;
use App\Livewire\SubscriptionControl;


//company
use App\Livewire\CompanyDashboard;
use App\Livewire\ActivityLogsTable;

//ageny
use App\Livewire\AgencyDashboard;

//Admin
use App\Livewire\AdminDashboard;
use App\Livewire\AdminUserManagement;
use App\Livewire\AdminPostManagement;
use App\Livewire\AdminAuditTrail;

use App\Http\Controllers\DownloadController;

use App\Livewire\Checkout;

use App\Livewire\ChatList;
use App\Livewire\ProfileVisit;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/register', \App\Livewire\Auth\Register::class)
    ->middleware('guest') // only show to logged out users
    ->name('register');


Route::get('/download/{file}', [DownloadController::class, 'file'])
    ->where('file', '.*') // allow slashes
    ->name('download');

Route::get('/pricingpage', Pricingpage::class)->name('pricingpage');


// credential complete page not autheticated page
Route::get('/complete', function () {
    return view('complete'); 
});


// credential verification  - sugpon ni gro ka login based sa figma nila
//Route::get('/credentials-verification', CredentialsVerification::class)->name('credentials-verification');
//Route::get('/credential-complete', CredentialComplete::class)->name('credential-complete');

Route::get('/loginform', Login::class)->name('loginform');

// Shared routes for Company + Agency
Route::middleware(['auth', 'verified', 'role:Company|Agency', 'subscribed'])->group(function () {
    Route::view('companies', 'company')->name('company');
    Route::get('company-profile/{post}', CompanyProfile::class)->name('company-profile');
    Route::get('/chat-with-company', ChatWithCompany::class)->name('chat-with-company');
    Route::get('/chat', \App\Livewire\ChatList::class)
    ->name('chat-list');

    Route::get('/posted', CompanyPosted::class)->name('company-posted');
    Route::get('/Most-popular', MostPopular::class)->name('most-popular');
    Route::get('/Post-applied', PostApplied::class)->name('post-applied');
    Route::get('/profile/{user}', ProfileVisit::class)
    ->name('profile.visit');

   Route::get('/search', SearchControl::class)->name('search');

});

Route::middleware(['auth', 'verified', 'role:Company|Agency'])->group(function () {
    Route::get('/credentials', CredentialIndex::class)->name('credentials');
    Route::view('dashboard', 'dashboard')->name('dashboard');

});

// specific feature  function for company only 
Route::middleware(['auth', 'verified', 'role:Company', 'subscribed'])->group(function () {
    Route::get('/Agencies-messages', AgenciesMessages::class)->name('agencies-messages');
    Route::get('/Create-Post', CreatePost::class)->name('create-post');
    Route::get('/Job-posting', JobPosting::class)->name('job-posting');
});



Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('/Activity-logs', ActivityLogsTable::class)->name('Activity-logs');

    Route::get('/checkout/{plan}', Checkout::class)
    ->name('checkout');
});


// Admin Dashboard
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin-dashboard', AdminDashboard::class)->name('admin-dashboard'); 
    Route::get('/admin-UserManage', AdminUserManagement::class)->name('admin-UserManage'); 

    Route::get('/admin-PostManage', AdminPostManagement::class)->name('admin-PostManage'); 

    Route::get('/admin-Audit', AdminAuditTrail::class)->name('admin-Audit'); 
    Route::get('/admin-subcriptioncontrol', SubscriptionControl::class)->name('subscription-control');

});



require __DIR__.'/auth.php';
