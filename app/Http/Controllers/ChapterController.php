<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChapterInfo;
use App\Repositories\ChapterRepository;

class ChapterController extends Controller
{
    public function index(ChapterInfo $request, ChapterRepository $chapterRepository)
    {
        $validated = $request->validated();
        $cid = $validated['cid'];         // chapter category_id
        $pid = $validated['pid'] ?? null; // chapter parent_id

        return $this->success($chapterRepository->list($cid, $pid));
    }

    public function tree(ChapterInfo $request, ChapterRepository $chapterRepository)
    {
        $cid = $request->validated()['cid'];

        return $this->success($chapterRepository->tree($cid));
    }
}
