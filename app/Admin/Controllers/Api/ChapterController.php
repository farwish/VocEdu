<?php

namespace App\Admin\Controllers\Api;

use App\Admin\Traits\ChapterTrait;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChapterController extends Controller
{
    use ChapterTrait;

    public function chapters(Request $request)
    {
        $categoryId = $request->get('q');

        return self::chapterTree($categoryId);
    }
}
