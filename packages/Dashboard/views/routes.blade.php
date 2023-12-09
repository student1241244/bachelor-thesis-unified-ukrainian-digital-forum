/*
|--------------------------------------------------------------------------
| {{ $packageName }} Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(
    [
        'prefix'     => \Packages\Dashboard\App\Services\Route\RouteService::getPrefix(),
        'middleware' => ['web', 'userActive', 'permission'],
        'namespace'  => '{{ $packageName }}\Controllers',
        'as'         => '{{ $packageNameSnake }}.'
    ],
    function () {
{!! $routes !!}
    });
