<?php

namespace App\Nova;

use App\Models\Chapter as ChapterModel;
use App\Models\Category as CategoryModel;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource
{
    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a Scout search query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Scout\Builder  $query
     * @return \Laravel\Scout\Builder
     */
    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    }

    public static $tableStyle = 'tight';

    public static function singularLabel()
    {
        return static::label();
    }

    // ------------ My Custom below -----------

    public static $globallySearchable = true;

    public function categoryTree()
    {
        $cateValues = [];

        $traverse = function ($categories, $prefix = '—') use (&$traverse, &$cateValues) {
            /** @var CategoryModel $category */
            foreach ($categories as $category) {
                if (! $category->getAttribute('parent_id')) {
                    // Root category do not add prefix
                    $rootPrefix = '';
                } else {
                    $rootPrefix = '|' . $prefix;
                }
                $cateValues[$category->getAttribute('id')] = $rootPrefix . ' ' . $category->name;

                $sunPrefix = $prefix . $rootPrefix;
                $traverse($category->children, $sunPrefix);
            }
        };

        $nodes = CategoryModel::get()->toTree();
        $traverse($nodes);

        return $cateValues;
    }

    public function chapterTree(?int $categoryId)
    {
        $chapterValues = [];

        $traverse = function ($chapters, $prefix = '—') use (&$traverse, &$chapterValues) {
            /** @var ChapterModel $chapter */
            foreach ($chapters as $chapter) {
                if (! $chapter->getAttribute('parent_id')) {
                    // Root category do not add prefix
                    $rootPrefix = '';
                } else {
                    $rootPrefix = '|' . $prefix;
                }
                $chapterValues[$chapter->getAttribute('id')] = $rootPrefix . ' ' . $chapter->name;

                $sunPrefix = $prefix . $rootPrefix;
                $traverse($chapter->children, $sunPrefix);
            }
        };

        if ($categoryId) {
            $nodes = ChapterModel::query()->where('category_id', $categoryId)->get()->toTree();
        } else {
            $nodes = ChapterModel::query()->get()->toTree();
        }
        $traverse($nodes);

        return $chapterValues;
    }
}
