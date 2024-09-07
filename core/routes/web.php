<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{id}', 'replyTicket')->name('reply');
    Route::post('close/{id}', 'closeTicket')->name('close');
    Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
});

// Cart Category
Route::controller('CartController')->prefix('cart')->name('cart.')->group(function () {
    Route::get('/view', 'cart')->name('cart');
    Route::post('add-to-cart', 'addToCart')->name('add');
    Route::post('remove', 'remove')->name('remove');
    Route::post('update', 'update')->name('update');
    Route::get('get-cart-total', 'getCartTotal')->name('getCartTotal');
});


Route::controller('SiteController')->group(function () {
   
    Route::get('pages/{slug}', 'pages')->name('pages');
    Route::get('/contact', 'contact')->name('contact');

    Route::post('/contact', 'contactSubmit');

    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('blogs', 'blog')->name('blogs');

    Route::get('blog/{slug}', 'blogDetails')->name('blog.details');

    Route::get('policy/{slug}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->withoutMiddleware('maintenance')->name('placeholder.image');

    Route::get('maintenance-mode','maintenance')->withoutMiddleware('maintenance')->name('maintenance');
    Route::get('/category/{slug}', 'categoryProduct')->name('category.products');
    Route::get('all/categories', 'categories')->name('all.category');
    Route::get('/product/{id}', 'productDetails')->name('product.details');
    Route::get('all/search', 'search')->name('search');
    Route::get('/', 'index')->name('home');

});
