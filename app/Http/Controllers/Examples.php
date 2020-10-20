<?php
//Example 1-2 - Didn't work
namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    public function index()
    {
        return 'Hello, World!';
    }
}

// Page 35 Apply middleware in controllers
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin-auth')
            ->only('editUsers');
        $this->middleware('team-member')
            ->except('editUsers');
    }
}

//Ex 3-21 Default Controller

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
}

//Ex 3-22 Simple Controller
namespace App\Http\Controllers;

class TaskController extends Controller
{
    public function index()
    {
        return 'Hello, World!';
    }
}

//Ex 3-23 Route to above simple controller, will be in the web.php file in routes
Route::get('/', 'TaskController@index');

//Ex 3-24 Controller method
...
public function index()
{
    return view('tasks.index')
        ->with('tasks', Task::all());
}

//Ex 3-25 Route form actions, will go in web.php file in routes
Route::get('tasks/create', 'TaskController@create');
Route::post('tasks', 'TaskController@store');

//Ex 3-26 Controller for form input
...
public function store()
{
    Task::create(request()->only(['title', 'description']));
    return redirect('tasks');
}

//Explaination of above code
request()->only(['title', 'description']);
// returns:
[
    'title' => 'Whatever title the user typed on the previous page',
    'description' => 'Whatever description the user typed on the previous page',
];

Task::create([
    'title' => 'Buy milk',
    'description' => 'Remember to check the expiration date this time, Norbert!',
]);

//Ex 3-27 Controller method injection with typehinting
public function store(\Illuminate\Http\Request $request)
{
    Task::create($request->only(['title', 'description']));
    return redirect('tasks');
}

//Ex 3-30 invoke() method
// \App\Http\Controllers\UpdateUserAvatar.php
public function __invoke(User $user)
{
// Update the user's avatar image
}
// routes/web.php
Route::post('users/{user}/update-avatar', 'UpdateUserAvatar');
