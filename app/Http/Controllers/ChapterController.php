<?php

namespace App\Http\Controllers;

use App\Repositories\ChapterRepository;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function tree(Request $request, ChapterRepository $chapterRepository)
    {
        $cid = $request->input('cid');
        return $this->success($chapterRepository->tree($cid));
    }
}
