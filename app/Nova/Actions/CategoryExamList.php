<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class CategoryExamList extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = '考场';

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
        $location = sprintf('%s/resources/exams?exams_page=1&exams_search=%s', config('nova.path'), $categoryId);
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
