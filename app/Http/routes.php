<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
* Sentry filter
*
* Checks if the user is logged in
*/
Route::filter('Sentry', function()
{
	if ( ! Sentry::check()) {
		return Redirect::to('admin/signin')->with('error', 'Lütfen giriş yapınız!');
	}
});

Route::get('/', 'WelcomeController@index');
Route::group(array('prefix' => 'admin'), function () {

	# Error pages should be shown without requiring login
	Route::get('404', function () {
	    return View('admin/404');
	});
	Route::get('500', function () {
	    return View::make('admin/500');
	});

	# Lock screen aswell
	Route::get('lockscreen', function () {
	    return View::make('admin/lockscreen');
	});


	# All basic routes defined here
	Route::get('signin', array('as' => 'signin','uses' => 'AuthController@getSignin'));
	Route::post('signin','AuthController@postSignin');
	Route::post('signup',array('as' => 'signup','uses' => 'AuthController@postSignup'));
	Route::post('forgot-password',array('as' => 'forgot-password','uses' => 'AuthController@postForgotPassword'));
	Route::get('login2', function () {
	    return View::make('admin/login2');
	});

	# Forgot Password Confirmation
    Route::get('forgot-password/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'AuthController@getForgotPasswordConfirm'));
    Route::post('forgot-password/{passwordResetCode}', 'AuthController@postForgotPasswordConfirm');

    # Logout
	Route::get('logout', array('as' => 'logout','uses' => 'AuthController@getLogout'));

	# Account Activation
    Route::get('activate/{activationCode}', array('as' => 'activate', 'uses' => 'AuthController@getActivate'));

    # Dashboard / Index
	Route::get('/', array('as' => 'dashboard','uses' => 'MainController@showHome'));

	# Settings Management
	Route::group(array('prefix' => 'settings','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'settings', 'uses' => 'SettingsController@getIndex'));
		Route::post('/', 'SettingsController@postIndex');
	});

	# Languages Management
	Route::group(array('prefix' => 'languages','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'languages', 'uses' => 'LanguagesController@getIndex'));
		Route::get('create', array('as' => 'create/language', 'uses' => 'LanguagesController@getCreate'));
		Route::post('create', 'LanguagesController@postCreate');
		Route::get('{languageId}/edit', array('as' => 'update/language', 'uses' => 'LanguagesController@getEdit'));
		Route::post('{languageId}/edit', 'LanguagesController@postEdit');
		Route::get('{languageId}/delete', array('as' => 'delete/language', 'uses' => 'LanguagesController@getDelete'));
		Route::get('{languageId}/confirm-delete', array('as' => 'confirm-delete/language', 'uses' => 'LanguagesController@getModalDelete'));
		Route::get('{languageId}/restore', array('as' => 'restore/language', 'uses' => 'LanguagesController@getRestore'));
		Route::get('{languageId}', array('as' => 'languages.show', 'uses' => 'LanguagesController@show'));
	});

	# Translation Management
	Route::group(array('prefix' => 'translations','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'translations', 'uses' => 'TranslationsController@getIndex'));
		Route::get('data', array('as' => 'admin.translations.data', 'uses' => 'TranslationsController@data'));
		Route::get('create', array('as' => 'create/translation', 'uses' => 'TranslationsController@getCreate'));
		Route::post('create', 'TranslationsController@postCreate');
		Route::get('{translationId}/edit', array('as' => 'update/translation', 'uses' => 'TranslationsController@getEdit'));
		Route::post('{translationId}/edit', 'TranslationsController@postEdit');
		Route::get('{translationId}/delete', array('as' => 'delete/translation', 'uses' => 'TranslationsController@getDelete'));
		Route::get('{translationId}/confirm-delete', array('as' => 'confirm-delete/translation', 'uses' => 'TranslationsController@getModalDelete'));
	});

	# Shipping Company Management
	Route::group(array('prefix' => 'cargos','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'cargos', 'uses' => 'CargosController@getIndex'));
		Route::get('create', array('as' => 'create/cargo', 'uses' => 'CargosController@getCreate'));
		Route::post('create', 'CargosController@postCreate');
		Route::get('{cargoId}/edit', array('as' => 'update/cargo', 'uses' => 'CargosController@getEdit'));
		Route::post('{cargoId}/edit', 'CargosController@postEdit');
		Route::get('{cargoId}/delete', array('as' => 'delete/cargo', 'uses' => 'CargosController@getDelete'));
		Route::get('{cargoId}/confirm-delete', array('as' => 'confirm-delete/cargo', 'uses' => 'CargosController@getModalDelete'));
		Route::get('{cargoId}/restore', array('as' => 'restore/cargo', 'uses' => 'CargosController@getRestore'));
		Route::get('{cargoId}', array('as' => 'cargos.show', 'uses' => 'CargosController@show'));
	});

	# PayMethods Management
	Route::group(array('prefix' => 'paymethods','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'paymethods', 'uses' => 'PaymethodsController@getIndex'));
		Route::get('create', array('as' => 'create/paymethod', 'uses' => 'PaymethodsController@getCreate'));
		Route::post('create', 'PaymethodsController@postCreate');
		Route::get('{paymethodId}/edit', array('as' => 'update/paymethod', 'uses' => 'PaymethodsController@getEdit'));
		Route::post('{paymethodId}/edit', 'PaymethodsController@postEdit');
		Route::get('{paymethodId}/delete', array('as' => 'delete/paymethod', 'uses' => 'PaymethodsController@getDelete'));
		Route::get('{paymethodId}/confirm-delete', array('as' => 'confirm-delete/paymethod', 'uses' => 'PaymethodsController@getModalDelete'));
		Route::get('{paymethodId}/restore', array('as' => 'restore/paymethod', 'uses' => 'PaymethodsController@getRestore'));
		Route::get('{paymethodId}', array('as' => 'paymethods.show', 'uses' => 'PaymethodsController@show'));
	});

	# BankAccounts Management
	Route::group(array('prefix' => 'bankaccounts','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'bankaccounts', 'uses' => 'BankAccountsController@getIndex'));
		Route::get('create', array('as' => 'create/bankaccount', 'uses' => 'BankAccountsController@getCreate'));
		Route::post('create', 'BankAccountsController@postCreate');
		Route::get('{bankaccountId}/edit', array('as' => 'update/bankaccount', 'uses' => 'BankAccountsController@getEdit'));
		Route::post('{bankaccountId}/edit', 'BankAccountsController@postEdit');
		Route::get('{bankaccountId}/delete', array('as' => 'delete/bankaccount', 'uses' => 'BankAccountsController@getDelete'));
		Route::get('{bankaccountId}/confirm-delete', array('as' => 'confirm-delete/bankaccount', 'uses' => 'BankAccountsController@getModalDelete'));
		Route::get('{bankaccountId}/restore', array('as' => 'restore/bankaccount', 'uses' => 'BankAccountsController@getRestore'));
		Route::get('{bankaccountId}', array('as' => 'bankaccounts.show', 'uses' => 'BankAccountsController@show'));
	});
        
        # POS Management
	Route::group(array('prefix' => 'posaccounts','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'posaccounts', 'uses' => 'PosAccountsController@getIndex'));
		Route::get('create', array('as' => 'create/posaccount', 'uses' => 'PosAccountsController@getCreate'));
		Route::post('create', 'PosAccountsController@postCreate');
		Route::get('{posaccountId}/edit', array('as' => 'update/posaccount', 'uses' => 'PosAccountsController@getEdit'));
		Route::post('{posaccountId}/edit', 'PosAccountsController@postEdit');
		Route::get('{posaccountId}/delete', array('as' => 'delete/posaccount', 'uses' => 'PosAccountsController@getDelete'));
		Route::get('{posaccountId}/confirm-delete', array('as' => 'confirm-delete/posaccount', 'uses' => 'PosAccountsController@getModalDelete'));
		Route::get('{posaccountId}/restore', array('as' => 'restore/posaccount', 'uses' => 'PosAccountsController@getRestore'));
		Route::get('{posaccountId}', array('as' => 'posaccounts.show', 'uses' => 'PosAccountsController@show'));
	});

	# Categories Management
	Route::group(array('prefix' => 'categories','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'categories', 'uses' => 'CategoriesController@getIndex'));
		Route::get('create', array('as' => 'create/categorie', 'uses' => 'CategoriesController@getCreate'));
		Route::post('create', 'CategoriesController@postCreate');
		Route::get('{categorieId}/edit', array('as' => 'update/categorie', 'uses' => 'CategoriesController@getEdit'));
		Route::post('{categorieId}/edit', 'CategoriesController@postEdit');
		Route::get('{categorieId}/delete', array('as' => 'delete/categorie', 'uses' => 'CategoriesController@getDelete'));
		Route::get('{categorieId}/confirm-delete', array('as' => 'confirm-delete/categorie', 'uses' => 'CategoriesController@getModalDelete'));
		Route::get('{categorieId}/restore', array('as' => 'restore/categorie', 'uses' => 'CategoriesController@getRestore'));
		Route::get('{categorieId}', array('as' => 'categories.show', 'uses' => 'CategoriesController@show'));
	});

	# Products Management
	Route::group(array('prefix' => 'products','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'products', 'uses' => 'ProductsController@getIndex'));
		Route::get('create', array('as' => 'create/product', 'uses' => 'ProductsController@getCreate'));
		Route::post('create', 'ProductsController@postCreate');
		Route::get('{productId}/edit', array('as' => 'update/product', 'uses' => 'ProductsController@getEdit'));
		Route::post('{productId}/edit', 'ProductsController@postEdit');
		Route::get('{productId}/copy', array('as' => 'copy/product', 'uses' => 'ProductsController@getCreate'));
		Route::post('{productId}/copy', 'ProductsController@postCreate');
		Route::get('{productId}/delete', array('as' => 'delete/product', 'uses' => 'ProductsController@getDelete'));
		Route::get('{productId}/confirm-delete', array('as' => 'confirm-delete/product', 'uses' => 'ProductsController@getModalDelete'));
		Route::get('{productId}/restore', array('as' => 'restore/product', 'uses' => 'ProductsController@getRestore'));
		Route::get('{productId}/pictures', array('as' => 'updatePictures/product', 'uses' => 'ProductsController@getPictures'));
		Route::post('{productId}/pictures','ProductsController@postPictures');
		Route::get('{productId}/options', array('as' => 'updateOptions/product', 'uses' => 'ProductsController@getOptions'));
		Route::post('{productId}/options','ProductsController@postOptions');
        Route::get('data', array('as' => 'products.data', 'uses' => 'ProductsController@data'));

        Route::group(array('prefix' => '{productId}/properties'), function () {
            Route::get('/', array('as' => 'prodproperties', 'uses' => 'ProdpropertiesController@index'));
            Route::post('create', array('as' => 'create/prodprop', 'uses' => 'ProdpropertiesController@store'));
            Route::get('{propId}/edit', array('as' => 'update/prodprop', 'uses' => 'ProdpropertiesController@edit'));
            Route::post('{propId}/edit', 'ProdpropertiesController@update');
            Route::get('{propId}/delete', array('as' => 'delete/prodprop', 'uses' => 'ProdpropertiesController@destroy'));
            Route::get('{propId}/confirm-delete', array('as' => 'confirm-delete/prodprop', 'uses' => 'ProdpropertiesController@getModalDelete'));
        });

	});

	# Brands Management
	Route::group(array('prefix' => 'brands','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'brands', 'uses' => 'BrandsController@getIndex'));
		Route::get('create', array('as' => 'create/brand', 'uses' => 'BrandsController@getCreate'));
		Route::post('create', 'BrandsController@postCreate');
		Route::get('{brandId}/edit', array('as' => 'update/brand', 'uses' => 'BrandsController@getEdit'));
		Route::post('{brandId}/edit', 'BrandsController@postEdit');
		Route::get('{brandId}/delete', array('as' => 'delete/brand', 'uses' => 'BrandsController@getDelete'));
		Route::get('{brandId}/confirm-delete', array('as' => 'confirm-delete/brand', 'uses' => 'BrandsController@getModalDelete'));
		Route::get('{brandId}/restore', array('as' => 'restore/brand', 'uses' => 'BrandsController@getRestore'));
		Route::get('{brandId}', array('as' => 'brands.show', 'uses' => 'BrandsController@show'));
	});

	# Orders Management
	Route::group(array('prefix' => 'orders','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'orders', 'uses' => 'OrdersController@getIndex'));
		Route::get('create', array('as' => 'create/order', 'uses' => 'OrdersController@getCreate'));
		Route::post('create', 'OrdersController@postCreate');
		Route::get('{orderId}/edit', array('as' => 'update/order', 'uses' => 'OrdersController@getEdit'));
		Route::post('{orderId}/edit', 'OrdersController@postEdit');
		Route::get('{orderId}/delete', array('as' => 'delete/order', 'uses' => 'OrdersController@getDelete'));
		Route::get('{orderId}/confirm-delete', array('as' => 'confirm-delete/order', 'uses' => 'OrdersController@getModalDelete'));
		Route::get('{orderId}', array('as' => 'orders.show', 'uses' => 'OrdersController@show'));
        Route::get('{orderId}/print', array('as' => 'print/order', 'uses' => 'OrdersController@getPrintView'));
	});

	# Reviews Management
	Route::group(array('prefix' => 'reviews','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'reviews', 'uses' => 'ReviewsController@getIndex'));
		Route::get('create', array('as' => 'create/review', 'uses' => 'ReviewsController@getCreate'));
		Route::post('create', 'ReviewsController@postCreate');
		Route::get('{reviewId}/edit', array('as' => 'update/review', 'uses' => 'ReviewsController@getEdit'));
		Route::post('{reviewId}/edit', 'ReviewsController@postEdit');
		Route::get('{reviewId}/delete', array('as' => 'delete/review', 'uses' => 'ReviewsController@getDelete'));
		Route::get('{reviewId}/confirm-delete', array('as' => 'confirm-delete/review', 'uses' => 'ReviewsController@getModalDelete'));
		Route::get('{reviewId}', array('as' => 'reviews.show', 'uses' => 'ReviewsController@show'));
	});


	# User Management
    Route::group(array('prefix' => 'users','before' => 'Sentry'), function () {
    	Route::get('/', array('as' => 'users', 'uses' => 'UsersController@getIndex'));
    	Route::get('create', array('as' => 'create/user', 'uses' => 'UsersController@getCreate'));
        Route::post('create', 'UsersController@postCreate');
        Route::get('{userId}/edit', array('as' => 'users.update', 'uses' => 'UsersController@getEdit'));
        Route::post('{userId}/edit', 'UsersController@postEdit');
    	Route::get('{userId}/delete', array('as' => 'delete/user', 'uses' => 'UsersController@getDelete'));
		Route::get('{userId}/confirm-delete', array('as' => 'confirm-delete/user', 'uses' => 'UsersController@getModalDelete'));
		Route::get('{userId}/restore', array('as' => 'restore/user', 'uses' => 'UsersController@getRestore'));
		Route::get('{userId}', array('as' => 'users.show', 'uses' => 'UsersController@show'));
		Route::post('{userId}', array('as' => 'users.show', 'uses' => 'UsersController@changePass'));
	});
	Route::get('deleted_users',array('as' => 'deleted_users', 'uses' => 'UsersController@getDeletedUsers'));

	# Group Management
    Route::group(array('prefix' => 'groups','before' => 'Sentry'), function () {
        Route::get('/', array('as' => 'groups', 'uses' => 'GroupsController@getIndex'));
        Route::get('create', array('as' => 'create/group', 'uses' => 'GroupsController@getCreate'));
        Route::post('create', 'GroupsController@postCreate');
        Route::get('{groupId}/edit', array('as' => 'update/group', 'uses' => 'GroupsController@getEdit'));
        Route::post('{groupId}/edit', 'GroupsController@postEdit');
        Route::get('{groupId}/delete', array('as' => 'delete/group', 'uses' => 'GroupsController@getDelete'));
        Route::get('{groupId}/confirm-delete', array('as' => 'confirm-delete/group', 'uses' => 'GroupsController@getModalDelete'));
        Route::get('{groupId}/restore', array('as' => 'restore/group', 'uses' => 'GroupsController@getRestore'));
		Route::get('any_user', 'UsersController@getUserAccess');
		Route::get('admin_only', 'UsersController@getAdminOnlyAccess');
    });

	# Customer Management
	Route::group(array('prefix' => 'customers','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'customers', 'uses' => 'CustomersController@getIndex'));
		Route::get('create', array('as' => 'create/customer', 'uses' => 'CustomersController@getCreate'));
		Route::post('create', 'CustomersController@postCreate');
		Route::get('{customerId}/edit', array('as' => 'customers.update', 'uses' => 'CustomersController@getEdit'));
		Route::post('{customerId}/edit', 'CustomersController@postEdit');
		Route::get('{customerId}/delete', array('as' => 'delete/customer', 'uses' => 'CustomersController@getDelete'));
		Route::get('{customerId}/confirm-delete', array('as' => 'confirm-delete/customer', 'uses' => 'CustomersController@getModalDelete'));
		Route::get('{customerId}/restore', array('as' => 'restore/customer', 'uses' => 'CustomersController@getRestore'));
		Route::get('{customerId}', array('as' => 'customers.show', 'uses' => 'CustomersController@show'));
		Route::get('{customerId}/adresses', array('as' => 'adresses/customer', 'uses' => 'CustomersController@getAdresses'));
	});
	Route::get('deleted_customers',array('as' => 'deleted_customers', 'uses' => 'CustomersController@getDeletedUsers'));

	# Contents Management
	Route::group(array('prefix' => 'contents','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'contents', 'uses' => 'ContentsController@getIndex'));
		Route::get('create', array('as' => 'create/content', 'uses' => 'ContentsController@getCreate'));
		Route::post('create', 'ContentsController@postCreate');
		Route::get('{contentId}/edit', array('as' => 'update/content', 'uses' => 'ContentsController@getEdit'));
		Route::post('{contentId}/edit', 'ContentsController@postEdit');
		Route::get('{contentId}/delete', array('as' => 'delete/content', 'uses' => 'ContentsController@getDelete'));
		Route::get('{contentId}/confirm-delete', array('as' => 'confirm-delete/content', 'uses' => 'ContentsController@getModalDelete'));
		Route::get('{contentId}/restore', array('as' => 'restore/content', 'uses' => 'ContentsController@getRestore'));
		Route::get('{contentId}', array('as' => 'contents.show', 'uses' => 'ContentsController@show'));
	});

	# Slide Management
	Route::group(array('prefix' => 'slides','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'slides', 'uses' => 'SlidesController@getIndex'));
		Route::get('create', array('as' => 'create/slide', 'uses' => 'SlidesController@getCreate'));
		Route::post('create', 'SlidesController@postCreate');
		Route::get('{slideId}/edit', array('as' => 'update/slide', 'uses' => 'SlidesController@getEdit'));
		Route::post('{slideId}/edit', 'SlidesController@postEdit');
		Route::get('{slideId}/delete', array('as' => 'delete/slide', 'uses' => 'SlidesController@getDelete'));
		Route::get('{slideId}/confirm-delete', array('as' => 'confirm-delete/slide', 'uses' => 'SlidesController@getModalDelete'));
		Route::get('{slideId}/restore', array('as' => 'restore/slide', 'uses' => 'SlidesController@getRestore'));
		Route::get('{slideId}', array('as' => 'slides.show', 'uses' => 'SlidesController@show'));
	});

	# Social Management
	Route::group(array('prefix' => 'socials','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'socials', 'uses' => 'SocialsController@getIndex'));
		Route::get('create', array('as' => 'create/social', 'uses' => 'SocialsController@getCreate'));
		Route::post('create', 'SocialsController@postCreate');
		Route::get('{socialId}/edit', array('as' => 'update/social', 'uses' => 'SocialsController@getEdit'));
		Route::post('{socialId}/edit', 'SocialsController@postEdit');
		Route::get('{socialId}/delete', array('as' => 'delete/social', 'uses' => 'SocialsController@getDelete'));
		Route::get('{socialId}/confirm-delete', array('as' => 'confirm-delete/social', 'uses' => 'SocialsController@getModalDelete'));
		Route::get('{socialId}/restore', array('as' => 'restore/social', 'uses' => 'SocialsController@getRestore'));
		Route::get('{socialId}', array('as' => 'socials.show', 'uses' => 'SocialsController@show'));
	});

	# DiscountCodes Management
	Route::group(array('prefix' => 'discodes','before' => 'Sentry'), function () {
		Route::get('/', array('as' => 'discodes', 'uses' => 'DiscountCodesController@getIndex'));
		Route::get('create', array('as' => 'create/discode', 'uses' => 'DiscountCodesController@getCreate'));
		Route::post('create', 'DiscountCodesController@postCreate');
		Route::get('{discodeId}/edit', array('as' => 'update/discode', 'uses' => 'DiscountCodesController@getEdit'));
		Route::post('{discodeId}/edit', 'DiscountCodesController@postEdit');
		Route::get('{discodeId}/delete', array('as' => 'delete/discode', 'uses' => 'DiscountCodesController@getDelete'));
		Route::get('{discodeId}/confirm-delete', array('as' => 'confirm-delete/discode', 'uses' => 'DiscountCodesController@getModalDelete'));
		Route::get('{discodeId}/restore', array('as' => 'restore/discode', 'uses' => 'DiscountCodesController@getRestore'));
		Route::get('{discodeId}', array('as' => 'discodes.show', 'uses' => 'DiscountCodesController@show'));
	});

	# Picture Management
	Route::group(array('prefix' => 'pictures','before' => 'Sentry'), function () {
		Route::get('{picId}/edit', array('as' => 'crop/pic', 'uses' => 'PicturesController@getCropPic'));
		Route::post('{picId}/edit', 'PicturesController@postCropPic');
	});

	Route::post('changeStatus','MainController@changeStatus');
	Route::get('{name?}', 'MainController@showView');

});

#frontend views

Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect' ]
],
function()
{
	Route::get('/', array('as' => 'home', 'uses' => 'FrontController@getIndex'));
	Route::get('urunler/{url?}', array('as' => 'urunler', 'uses' => 'frontCategoriesController@index'));
	Route::get('urun/{url?}', array('as' => 'urun', 'uses' => 'frontProductsController@index'));
	Route::post('urun/{url?}','frontProductsController@postReview');

	Route::get('sepet', array('as' => 'sepet', 'uses' => 'frontProductsController@showCart'));
	Route::post('sepet','frontProductsController@updateCart');

	Route::get('siparis/{url?}', array('as' => 'siparis', 'uses' => 'frontOrdersController@index'));
	Route::post('siparis/{url?}','frontOrdersController@saveOrder');
	Route::get('siparis/{id}/odeme', array('as' => 'odeme/siparis', 'uses' => 'frontOrdersController@getOdeme'));
	Route::post('siparis/{id}/odeme', 'frontOrdersController@postOdeme');

	Route::get('results', 'SearchController@index');

	Route::get('giris', array('as' => 'giris','uses' => 'frontCustomersController@getSignin'));
	Route::post('giris','frontCustomersController@postSignin');
	Route::get('kayit', array('as' => 'kayit','uses' => 'frontCustomersController@getSignup'));
	Route::post('kayit','frontCustomersController@postSignup');
	Route::get('giris/{provider}', array('uses' => 'frontCustomersController@getLoginSocial'));
	Route::get('kayit/{provider}', array('uses' => 'frontCustomersController@getHandleSocial'));
	Route::get('sifre-hatirlatma', array('as' => 'sifre-hatirlatma','uses' => 'frontCustomersController@getForgotPassword'));
	Route::post('sifre-hatirlatma','frontCustomersController@postForgotPassword');
	Route::get('sifre-hatirlatma/{passwordResetCode}', array('as' => 'sifre-hatirlatma-aktivasyon', 'uses' => 'frontCustomersController@getForgotPasswordConfirm'));
	Route::post('sifre-hatirlatma/{passwordResetCode}', 'AuthController@postForgotPasswordConfirm');
	Route::get('cikis', array('as' => 'cikis','uses' => 'frontCustomersController@LogOut'))->after('invalidate-browser-cache');
	Route::filter('invalidate-browser-cache', function($request, $response)
	{
		$response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
		$response->headers->set('Pragma','no-cache');
		$response->headers->set('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
	});

	Route::get('iyzico', array('as' => 'iyzico', 'uses' => 'FrontController@getIyzico'));
	Route::get('/{id}', array('as' => 'icerik', 'uses' => 'FrontController@getContent'));

	Route::group(array('prefix' => 'uye', 'before' => 'auth'), function () {
		Route::get('profil', array('as' => 'profil', 'uses' => 'frontAccountController@getProfile'));
		Route::post('profil','frontAccountController@postProfile');

		Route::get('favoriler', array('as' => 'favoriler', 'uses' => 'frontAccountController@getFavorites'));
		Route::post('favoriler','frontAccountController@delFavorites');
		Route::group(array('prefix' => 'siparisler'), function () {
			Route::get('/', array('as' => 'siparisler', 'uses' => 'frontAccountController@getOrders'));
			Route::get('{siparisId}', array('as' => 'siparisler.show', 'uses' => 'frontAccountController@showOrder'));
			Route::get('{siparisId}/delete', array('as' => 'delete/siparis', 'uses' => 'frontAccountController@getCancelOrder'));
			Route::get('{siparisId}/confirm-delete', array('as' => 'confirm-delete/siparis', 'uses' => 'frontAccountController@getModalCancelOrder'));
		});
		Route::group(array('prefix' => 'adresler'), function () {
			Route::get('/', array('as' => 'adresler', 'uses' => 'frontAccountController@getAddresses'));
			Route::post('/', 'frontAccountController@postCreateAddress');
			Route::get('{adresId}/edit', array('as' => 'update/adres', 'uses' => 'frontAccountController@getEditAddress'));
			Route::post('{adresId}/edit', 'frontAccountController@postEditAddress');
			Route::get('{adresId}/delete', array('as' => 'delete/adres', 'uses' => 'frontAccountController@getAdrDelete'));
			Route::get('{adresId}/confirm-delete', array('as' => 'confirm-delete/adres', 'uses' => 'frontAccountController@getModalAdrDelete'));
		});

	});

});

Route::post('addCart','frontProductsController@postCart');
Route::post('delCart','frontProductsController@delCart');
Route::post('editTranslation','TranslationsController@ajaxUpdate');
Route::post('islem','FrontController@islemler');