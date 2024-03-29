<?php

use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\User\UserController;
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
use App\Http\Controllers\DeptUserController;
use App\Http\Controllers\DMS\DocumentTagController;
use App\Http\Controllers\DMS\InviteController;
use App\Http\Controllers\DMS\ProjectController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Plan\PlanController;
use App\Http\Controllers\Process\ProcessController;
use App\Http\Controllers\Process\ProcessInstanceController;
use App\Http\Controllers\Process\ProcessStepController;
use App\Http\Controllers\Process\StepInstanceController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Team\TeamProcessController;
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

    // Route::resource('users', UserController::class);

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

    Route::delete('plans/destroy', [PlanController::class, 'massDestroy'])->name('plans.massDestroy');
    Route::resource('plans',PlanController::class);

    Route::delete('team/process/mass-remove', [TeamProcessController::class, 'massDestroy'])->name('team.process.remove');
    Route::resource('team.team-process', TeamProcessController::class)->except('edit','update','show');

    Route::delete('process/destroy', [ProcessController::class, 'massDestroy'])->name('processes.massDestroy');
    Route::resource('processes',ProcessController::class);

    Route::delete('dept/user/mass-remove', [DeptUserController::class, 'massDestroy'])->name('dept.users.remove');
    Route::resource('depts.dept-users',DeptUserController::class)->except('edit','show');

    Route::delete('users/destroy',[UserController::class,'massDestroy'])->name('users.massDestroy');
    Route::get('org/{org_id}',[AjaxController::class,'fetchUsersByOrgId'])->name('org.users');
    Route::resource('users',UserController::class);

    // Route::delete('steps/destroy',[StepController::class,'massDestroy'])->name('steps.massDestroy');
    Route::get('org/{org_id}/depts',[AjaxController::class,'deptsByOrgId'])->name('org.depts');
    // Route::resource('steps',StepController::class);

    Route::delete('process/process-instance/destroy', [ProcessInstanceController::class, 'massDestroy'])->name('process.instance.massDestroy');
    Route::resource('processes.process-instance',ProcessInstanceController::class);

    Route::delete('process/step-instance/destroy', [StepInstanceController::class, 'massDestroy'])->name('process.step-instance.massDestroy');
    Route::resource('process-instance.step-instance',StepInstanceController::class)->only('index','edit','update','destroy','show');

    Route::delete('process/step/destroy', [ProcessStepController::class, 'massDestroy'])->name('process.step.massDestroy');
    Route::resource('process.steps',ProcessStepController::class);

    Route::delete('media/{media_id}/delete',[AjaxController::class,'deleteMedia'])->name('media.remove');

});

Route::middleware(['auth'])->prefix('dms')->name('dms.')->group(function(){
    Route::resource('projects',ProjectController::class);
    Route::resource('project.invites',InviteController::class);

    Route::delete('tags/destroy', [DocumentTagController::class, 'massDestroy'])->name('document-tags.massDestroy');
    Route::resource('document-tags',DocumentTagController::class);
});

require __DIR__ . '/auth.php';
