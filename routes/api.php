<?php

use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\NewPasswordController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetLinkController;
use App\Http\Controllers\Api\V1\Auth\RegistrationController;
use App\Http\Controllers\Api\V1\Auth\VerifyEmailController;
use App\Http\Controllers\Api\V1\BillController;
use App\Http\Controllers\Api\V1\BusinessTypeController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\GlobalAddressController;
use App\Http\Controllers\Api\V1\InventoryAdjustmentController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\LocationController;
use App\Http\Controllers\Api\V1\MediaController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\PurchaseController;
use App\Http\Controllers\Api\V1\PurchaseItemController;
use App\Http\Controllers\Api\V1\SaleController;
use App\Http\Controllers\Api\V1\SupplierController;
use App\Http\Controllers\Api\V1\TestimonialController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\UserPlanFeatureController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout.api');
});

Route::middleware(['auth:api', 'verified'])->group(function () {

    Route::group(['prefix' => 'v1'], function () {
        //account
        Route::POST('accounts', [AccountController::class, 'store'])->name('account.store');
        Route::GET('accounts', [AccountController::class, 'index'])->name('accounts.index');
        Route::PUT('accounts/{uuid}', [AccountController::class, 'update'])->name('accounts.update');
        Route::PUT('accounts/{uuid}/user', [AccountController::class, 'updateUserAccount'])->name('user.accounts.update');
        Route::PUT('accounts/{uuid}/businesstype', [AccountController::class, 'storeAccountBusinessType'])->name('accounts.businesstype');

        //user
        //Route::POST('user/create', [UserController::class,'updateOrCreate'])->name('user.create');
        Route::PUT('users/{uuid}', [UserController::class, 'update'])->name('user.update');
        Route::GET('users', [UserController::class, 'users'])->name('users');
        Route::GET('user/{uuid}', [UserController::class, 'user'])->name('user');

        //supplier
        Route::POST('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
        Route::GET('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
        Route::GET('suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
        Route::DELETE('suppliers/{supplier}', [SupplierController::class, 'delete'])->name('suppliers.delete');
        Route::post('suppliers/store', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::PUT('suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
        Route::GET('suppliers/{supplier}/addresses', [SupplierController::class, 'getAddresses'])->name('suppliers.addresses');
        Route::GET('suppliers/{supplier}/contacts', [SupplierController::class, 'getContacts'])->name('suppliers.contacts');
        //customer
        Route::POST('customers/create', [CustomerController::class, 'create'])->name('customer.create');
        Route::GET('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::GET('customers/{customer}', [CustomerController::class, 'show'])->name('customer.show');
        Route::DELETE('customers/{customer}', [CustomerController::class, 'delete'])->name('customers.delete');
        Route::POST('customers', [CustomerController::class, 'store'])->name('customer.store');
        Route::PUT('customers/{customer}', [CustomerController::class, 'update'])->name('customer.update');
        Route::GET('customers/{customer}/addresses', [CustomerController::class, 'getAddresses'])->name('customers.addresses');
        Route::GET('customers/{customer}/contacts', [CustomerController::class, 'getContacts'])->name('customers.contacts');
        //address
        //Route::POST('set/address', [AddressController::class,'setAddress'])->name('setaddress');
        Route::POST('addresses/create', [AddressController::class, 'create'])->name('addresses.create');
        Route::PUT('addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
        Route::GET('addresses', [AddressController::class, 'index'])->name('addresses.index');
        Route::GET('addresses/{address}', [AddressController::class, 'show'])->name('addresses.show');
        Route::DELETE('addresses/{address}', [AddressController::class, 'delete'])->name('addresses.delete');

        //contacts
        Route::POST('contacts/create', [ContactController::class, 'create'])->name('contacts.create');
        Route::PUT('contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
        Route::GET('contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::GET('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
        Route::DELETE('contacts/{contact}', [ContactController::class, 'delete'])->name('contacts.delete');

        //global Address
        Route::GET('global/addresses', [GlobalAddressController::class, 'index'])->name('global.addresses.index');

        //Purchase
        Route::GET('purchases', [PurchaseController::class, 'index'])->name('purchases.index');
        Route::POST('purchases', [PurchaseController::class, 'store'])->name('purchases.store');
        Route::PUT('purchases/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');
        Route::GET('purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
        Route::DELETE('purchases/{purchase}', [PurchaseController::class, 'delete'])->name('purchases.delete');
        //purchase item
        Route::get('purchaseitems/serialnumber/{serialNumber}', [PurchaseItemController::class, 'showBySerialNumber'])->name('purchasesItems.serialNumber');
        Route::DELETE('purchaseitems/{purchaseitem}', [PurchaseItemController::class, 'delete'])->name('purchasesItems.delete');
        //sales
        Route::GET('sales', [SaleController::class, 'index'])->name('sales.index');
        Route::POST('sales', [SaleController::class, 'store'])->name('sales.store');
        Route::PUT('sales/{sale}', [SaleController::class, 'update'])->name('sales.update');
        Route::GET('sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
        Route::DELETE('sales/{sale}', [SaleController::class, 'delete'])->name('sales.delete');
        Route::DELETE('saleitems/{sale}', [SaleController::class, 'deleteSaleItem'])->name('saleitems.delete');

        //inventory adjustment
        Route::POST('inventory/adjustment', [InventoryAdjustmentController::class, 'store'])->name('inventory.adjustment.store');

        //Purchase
        // Route::GET('businesstypes', [BusinessTypeController::class, 'index'])->name('businesstypes.index');
        Route::POST('businesstypes', [BusinessTypeController::class, 'store'])->name('businesstypes.store');
        Route::PUT('businesstypes/{businesstype}', [BusinessTypeController::class, 'update'])->name('businesstypes.update');
        Route::GET('businesstypes/{businesstype}', [BusinessTypeController::class, 'show'])->name('businesstypes.show');
        Route::DELETE('businesstypes/{businesstype}', [BusinessTypeController::class, 'delete'])->name('businesstypes.delete');

        //account plan feature
        Route::POST('user/plan/features', [UserPlanFeatureController::class, 'store'])->name('businesstypes.store');

        //bill
        Route::GET('bills', [BillController::class, 'index'])->name('bills.index');
        Route::POST('bills', [BillController::class, 'store'])->name('bills.store');
        Route::PUT('bills/{shortCode}', [BillController::class, 'update'])->name('bills.update');
        Route::DELETE('bills/{uuid}', [BillController::class, 'delete'])->name('bills.delete');
        Route::GET('bills/{uuid}', [BillController::class, 'show'])->name('bills.show');
        // Route::PUT('bills/{bill}', [BillController::class, 'update'])->name('bills.update');

        //payments

        //bill
        Route::GET('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::POST('payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::PUT('payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
        Route::DELETE('payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.delete');
        Route::GET('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    });
});

//open api

Route::group(['prefix' => 'v1'], function () {
    Route::GET('businesstypes', [BusinessTypeController::class, 'index'])->name('businesstypes.index');
    Route::GET('features/plan', [PlanFeatureController::class, 'featurePlan'])->name('feature.plan');
    Route::GET('plans/feature', [PlanFeatureController::class, 'planFeature'])->name('plan.feature');
    Route::GET('plans', [PlanFeatureController::class, 'plans'])->name('plans');
    Route::GET('prices/plan', [PlanFeatureController::class, 'pricePlan'])->name('price.plan');
    Route::GET('plans/pricetype', [PlanFeatureController::class, 'planPrice'])->name('plan.price');


    Route::GET('testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    ///invoice
    Route::POST('/invoice', [InvoiceController::class, 'createPublicInvoice'])->name('invoices.store');
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    // Route::POST('/invoices/media', [InvoiceController::class, 'invoiceMedia'])->name('invoices.media');
    Route::PUT('/invoice/{shortCode}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::get('invoices/{shortCode}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('invoices/{shortCode}/download', [InvoiceController::class, 'downloadInvoicePdf'])->name('invoices.download');
    Route::get('invoices/{shortCode}/createPdf', [InvoiceController::class, 'createInvoicePdf'])->name('invoices.pdf.create');
    Route::get('invoices/notification/{shortCode}', [InvoiceController::class, 'notification'])->name('invoice.notification');
    //location api
    Route::GET('countries', [CountryController::class, 'index'])->name('countries.index');
    Route::GET('states', [LocationController::class, 'states'])->name('location.states');
    Route::GET('districts', [LocationController::class, 'districts'])->name('location.districts');

    //media
    Route::POST('/media', [MediaController::class, 'store'])->name('media.store');
    Route::DELETE('/media/{media_id}/{attachment_id}', [MediaController::class, 'destroy'])->name('media.destroy');
    Route::POST('/attachements', [MediaController::class, 'storeMediaAttachement'])->name('attachements.store');
});

//guest api
Route::middleware(['guestApi'])->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email')->middleware(['guestApi']);

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset')->middleware(['guestApi']);

        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store')->middleware(['guestApi']);
    });
    Route::POST('login', [LoginController::class, 'login'])->name('login.api');
    Route::POST('register', [RegistrationController::class, 'register'])->name('register.api');
});

//end guest api

//email verification
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])

    ->middleware(['auth:api', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth:api', 'throttle:6,1'])
    ->name('verification.send');

//end verification