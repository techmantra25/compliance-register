<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use App\Livewire\{
    AdminDashboard,
    ZoneCrud,
    PhaseCrud,
    EventCategoryCrud,
    EmployeeCrud,
    AssemblyList,
    CandidateContactList,
    CandidateDocumentCollection,
    CandidateDocumentVetting,
    DiscrepancyReportCrud,
    CandidateJourney,
    AgentCrud,
    AdminLogin,
    CampaignCrud,
    PermissionCampaignCrud
};
use App\Livewire\Candidate\DocumentComments;
use App\Http\Controllers\CandidateController;

/*
|--------------------------------------------------------------------------
| Language Switch Route
|--------------------------------------------------------------------------
| This lets the user change language (English ↔ Bengali) by clicking a
| toggle button. It stores the chosen language in the session.
*/
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'bn'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Root Redirect
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Admin Login (guest)
|--------------------------------------------------------------------------
*/
Route::get('/login', AdminLogin::class)
    ->middleware('guest:admin')
    ->name('login');

/*
|--------------------------------------------------------------------------
| Authenticated Admin Routes
|--------------------------------------------------------------------------
| These are protected routes for logged-in admins only.
| The SetLocale middleware (registered in bootstrap/app.php) ensures
| text is displayed in the selected language.
*/
Route::prefix('/admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');

    Route::prefix('master')->group(function () {
        Route::get('/zones', ZoneCrud::class)->name('admin.master.zones');
        Route::get('/phases', PhaseCrud::class)->name('admin.master.phases');
        Route::get('/event-categories', EventCategoryCrud::class)->name('admin.master.eventcategory');
    });
    Route::get('/employees', EmployeeCrud::class)->name('admin.employees');
    Route::get('/assemblies', AssemblyList::class)->name('admin.assemblies');
    Route::get('/contacts', AgentCrud::class)->name('admin.agents');
    
    Route::prefix('candidates')->group(function () {
        Route::get('/journey/{id}', CandidateJourney::class)->name('admin.candidates.journey');
        Route::get('/nominations', CandidateContactList::class)->name('admin.candidates.contacts');
        Route::get('/social-media', DiscrepancyReportCrud::class)->name('admin.candidates.discrepancies.report');
        // Route::get('/Candidate Discrepancy Reports', [CandidateController::class, 'nominations'])->name('admin.candidates.nominations');
        // Route::get('/documents', [CandidateController::class, 'documents'])->name('admin.candidates.documents');
        // Route::get('/vetting', [CandidateController::class, 'vetting'])->name('admin.candidates.vetting');
        Route::get('/documents', CandidateDocumentCollection::class)->name('admin.candidates.documents');
        Route::get('/documents/comments/{document}', DocumentComments::class)->name('admin.candidates.documents.comments');
        Route::get('/documents/vetting/{document}', CandidateDocumentVetting::class)->name('admin.candidates.documents.vetting');
    });


    Route::prefix('campaign')->group(function (){
        Route::get('/', CampaignCrud::class)->name('admin.campaigns');
        Route::get('/permission/{campaign_id}', PermissionCampaignCrud::class)->name('admin.campaigns.permission');
    });
});

/*
|--------------------------------------------------------------------------
| API Route Example
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/store-device-id', function (\Illuminate\Http\Request $request) {
    session(['device_id' => $request->device_id]);
    return response()->json(['status' => 'ok']);
});
Route::post('/logout', function () {
    Auth::guard('admin')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('admin.logout');
