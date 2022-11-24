<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\ZipcodeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PricingPlanController;
use App\Http\Controllers\PricingPlanDetailController;
use App\Http\Controllers\PricingPlanHistoryController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\Team\TeamController;

use App\Http\Controllers\OrgController;
use App\Http\Controllers\DeptController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Plan\PlanController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Team\TeamUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::delete('languages/destroy', [LanguageController::class, 'massDestroy'])->name('languages.massDestroy');
    Route::resource('languages', LanguageController::class);

    Route::delete('countries/destroy', [CountryController::class, 'massDestroy'])->name('countries.massDestroy');
    Route::resource('countries', CountryController::class);

    Route::delete('states/destroy', [StateController::class, 'massDestroy'])->name('states.massDestroy');
    Route::resource('states', StateController::class);

    Route::delete('cities/destroy', [CityController::class, 'massDestroy'])->name('cities.massDestroy');
    Route::post('cities/getstates', [CityController::class, 'getStates'])->name('cities.getstates');
    Route::resource('cities', CityController::class);

    Route::delete('tags/destroy', [TagController::class, 'massDestroy'])->name('tags.massDestroy');
    Route::resource('tags', TagController::class);

    Route::delete('zipcodes/destroy', [ZipcodeController::class, 'massDestroy'])->name('zipcodes.massDestroy');
    Route::resource('zipcodes', ZipcodeController::class);

    Route::delete('pricing-plans/destroy', [PricingPlanController::class, 'massDestroy'])->name('pricing-plans.massDestroy');
    Route::resource('pricing-plans', PricingPlanController::class);

    Route::delete('pricing-plan-details/destroy', [PricingPlanDetailController::class, 'massDestroy'])->name('pricing-plan-details.massDestroy');
    Route::resource('pricing-plans.pricing-plan-details', PricingPlanDetailController::class);

    Route::delete('pricing-plan-histories/destroy', [PricingPlanHistoryController::class, 'massDestroy'])->name('pricing-plan-histories.massDestroy');
    Route::resource('pricing-plan-histories', PricingPlanHistoryController::class)->only('destroy');

    Route::delete('organizations/destroy', [OrganizationController::class, 'massDestroy'])->name('organizations.massDestroy');
    Route::resource('organizations', OrganizationController::class);

    Route::post('states', [OrganizationController::class, 'fetchState'])->name('states');
    Route::post('cities', [OrganizationController::class, 'fetchCity'])->name('cities');
    Route::delete('subjects/destroy', [SubjectController::class, 'massDestroy'])->name('subjects.massDestroy');
    Route::resource('subjects', SubjectController::class);
    Route::delete('courses/destroy', [CourseController::class, 'massDestroy'])->name('courses.massDestroy');
    Route::resource('courses', CourseController::class);
    Route::delete('schools/destroy', [SchoolController::class, 'massDestroy'])->name('schools.massDestroy');
    Route::resource('schools', SchoolController::class);

    Route::resource('users', UserController::class);

    Route::delete('levels/destroy', [LevelController::class, 'massDestroy'])->name('levels.massDestroy');
    Route::resource('levels', LevelController::class);

    Route::delete('classes/destroy', [ClassController::class, 'massDestroy'])->name('classes.massDestroy');
    Route::resource('classes', ClassController::class);

    Route::delete('departments/destroy', [DepartmentController::class, 'massDestroy'])->name('departments.massDestroy');
    Route::resource('departments', DepartmentController::class);

    Route::delete('pages/destroy', [PageController::class, 'massDestroy'])->name('pages.massDestroy');
    Route::resource('pages', PageController::class);

    Route::delete('chapters/destroy', [ChapterController::class, 'massDestroy'])->name('chapters.massDestroy');
    Route::resource('chapters', ChapterController::class);

    Route::delete('books/destroy', [BookController::class, 'massDestroy'])->name('books.massDestroy');
    Route::resource('books', BookController::class);

    /**
     * team related routes
     */
    Route::delete('team/destroy', [TeamController::class, 'massDestroy'])->name('team.massDestroy');
    Route::resource('team', TeamController::class);

    Route::delete('team/user/mass-remove', [TeamUserController::class, 'removeUsersFromTeam'])->name('team.users.remove');
    Route::resource('team.team-users',TeamUserController::class)->only(['index','store','create','destroy']);

    Route::delete('orgs/destroy', [OrgController::class, 'massDestroy'])->name('orgs.massDestroy');
    Route::resource('orgs', OrgController::class);

    Route::delete('depts/destroy', [DeptController::class, 'massDestroy'])->name('depts.massDestroy');
    Route::resource('depts', DeptController::class);

    Route::resource('permissions',PermissionController::class)->except(['destroy']);
    Route::resource('roles',RoleController::class)->except(['destroy']);

    Route::resource('plans',PlanController::class);

});

require __DIR__ . '/auth.php';
