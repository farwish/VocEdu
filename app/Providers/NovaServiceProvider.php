<?php

namespace App\Providers;

use App\Nova\Article;
use App\Nova\Category;
use App\Nova\Chapter;
use App\Nova\Exam;
use App\Nova\Member;
use App\Nova\Package;
use App\Nova\Paper;
use App\Nova\Pattern;
use App\Nova\Question;
use App\Nova\Suite;
use App\Nova\Tab;
use App\Nova\User;
use App\Nova\Video;
use DigitalCreative\CollapsibleResourceManager\CollapsibleResourceManager;
use DigitalCreative\CollapsibleResourceManager\Resources\ExternalLink;
use DigitalCreative\CollapsibleResourceManager\Resources\NovaResource;
use DigitalCreative\CollapsibleResourceManager\Resources\TopLevelResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::serving(function () {
            App::setLocale('zh_CN');
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            // new Help,
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new CollapsibleResourceManager([
                'disable_default_resource_manager' => true, // default
                'remember_menu_state' => false, // default
                'navigation' => [
                    TopLevelResource::make([
                        'label' => '类目管理',
                        'expanded' => null,
                        'badge' => null,
                        'icon' => null,
                        'linkTo' => null, // accepts an instance of `NovaResource` or a Nova `Resource::class`
                        'resources' => [
                            ExternalLink::make([
                                'label' => 'H5',
                                'badge' => null,
                                'icon' => null,
                                'target' => '_blank',
                                'url' => 'http://121.41.123.125:8889/vocmob'
                            ]),
                            NovaResource::make(Category::class),
                            NovaResource::make(Chapter::class),
                        ]
                    ]),
                    TopLevelResource::make([
                        'label' => '考试管理',
                        'expanded' => null,
                        'badge' => null,
                        'icon' => null,
                        'linkTo' => null, // accepts an instance of `NovaResource` or a Nova `Resource::class`
                        'resources' => [
                            NovaResource::make(Package::class),
                            // NovaResource::make(Exam::class),
                            NovaResource::make(Suite::class),
                            NovaResource::make(Paper::class),
                            NovaResource::make(Question::class),
                        ]
                    ]),
                    TopLevelResource::make([
                        'label' => '内容管理',
                        'expanded' => null,
                        'badge' => null,
                        'icon' => null,
                        'linkTo' => null, // accepts an instance of `NovaResource` or a Nova `Resource::class`
                        'resources' => [
                            NovaResource::make(Tab::class),
                            NovaResource::make(Article::class),
                            NovaResource::make(Video::class),
                            NovaResource::make(Pattern::class),
                        ],
                    ]),
                    TopLevelResource::make([
                        'label' => '账户管理',
                        'expanded' => null,
                        'badge' => null,
                        'icon' => null,
                        'linkTo' => null, // accepts an instance of `NovaResource` or a Nova `Resource::class`
                        'resources' => [
                            NovaResource::make(Member::class),
                            NovaResource::make(User::class),
                        ]
                    ]),
                ]
            ])
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
