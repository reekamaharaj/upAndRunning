<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Up & Running Code samples Chapter 3
|--------------------------------------------------------------------------
|
| Saving the code samples and trying them when possible
|theses are for the web.php file
*/

//Ex 3-2 - Views used aren't created...
Route::get('/', function () {
    return view('welcome');
});
Route::get('about', function () {
    return view('about');
});
Route::get('products', function () {
    return view('products');
});
Route::get('services', function () {
    return view('services');
});

//Ex 3-3 - Route Verbs
Route::get('/', function () {
    return 'Hello, World!';
});
Route::post('/', function () {
    // Handle someone sending a POST request to this route
});
Route::put('/', function () {
    // Handle someone sending a PUT request to this route
});
Route::delete('/', function () {
    // Handle someone sending a DELETE request to this route
});
Route::any('/', function () {
    // Handle any verb request to this route
});
Route::match(['get', 'post'], '/', function () {
    // Handle GET or POST requests to this route
});

// Ex 3-5 - Route Parameters
Route::get('users/{id}/friends', function ($id) {
    //
});

//Ex 3-6 Optional Route Parameters
Route::get('users/{id?}', function ($id = 'fallbackId') {
    //
});

//Ex 3-7 Regular expression route constraints
Route::get('users/{id}', function ($id) {
    //
})->where('id', '[0-9]+');
Route::get('users/{username}', function ($username) {
    //
})->where('username', '[A-Za-z]+');
Route::get('posts/{id}/{slug}', function ($id, $slug) {
    //
})->where(['id' => '[0-9]+', 'slug' => '[A-Za-z]+']);

//Ex 3-8 url() helper
// a href="<?php echo url('/');"
//(took out <> and the closing php tag)
// Outputs <a href="http://myapp.com/">

//Ex 3-9 Defining route names
// Defining a route with name() in routes/web.php:
Route::get('members/{id}', 'MemberController@show')->name('members.show');
// Linking the route in a view using the route() helper:
// a href="<?php echo route('members.show', ['id' => 14]);"
//(took out <> and the closing php tag)

//Page 30 Laravel 5.1 custom route names
Route::get('members/{id}', [
    'as' => 'members.show',
    'uses' => 'MemberController@show',
]);

//Page 32 Pass parameters to route helper
route('users.comments.show', [1, 2]);
// http://myapp.com/users/1/comments/2

route('users.comments.show', ['userId' => 1, 'commentId' => 2]);
// http://myapp.com/users/1/comments/2

route('users.comments.show', ['commentId' => 2, 'userId' => 1]);
// http://myapp.com/users/1/comments/2

route('users.comments.show', ['userId' => 1, 'commentId' => 2, 'opt' => 'a']);
// http://myapp.com/users/1/comments/2?opt=a

//Ex 3-10 Define route group
Route::group(function () {
    Route::get('hello', function () {
        return 'Hello';
    });
    Route::get('world', function () {
        return 'World';
    });
});

// Ex 3-11 middleware, restrict
Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    });
    Route::get('account', function () {
        return view('account');
    });
});

//Page 34 Before 5.4
Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    });
    Route::get('account', function () {
        return view('account');
    });
});

//Ex 3-12 Rate limiting middleware to route
Route::middleware('auth:api', 'throttle:60,1')->group(function () {
    Route::get('/profile', function () {
        //
    });
});

//Ex 3-13 Prefix group of routes
Route::prefix('dashboard')->group(function () {
    Route::get('/', function () {
        // Handles the path /dashboard
    });
    Route::get('users', function () {
        // Handles the path /dashboard/users
    });
});

//Page 36 Fallback Routes
Route::any('{anything}', 'CatchAllController')->where('anything', '*');

//5.6+ Fallback
Route::fallback(function () {
    //
});

// Ex 3-14 Subdomain Routing
Route::domain('api.myapp.com')->group(function () {
    Route::get('/', function () {
        //
    });
});

//Ex 3-15 Parameterized subdomain
Route::domain('{account}.myapp.com')->group(function () {
    Route::get('/', function ($account) {
        //
    });
    Route::get('users/{id}', function ($account, $id) {
        //
    });
});

//Ex 3-16 Namespace Prefix
// App\Http\Controllers\UserController
Route::get('/', 'UserController@index');
Route::namespace('Dashboard')->group(function () {
    // App\Http\Controllers\Dashboard\PurchaseController
    Route::get('dashboard/purchases', 'PurchaseController@index');
});

//Ex 3-17 Name Prefix
Route::name('users.')->prefix('users')->group(function () {
    Route::name('comments.')->prefix('comments')->group(function () {
        Route::get('{id}', function () {
        })->name('show');
    });
});

//Page 39 Signing a Route
Route::get('invitations/{invitation}/{answer}', 'InvitationController')
    ->name('invitations');

// Generate a normal link
URL::route('invitations', ['invitation' => 12345, 'answer' => 'yes']);
// Generate a signed link
URL::signedRoute('invitations', ['invitation' => 12345, 'answer' => 'yes']);
// Generate an expiring (temporary) signed link
URL::temporarySignedRoute(
    'invitations',
    now()->addHours(4),
    ['invitation' => 12345, 'answer' => 'yes']
);

//Page 40 Allow signed links
Route::get('invitations/{invitation}/{answer}', 'InvitationController')
    ->name('invitations')
    ->middleware('signed');

class InvitationController
{
    public function __invoke(Invitation $invitation, $answer, Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(403);
        }
        //
    }
}

//Ex 3-18 view()
Route::get('/', function () {
    return view('home');
});

//Ex 3-19 Passing variables to views
Route::get('tasks', function () {
    return view('tasks.index')
        ->with('tasks', Task::all());
});

//Ex 3-20 Route::view()
// Returns resources/views/welcome.blade.php
Route::view('/', 'welcome');
// Passing simple data to Route::view()
Route::view('/', 'welcome', ['User' => 'Michael']);

//Page 42 Share variables with all views
view()->share('variableName', 'variableValue');

//Ex 3-28 Resource controller binding
Route::resource('tasks', 'TaskController');

//Ex 3-29 API resource controller binding
Route::apiResource('tasks', 'TaskController');

//Ex 3-31 Get resource for route
Route::get('conferences/{id}', function ($id) {
    $conference = Conference::findOrFail($id);
});

//Ex 3-32 implicit route model binding
Route::get('conferences/{conference}', function (Conference $conference) {
    return view('conferences.show')->with('conference', $conference);
});

//Ex 3-33 route model binding
public function boot()
{
    // Just allows the parent's boot() method to still run
    parent::boot();
    // Perform the binding
    Route::model('event', Conference::class);
}

//Ex 3-34 explicit route model binding
Route::get('events/{event}', function (Conference $event) {
    return view('events.show')->with('event', $event);
});
