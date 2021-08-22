<?php

namespace App\Admin\Controllers\Api;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function questions(Request $request)
    {
        $categoryId = $request->get('q');

        return Question::query()->where('category_id', $categoryId)->pluck('title', 'id');
    }
}
