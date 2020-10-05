<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class CategoryQuestionList extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = '题目';

    public $withoutConfirmation = true;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $categoryId = $models[0]->getAttribute('id');
        $location = sprintf('%s/resources/questions?questions_page=1&questions_search=%s', config('nova.path'), $categoryId);
        return Action::openInNewTab($location);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
