<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::middleware('auth:api')->group(function() {
    Route::namespace('Api')->group(function() {


   
     //AUTH 
     Route::post('/profil', 'AuthController@profil');
     Route::post('/change_password/{id}', 'AuthController@change_password');
     Route::post('adduser', 'AuthController@adduser');
  
     ///USERS
     Route::apiResource('users','UsersController');
     Route::get('/userByrole', 'UsersController@userByrole');
  
     ///POSTS
     Route::apiResource('posts', 'PostsController');
     Route::get('/posts/posts_user/{id_user}', 'PostsController@postsByUser');
     Route::get('/posts/posts_user/{id_user}', 'PostsController@postsByUser');
     Route::get('/posts/posts_user_short/{id_user}', 'PostsController@postsByUserShort');

     //PROJETS
     Route::apiResource('projects','ProjectsController');
     Route::get('/projects_byuser/{id}', 'ProjectsController@allprojects');
  
     // FORM PDF 
     Route::post('saveformpdf2', 'ProjectsController@saveformpdf2');
  
     /////RECORDS
     Route::apiResource('records','RecordsController');
     Route::get('/postsByLocation/{id}', 'RecordsController@postsByLocation');

     //EMAILS
     Route::post('sendform1', 'EmailsController@sendform1');
     Route::get('/sendmail', 'MailController@sendmail');


     ///LOCATIONS 
     Route::get('/locationsbyuser/{id_user}', 'LocationController@postsByUser');

    


     
     });
});

Route::namespace('Api')->group(function() {



       Route::get('/searchadress','AuthController@searchAdress');
       Route::post('/login', 'AuthController@login');
       Route::post('/register','AuthController@register');
       Route::post('/verifywithcode', 'VerificationApiController@verifywithcode');
       //Route::post('logout', 'AuthController@logout');

        Route::post('/forgotpassword', 'AuthController@resetpassword');
        Route::apiResource('tags', 'TagsController');
        Route::get('email/verify/{id}','VerificationApiController@verify')->name('verificationapi.verify');
        Route::get('email/resend','VerificationApiController@resend')->name('verificationapi.resend');
        Route::get('/verify/{token}', 'VerificationApiController@VerifyEmail');

   
        Route::post('notifcontact', 'NotificationsController@notifContact');
        
        /////XML
        Route::get('/sitemap-posts.xml', 'SitemapController@posts');


        Route::get('/clear-cache', function() {
          $exitCode = Artisan::call('cache:clear');
          // return what you want
        });

        });


          