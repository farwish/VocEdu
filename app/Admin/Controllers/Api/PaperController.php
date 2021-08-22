<?php

namespace App\Admin\Controllers\Api;

use App\Models\Paper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaperController extends Controller
{
    public function papers(Request $request)
    {
        $categoryId = $request->get('q');

        return Paper::query()->where('category_id', $categoryId)->pluck('name', 'id');
    }
}
