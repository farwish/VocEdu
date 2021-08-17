<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('categories', 'CategoryController');
    $router->resource('chapters', 'ChapterController');
    $router->resource('packages', 'PackageController');
    $router->resource('suites', 'SuiteController');
    $router->resource('papers', 'PaperController');
    $router->resource('questions', 'QuestionController');
    $router->resource('tabs', 'TabController');
    $router->resource('articles', 'ArticleController');
    $router->resource('videos', 'VideoController');
    $router->resource('patterns', 'PatternController');
    $router->resource('app-menus', 'AppMenuController');
});
