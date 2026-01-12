<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\HomeSliderController;
use App\Http\Controllers\Backend\SiteSettingsController;
use App\Http\Controllers\Backend\CompanySettingsController;
use App\Http\Controllers\Backend\SocialMediaSettingController;
use App\Http\Controllers\Backend\HomeCardController;
use App\Http\Controllers\Backend\MenusController;
use App\Http\Controllers\Backend\ClientsController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\EmailSetingsController;
use App\Http\Controllers\Backend\GoogleSettingController;
use App\Http\Controllers\Backend\CountryController;
use App\Http\Controllers\Backend\HomeKayitController;
use App\Http\Controllers\Backend\ToursController;
use App\Http\Controllers\Backend\GuidesController;
use App\Http\Controllers\Backend\CommentController;
use App\Http\Controllers\Frontend\KullaniciController;
use App\Http\Controllers\Backend\LanguagesController;
use App\Http\Controllers\Frontend\GuideController;
use App\Http\Controllers\Frontend\TurController;
use App\Http\Controllers\Frontend\RehberController;
use App\Http\Controllers\Frontend\IletisimController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\ActivityController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\UserImagesController;
use App\Http\Controllers\Frontend\BecomeGuideController;
use App\Http\Controllers\Frontend\TripController;
use App\Http\Controllers\Backend\MyTripController;
use App\Http\Controllers\Frontend\MessagesController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Frontend\IyzipayController;
use App\Http\Controllers\Backend\GuideActivityController;
use App\Http\Controllers\Backend\ComplaintsController;
use App\Http\Controllers\Frontend\VerificationController;
use App\Http\Controllers\Frontend\ForgotPasswordController;
use App\Http\Controllers\Frontend\GoogleAuthController;
use App\Http\Controllers\Frontend\FacebookAuthController;
use App\Http\Controllers\Frontend\VkontakteController;

//Admin giriş yaptıktan sonra göreceği sayfa yönlendirmesi
Route::get('/secure', function () {
    return view('backend.index');
})->middleware(['auth', 'verified', 'role:admin'])->name('dashboard');


//Admin login logout routes
Route::controller(UserController::class)->group(function () {
    //Route::get('/register', 'register')->name('register');
    //Route::post('/register', 'register_action')->name('register.action');

    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'login_action')->name('login.action');
});


Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/logout', 'destroy')->name('admin.logout');
        Route::get('/admin/profile', 'Profile')->name('admin.profile');
        Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
        Route::post('/store/profile', 'StoreProfile')->name('store.profile');
    });
});

//Anasayfa Slider
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(HomeSliderController::class)->group(function () {
        Route::get('/home/image', 'HomeImage')->name('home.image');
        Route::get('/add/slide', 'AddSlide')->name('add.slide');
        Route::post('/store/slide', 'StoreSlide')->name('store.slide');
        Route::get('/edit/slide/{id}', 'EditSlide')->name('edit.slide');
        Route::post('/update/slide', 'UpdateSlide')->name('update.slide');
        Route::get('/delete/slide/{id}', 'DeleteSlide')->name('delete.slide');

    });
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(SettingsController::class)->group(function () {
        Route::get('/site/settings', 'SiteSettings')->name('site.settings');
        Route::post('/update/site/settings', 'UpdateSiteSettings')->name('update.site.settings');

        Route::get('/email/settings', 'EmailSettings')->name('email.settings');
        Route::post('/update/email/settings', 'UpdateEmailSettings')->name('update.email.settings');

        Route::get('/google/settings', 'GoogleSettings')->name('google.settings');
        Route::post('/update/google/settings', 'UpdateGoogleSettings')->name('update.google.settings');

        Route::get('/company/settings', 'CompanySettings')->name('company.settings');
        Route::post('/update/company/settings', 'UpdateCompanySettings')->name('update.company.settings');

        Route::get('/social/media/settings', 'SocialMediaSettings')->name('social.media.settings');
        Route::post('/update/socialmedia/settings', 'UpdateSocialMediaSettings')->name('update.socialmedia.settings');
    });
});



//Anasayfa servislerimiz bölümü
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(HomeCardController::class)->group(function () {
        Route::get('/all/home/card', 'AllHomeCard')->name('all.home.card');
        Route::get('/add/home/card', 'AddHomeCard')->name('add.home.card');
        Route::post('/store/home/card', 'StoreHomeCard')->name('store.home.card');
        Route::get('/edit/home/card/{id}', 'EditHomeCard')->name('edit.home.card');
        Route::post('/update/home/card/{id}', 'UpdateHomeCard')->name('update.home.card');
        Route::get('/delete/home/card/{id}', 'DeleteHomeCard')->name('delete.home.card');
    });
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(MenusController::class)->group(function () {
        Route::get('/all/menus', 'AllMenus')->name('all.menus');
        Route::get('/add/menus', 'AddMenus')->name('add.menus');
        Route::post('/store/menus', 'StoreMenus')->name('store.menus');
        Route::get('/edit/menus/{id}', 'EditMenus')->name('edit.menus');
        Route::post('/update/menus/{id}', 'UpdateMenus')->name('update.menus');
        Route::get('/delete/menus/{id}', 'DeleteMenus')->name('delete.menus');
    });
});

//Şirket müşteri yorumları kısmı
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(ClientsController::class)->group(function () {
        Route::get('/all/client', 'AllClient')->name('all.client');
        Route::get('/add/client', 'AddClient')->name('add.client');
        Route::post('/store/client', 'StoreClient')->name('store.client');
        Route::get('/edit/client/{id}', 'EditClient')->name('edit.client');
        Route::post('/update/client', 'UpdateClient')->name('update.client');
        Route::get('/delete/client/{id}', 'DeleteClient')->name('delete.client');

    });
});

//İletişim sayfası
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(ContactController::class)->group(function () {
        Route::get('/contact/message', 'ContactMessage')->name('contact.message');
        Route::get('/delete/message/{id}', 'DeleteMessage')->name('delete.message');
    });
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(MyTripController::class)->group(function () {
        Route::get('/trips/all', 'TripsAll')->name('trips.all');
        Route::get('/delete/admin/trips/{id}', 'DeleteTrips')->name('delete.admin.trips');

    });
});

//Sayfa ayarları
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(PagesController::class)->group(function () {
        Route::get('/pages', 'Pages')->name('pages');
        Route::get('/pages/home', 'PagesHome')->name('pages.home');
        Route::post('/update/pages/home', 'UpdatePagesHome')->name('update.pages.home');

        Route::get('/pages/tour', 'PagesTour')->name('pages.tour');
        Route::post('/update/pages/tour', 'UpdatePagesTour')->name('update.pages.tour');

        Route::get('/pages/guide', 'PagesGuide')->name('pages.guide');
        Route::post('/update/pages/guide', 'UpdatePagesGuide')->name('update.pages.guide');

        Route::get('/pages/contact', 'PagesContact')->name('pages.contact');
        Route::post('/update/pages/contact', 'UpdatePagesContact')->name('update.pages.contact');
    });
});

//Anasayfa popüler varış noktaları routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(CountryController::class)->group(function () {
        Route::get('/all/destination', 'AllDestination')->name('all.destination');
        Route::get('/add/destination', 'AddDestination')->name('add.destination');
        Route::post('/store/destination', 'StoreDestination')->name('store.destination');
        Route::get('/edit/destination/{id}', 'EditDestination')->name('edit.destination');
        Route::post('/update/destination', 'UpdateDestination')->name('update.destination');
        Route::get('/delete/destination/{id}', 'DeleteDestination')->name('delete.destination');

    });
});

//Anasayfa popüler varış noktaları routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(CityController::class)->group(function () {
        Route::get('/all/cities', 'AllCities')->name('all.cities');
        Route::get('/add/cities', 'AddCities')->name('add.cities');
        Route::post('/store/cities', 'StoreCities')->name('store.cities');
        Route::get('/edit/cities/{id}', 'EditCities')->name('edit.cities');
        Route::post('/update/cities', 'UpdateCities')->name('update.cities');
        Route::get('/delete/cities/{id}', 'DeleteCities')->name('delete.cities');

    });
});

//Rehber Kayıt olma kısmı
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(HomeKayitController::class)->group(function () {
        Route::get('/home/kayit', 'HomeKayit')->name('home.kayit');
        Route::post('/update/home/kayit', 'UpdateHomeKayit')->name('update.home.kayit');
    });
});

//Turlar kısmı
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(ToursController::class)->group(function () {
        Route::get('/all/tours', 'AllTours')->name('all.tours');
        Route::get('/add/tours', 'AddTours')->name('add.tours');
        Route::post('/store/tours', 'StoreTours')->name('store.tours');
        Route::get('/edit/tours/{id}', 'EditTours')->name('edit.tours');
        Route::get('/program/tours/{id}', 'ProgramTours')->name('program.tours');
        Route::post('/update/program/tours', 'UpdateProgramTours')->name('update.program.tours');
        Route::post('/update/tours', 'UpdateTours')->name('update.tours');
        Route::get('/delete/tours/{id}', 'DeleteTours')->name('delete.tours');

    });
});

//Rehberler kısmı
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(GuidesController::class)->group(function () {
        Route::get('/all/guides', 'AllGuides')->name('all.guides');
        Route::get('/add/guides', 'AddGuides')->name('add.guides');
        Route::post('/store/guides', 'StoreGuides')->name('store.guides');
        Route::get('/edit/guides/{id}', 'EditGuides')->name('edit.guides');
        Route::post('/update/guides', 'UpdateGuides')->name('update.guides');
        Route::get('/delete/guides/{id}', 'DeleteGuides')->name('delete.guides');
        
        Route::get('/approve/{id}', 'ApproveGuides')->name('admin.approve');
        Route::get('/decline/{id}', 'DeclineGuides')->name('admin.decline');
    });
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(GuideActivityController::class)->group(function () {
        Route::get('user/online', 'UserOnline')->name('user.online');
        Route::get('/guide/online', 'GuideOnline')->name('guide.online');
    });
});

//Rehber yorumları kısmı
Route::controller(CommentController::class)->group(function () {
    Route::get('/comments/message/{id}', 'CommentsMessage')->name('comments.message')->middleware(['auth','role:admin']);
});




//Dil ekleme güncelleme silme kısmı
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(LanguagesController::class)->group(function () {
        Route::get('/all/languages', 'AllLanguages')->name('all.languages');
        Route::get('/add/languages', 'AddLanguages')->name('add.languages');
        Route::post('/store/languages', 'StoreLanguages')->name('store.languages');
        Route::get('/edit/languages/{id}', 'EditLanguages')->name('edit.languages');
        Route::post('/update/languages', 'UpdateLanguages')->name('update.languages');
        Route::get('/delete/languages/{id}', 'DeleteLanguages')->name('delete.languages');
    });
});

//Dil ekleme güncelleme silme kısmı
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(ActivityController::class)->group(function () {
        Route::get('/all/activity', 'AllActivity')->name('all.activity');
        Route::get('/add/activity', 'AddActivity')->name('add.activity');
        Route::post('/store/activity', 'StoreActivity')->name('store.activity');
        Route::get('/edit/activity/{id}', 'EditActivity')->name('edit.activity');
        Route::post('/update/activity', 'UpdateActivity')->name('update.activity');
        Route::get('/delete/activity/{id}', 'DeleteActivity')->name('delete.activity');
    });
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(UserImagesController::class)->group(function () {
        Route::get('/all/images/{id}', 'AllImages')->name('all.images');
        Route::get('/add/images/{id}', 'AddImages')->name('add.images');
        Route::post('/store/images', 'StoreImages')->name('store.images');
        Route::get('/edit/images/{id}', 'EditImages')->name('edit.images');
        Route::post('/update/images', 'UpdateImages')->name('update.images');
        Route::get('/delete/images/{id}', 'DeleteImages')->name('delete.images');
    });
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(ComplaintsController::class)->group(function() {
        Route::get('/all/complaints', 'AllComplaints')->name('all.complaints');
        Route::get('/complaint/processed/{id}', 'ComplaintProcessed')->name('complaint.processed');
        Route::get('/complaint/notprocessed/{id}', 'ComplaintNotProcessed')->name('complaint.notprocessed');

    });
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'Index')->name('home');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/terms/of/service', 'TermsofUse')->name('terms.of.use');
    Route::get('/privacy/policy', 'PrivacyPolicy')->name('privacy.policy');
    Route::get('/cookies', 'Cookies')->name('cookies');
    Route::get('/security', 'Security')->name('security');
});


//User giriş çıkış profil bilgileri kısmı
Route::controller(KullaniciController::class)->group(function () {
    Route::post('/action/register', 'register_action')->name('user.register');

    Route::post('/action/login', 'login_user')->name('user.login');

    Route::get('/user/logout', 'destroy')->name('user.logout');
    Route::get('/user/profile', 'UserProfile')->name('user.profile')->middleware(['userAuth','is_verify_email']);
    Route::post('/update/user', 'UpdateUser')->name('update.user')->middleware('userAuth');

    Route::get('/local/user/details/{username}', 'LocalUserDetails')->name('local.user.details')->middleware('userAuth');
    Route::get('account/verify/{token}', 'verifyAccount')->name('user.verify');

});



Route::controller(GuideController::class)->group(function () {
    Route::post('/guide/register', 'GuideRegister')->name('guide.register');
    Route::get('/guide/register/create', 'GuideRegisterCreate')->name('guide.register.create');
    
    Route::get('/guide/register/step=1', 'GuideStep1')->name('guide.register.step1');
    Route::post('/update/guide/register/step=1', 'UpdateGuideStep1')->name('update.guide.register.step1');

    Route::get('/guide/register/step=2', 'GuideStep2')->name('guide.register.step2');
    Route::post('/update/guide/register/step=2', 'UpdateGuideStep2')->name('update.guide.register.step2');

    Route::get('/guide/register/step=3', 'GuideStep3')->name('guide.register.step3');
    Route::post('/update/guide/register/step=3', 'UpdateGuideStep3')->name('update.guide.register.step3');

    Route::get('/guide/register/step=4', 'GuideStep4')->name('guide.register.step4');
    Route::post('/update/guide/register/step=4', 'UpdateGuideStep4')->name('update.guide.register.step4');

    Route::get('/guide/register/step=5', 'GuideStep5')->name('guide.register.step5');
    Route::post('/update/guide/register/step=5', 'UpdateGuideStep5')->name('update.guide.register.step5');

    Route::post('/delete/guide/image', 'DeleteGuideImage2')->name('delete.guide.image2');

    Route::get('/guide/register/step=6', 'GuideStep6')->name('guide.register.step6');
    Route::post('/update/guide/register/step=6', 'UpdateGuideStep6')->name('update.guide.register.step6');

    Route::post('/guide/register/complete', 'GuideRegisterComplete')->name('guide.register.complete');
    Route::get('account/verify/{token}', 'verifyAccount')->name('user.verify');

    Route::get('/guide/profile', 'GuideProfile')->name('guide.profile')->middleware('userAuth');
    Route::post('/guide/update/profile1', 'GuideUpdateProfile1')->name('guide.update.profile1')->middleware('userAuth');
    Route::get('/guide/profile2', 'GuideProfile2')->name('guide.profile2')->middleware('userAuth');
    Route::post('/guide/update/profile2', 'GuideUpdateProfile2')->name('guide.update.profile2')->middleware('userAuth');
    Route::get('/guide/profile3', 'GuideProfile3')->name('guide.profile3')->middleware('userAuth');
    Route::post('/guide/update/profile3', 'GuideUpdateProfile3')->name('guide.update.profile3')->middleware('userAuth');
    Route::get('/guide/profile4', 'GuideProfile4')->name('guide.profile4')->middleware('userAuth');
    Route::post('/guide/update/profile4', 'GuideUpdateProfile4')->name('guide.update.profile4')->middleware('userAuth');
    Route::get('/guide/profile5', 'GuideProfile5')->name('guide.profile5')->middleware('userAuth');
    Route::post('/guide/update/profile5', 'GuideUpdateProfile5')->name('guide.update.profile5')->middleware('userAuth');
    Route::get('/guide/profile6', 'GuideProfile6')->name('guide.profile6')->middleware('userAuth');
    Route::post('/guide/update/profile6', 'GuideUpdateProfile6')->name('guide.update.profile6')->middleware('userAuth');
    Route::get('/guide/profile7', 'GuideProfile7')->name('guide.profile7')->middleware('userAuth');
    Route::post('/guide/update/profile7', 'GuideUpdateProfile7')->name('guide.update.profile7');
    Route::post('/delete/user/image/{id}', 'DeleteUserImage')->name('delete.user.image');

    Route::get('/get-cities/{countryId}', 'getCitiesByCountry')->name('get.cities');

});

//Frontend de turlar sayfası
Route::controller(TurController::class)->group(function () {
    Route::get('/tours', 'ToursPage')->name('tours');
    Route::get('/tours/details/{id}', 'ToursDetails')->name('tours.details');
});

//Frontend de rehberler sayfası
Route::controller(RehberController::class)->group(function () {
    Route::get('/guides', 'GuidePage')->name('guides');
    Route::get('/guides/details/{username}', 'GuideDetails')->name('guides.details');
});

Route::controller(CommentController::class)->group(function () {
    // Route::get('/comments', 'Comments')->name('comments');
    Route::post('/store/comments', 'StoreComments')->name('store.comments');
    Route::get('/delete/comments/{id}', 'DeleteComments')->name('delete.comments');
});

//Frontend de iletişim sayfası
Route::controller(IletisimController::class)->group(function () {
    Route::get('/contact', 'ContactPage')->name('contact');
    Route::post('/store/message', 'StoreMessage')->name('store.message');
});

Route::middleware(['userAuth', 'completeProfile'])->group(function () {
Route::controller(TripController::class)->group(function () {
    Route::get('/my-trips', 'TripsPage')->name('my.trips');
    Route::post('/update/my-trips', 'UpdateTrips')->name('update.trips');
    Route::get('/delete/trips/{id}', 'DeleteTrips')->name('delete.trips');

    Route::get('/view/trips', 'ViewTrips')->name('view.trips');
});
});

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('/forgot-password', 'SubmitForgotPassword')->name('forgot.password.post');
    Route::get('/reset-password/{token}', 'ShowResetPassword')->name('reset.password.get');
    Route::post('/reset-password', 'SubmitResetPassword')->name('reset.password.post');
});

Route::controller(GoogleAuthController::class)->group(function () {
    Route::get('/google/auth', 'GoogleAuth')->name('google.auth');
    Route::get('/google/callback', 'GoogleCallback');

});

Route::controller(FacebookAuthController::class)->group(function() {
    Route::get('/facebook/auth', 'FacebookAuth')->name('facebook.auth');
    Route::get('/auth/facebook/callback', 'FacebookCallback');
});

Route::controller(VkontakteController::class)->group(function() {
    Route::get('/vkontakte/auth', 'VkontakteAuth')->name('vkontakte.auth');
    Route::get('/auth/vkontakte/callback', 'VkontakteCallback');
});


Route::middleware(['userAuth', 'completeProfile'])->group(function () {
Route::controller(MessagesController::class)->group(function () {
    Route::get('/my-messages/details/{id}', 'MyMessagesDetails')->name('my.messages.details');
    Route::get('/my-messages', 'MyMessages')->name('my.messages');

    Route::post('/send/message', 'SendMessage')->name('send.message');

    Route::get('/check/messages', 'checkNewMessages')->name('check.messages');
    Route::post('/message-read', 'MessageAsRead')->name('message.read');

    Route::get('/get-messages', 'getMessages')->name('get.messages');

    Route::get('/delete/chats/{id}', 'DeleteChats')->name('delete.chats');
    
    Route::post('/report/user', 'ReportUser')->name('report.user');
});
});

Route::controller(IyzipayController::class)->group(function () {
    Route::get('iyzipay', 'Iyzipay')->name('iyzipay');
    Route::get('iyzipay/pay', 'Pay')->name('iyzipay.pay');
    Route::get('iyzipay/success', 'IyzipaySuccess')->name('iyzipay.success');
    Route::get('iyzipay/error', 'IyzipayError')->name('iyzipay.error');
});
