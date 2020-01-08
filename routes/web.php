<?php

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

Auth::routes();
Route::get('/register/{hash}', 'Auth\RegisterController@showRegistrationForm');
//Route::get('/correction', 'CorrectDatesController@index');
//Route::get('/empty-users', 'CorrectDatesController@emptyUsers');
//Route::get('/delete-gian', 'CorrectDatesController@deleteCaGian');


Route::get('/home', 'HomeController@index')->name('home');


/****   ADMIN ROUTES *****/
Route::group(['middleware'=>'roles', 'roles'=> ['admin'], 'prefix' => 'admin'], function(){

    Route::get('/empty-users', 'CorrectDatesController@emptyUsers');

    //ADMIN INVITE CLIENT ADVISOR
    Route::get('/invite', ['uses' => 'Admin\DashboardController@invite', 'as' => 'admin.invite']);
    Route::post('/invite', ['uses' => 'Admin\DashboardController@store', 'as' => 'invite.store']);
    Route::delete('/invite/{email}', ['uses' => 'Admin\DashboardController@deleteInvite', 'as' => 'delete.invite']);
    Route::get('/invite/{email}/{hash}/{name}', ['uses' => 'Admin\DashboardController@send_mail', 'as' => 'invite.sendemail']);
    Route::post('/sendAll/', ['uses' => 'Admin\DashboardController@sendAll', 'as' => 'admin.sendAll']);

    //Reminders
    Route::get('reminders', ['uses'=>'Admin\ReminderController@index', 'as'=>'reminders.index']);
    Route::get('reminders/{occasion_id}', ['uses'=>'Admin\ReminderController@create', 'as'=>'reminders.create'])->where('occasion_id', '[\d]+');
    Route::get('reminders/{occasion_id}/{idea_id}', ['uses'=>'Admin\ReminderController@showIdea', 'as'=>'reminders.idea.show'])->where('occasion_id', '[\d]+')->where('idea_id', '[\d]+');
    Route::match(['get', 'post'], '/reminders/{occasion_id}/filter', ['uses'=>'Admin\ReminderController@filter', 'as'=>'reminders.filter'])->where('occasion_id', '[\d]+');
    Route::post('/reminders/{occasion_id}/search', ['uses'=>'Admin\ReminderController@search', 'as'=>'reminders.search'])->where('occasion_id', '[\d]+');
    Route::post('/reminders/add-idea', ['uses'=>'Admin\ReminderController@addIdea', 'as'=>'reminders.add-idea']);
    Route::post('/reminders/remove-idea', ['uses'=>'Admin\ReminderController@removeIdea', 'as'=>'reminders.remove-idea']);
    Route::get('/reminders/preview/{id}', ['uses'=>'Admin\ReminderController@preview', 'as'=>'reminders.preview']);
    Route::get('/reminders/schedule/{reminder_id}', ['uses'=>'Admin\ReminderController@schedule', 'as'=>'reminders.schedule']);
    Route::post('/reminders/schedule-cancel', ['uses'=>'Admin\ReminderController@scheduleCancel', 'as'=>'reminders.schedule-cancel']);
    Route::post('/reminders/send-email', ['uses'=>'Admin\ReminderController@sendEmail', 'as'=>'reminders.send-email']);
    Route::post('/reminders/send-sms', ['uses'=>'Admin\ReminderController@sendSms', 'as'=>'reminders.send-sms']);
    Route::delete('/reminders/delete/{id}', ['uses'=>'Admin\ReminderController@deleteReminder', 'as'=>'reminders.delete'])->where('id', '[\d]+');

    //Ideas
    Route::match(['get', 'post'], '/ideas/filter', ['uses'=>'Admin\IdeaController@filter', 'as'=>'ideas.filter']);
    Route::resource('/ideas', 'Admin\IdeaController');
    Route::post('/ideas/search', ['uses'=>'Admin\IdeaController@search', 'as'=>'ideas.search']);
    Route::post('/ideas/image-delete', ['uses'=>'Admin\IdeaController@imageDelete', 'as'=>'ideas.image-delete']);
    Route::get('/pull-ideas', ['uses'=>'Admin\IdeaController@pullIdeas']);

    //Payments
    Route::get('/payments', ['uses'=>'Admin\PaymentController@index', 'as'=>'payments.index']);
    Route::post('/payments', ['uses'=>'Admin\PaymentController@changeStatus', 'as'=>'payments.change-status']);

    //Settings
    Route::put('/setting/update', ['uses'=>'Admin\SettingController@limitUpdate', 'as'=>'setting.update']);
    Route::put('/setting/expiration', ['uses'=>'Admin\SettingController@expirationUpdate', 'as'=>'expiration.update']);

    //Tags
    Route::get('/tags', ['uses'=>'Admin\TagController@index', 'as'=>'tags.index']);
    Route::post('/tags', ['uses'=>'Admin\TagController@tagUpdate', 'as'=>'tags.update']);
    Route::post('/tags-delete', ['uses'=>'Admin\TagController@tagDelete', 'as'=>'tags.delete']);
    Route::post('/tags-store', ['uses'=>'Admin\TagController@tagstore', 'as'=>'tags.store']);

    //Exchange Rate
    Route::get('/settings/exchange-rate', ['uses'=>'Admin\SettingController@settings', 'as'=>'exchange-rate.edit']);
    Route::put('/settings/exchange-rate/update', ['uses'=>'Admin\SettingController@currencyUpdate', 'as'=>'exchange-rate.update']);

    //Client advisors
    Route::delete('/{id}', ['uses' => 'Admin\DashboardController@deleteClientAdvisor', 'as' => 'ca.delete']);
    Route::get('/{id}', ['uses' => 'Admin\DashboardController@editViewClientAdvisor', 'as' => 'ca.edit'])->where('id', '[\d]+');
    Route::put('/{id}', ['uses' => 'Admin\DashboardController@editClientAdvisor', 'as' => 'ca.edit'])->where('id', '[\d]+');

    //Notifications
    Route::get('/notifications', ['uses' => 'Admin\NotificationController@index', 'as' => 'notifications.index']);

    //Analytics
    Route::get('/analytics', ['uses' => 'Admin\AnalyticsController@index', 'as' => 'analytics.index']);
    Route::get('/analytics/chart-1', ['uses' => 'Admin\AnalyticsController@exportChart1', 'as' => 'analytics.chart-1']);
    Route::get('/analytics/chart-2', ['uses' => 'Admin\AnalyticsController@exportChart2', 'as' => 'analytics.chart-2']);
    Route::get('/analytics/chart-3', ['uses' => 'Admin\AnalyticsController@exportChart3', 'as' => 'analytics.chart-3']);
    Route::get('/analytics/chart-4', ['uses' => 'Admin\AnalyticsController@exportChart4', 'as' => 'analytics.chart-4']);
    Route::get('/analytics/chart-5', ['uses' => 'Admin\AnalyticsController@exportChart5', 'as' => 'analytics.chart-5']);
    Route::get('/analytics/chart-6', ['uses' => 'Admin\AnalyticsController@exportChart6', 'as' => 'analytics.chart-6']);
    Route::get('/analytics/chart-7', ['uses' => 'Admin\AnalyticsController@exportChart7', 'as' => 'analytics.chart-7']);
    Route::get('/analytics/chart-8', ['uses' => 'Admin\AnalyticsController@exportChart8', 'as' => 'analytics.chart-8']);
    Route::get('/analytics/chart-9', ['uses' => 'Admin\AnalyticsController@exportChart9', 'as' => 'analytics.chart-9']);
    Route::get('/analytics/chart-10', ['uses' => 'Admin\AnalyticsController@exportChart10', 'as' => 'analytics.chart-10']);
    Route::get('/analytics/chart-11', ['uses' => 'Admin\AnalyticsController@exportChart11', 'as' => 'analytics.chart-11']);
    Route::get('/analytics/chart-12', ['uses' => 'Admin\AnalyticsController@exportChart12', 'as' => 'analytics.chart-12']);

    //Feedback
    Route::get('/feedback', ['uses'=>'Admin\FeedbackController@index', 'as'=>'feedback.index']);

});

/****   CLIENTADVISOR ROUTES *****/
Route::group(['middleware'=>'roles', 'roles'=> ['ClientAdvisor'], 'prefix' => 'client-advisor'], function(){

    //CLIENTADVISOR ADD CLIENT
    Route::get('/add', ['uses' => 'ClientAdvisor\DashboardController@addClientPrivate', 'as' => 'ca.add.private']);
    Route::get('/add-public', ['uses' => 'ClientAdvisor\DashboardController@addClientPublic', 'as' => 'ca.add']);
    Route::get('/occasion', ['uses' => 'ClientAdvisor\DashboardController@addOccasion', 'as' => 'ca.occasion']);
    Route::get('/occasion/{id}', ['uses' => 'ClientAdvisor\DashboardController@clientOccasion', 'as' => 'ca.occasionitem']);
    Route::delete('/delete/{id}', ['uses' => 'ClientAdvisor\DashboardController@deleteOccasion', 'as' => 'ca.occasion.delete']);

    //CLIENTS
    Route::post('client-advisor/clients/store', ['uses' => 'ClientAdvisor\ClientController@store', 'as' => 'ca.clients.store']);


    //Update client data
    Route::put('/client/{id}', ['uses' => 'ClientAdvisor\DashboardController@clientUpdate', 'as' => 'ca.client.update']);

    Route::put('/clientLikes/{id}', ['uses' => 'ClientAdvisor\DashboardController@clientLikesUpdate', 'as' => 'ca.clientsLikes.update']);
    Route::put('/clientDislikes/{id}', ['uses' => 'ClientAdvisor\DashboardController@clientDislikesUpdate', 'as' => 'ca.clientsDislikes.update']);
    //clientAdvisor interestings
    Route::put('/clientAdvisorLikes/{id}', ['uses' => 'ClientAdvisor\DashboardController@clientLikesUpdate', 'as' => 'ca.clientsLikes.update']);
    Route::put('/clientAdvisorDislikes/{id}', ['uses' => 'ClientAdvisor\DashboardController@clientAdvisorDislikesUpdate', 'as' => 'ca.clientAdvisorDislikes.update']);
    Route::put('/clientAdvisorLikes/{id}', ['uses' => 'ClientAdvisor\DashboardController@clientAdvisorLikesUpdate', 'as' => 'ca.clientAdvisorLikes.update']);


    //Reminders
    Route::get('/reminders', ['uses'=>'ClientAdvisor\ReminderController@index', 'as'=>'ca.reminders.index']);
    Route::get('/reminders/{reminder_id}', ['uses'=>'ClientAdvisor\ReminderController@show', 'as'=>'ca.reminders.show']);
    Route::post('/reminders/{reminder_id}/payment', ['uses'=>'ClientAdvisor\ReminderController@payment', 'as'=>'ca.payment'])->where('reminder_id', '[\d]+');
    Route::post('/feedback', ['uses'=>'ClientAdvisor\FeedbackController@store', 'as'=>'ca.feedback.store']);

    //payment stripe
    //Route::post('/pay', ['uses' => 'ClientAdvisor\PaymentController@pay', 'as' => 'pay']);

    //account edit
    Route::get('/account', ['uses' => 'ClientAdvisor\AccountController@index', 'as' => 'ca.account']);
    Route::put('/account/update', ['uses'=>'ClientAdvisor\AccountController@update', 'as'=>'ca.account.update']);
    Route::put('/account/updatePassword', ['uses'=>'ClientAdvisor\AccountController@updatePassword', 'as'=>'ca.account.update-password']);

    //Clicks
    Route::post('/clicks', ['uses' => 'ClientAdvisor\ClickController@create', 'as' => 'ca.clicks.create']);




});

Route::post('client-advisor/interests', ['uses' => 'ClientAdvisor\DashboardController@interests', 'as' => 'ca.interests']);
Route::post('client-advisor/new', ['uses' => 'ClientAdvisor\DashboardController@newOccasion', 'as' => 'ca.newOccasion']);

