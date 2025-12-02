<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use App\Livewire\{
    AdminDashboard,
    PhaseWiseDistrict,
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
    PermissionCampaignCrud,
    ForgetPassword,
    UpdateProfile,
    RolePermissions,
    StarCampaignerCrud
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

Route::get('/forget/password',ForgetPassword::class)->name('forget.password');

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
    Route::get('/update/profile', UpdateProfile::class)->name('admin.update.profile');
    Route::get('/phasewise/district', PhaseWiseDistrict::class)->name('admin.phasewise.district');

    Route::prefix('master')->group(function () {
        Route::get('/zones', ZoneCrud::class)->name('admin.master.zones')->middleware('employee.permission:master_view_zones');
        Route::get('/phases', PhaseCrud::class)->name('admin.master.phases')->middleware('employee.permission:master_view_phases');
        Route::get('/event-categories', EventCategoryCrud::class)->name('admin.master.eventcategory')->middleware('employee.permission:master_view_event_categories');
    });

    Route::prefix('/employees')->group(function (){
        Route::get('/', EmployeeCrud::class)->name('admin.employees')->middleware('employee.permission:employee_view_employee');
        Route::get('/permissions/{id}', RolePermissions::class)->name('admin.employees.permissions');
    });

    Route::get('/assemblies', AssemblyList::class)->name('admin.assemblies')->middleware('employee.permission:assembly_view_assembly');
    Route::get('/contacts', AgentCrud::class)->name('admin.agents')->middleware('employee.permission:contact_view_contacts');
    
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
        Route::get('/', CampaignCrud::class)->name('admin.campaigns')->middleware('employee.permission:campaign_view_campaign');
        Route::get('/permission/{campaign_id}', PermissionCampaignCrud::class)->name('admin.campaigns.permission')->middleware('employee.permission:campaign_campaign_permission');
        Route::get('/star-campaigner', StarCampaignerCrud::class)->name('admin.campaigns.star-campaigner');
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
