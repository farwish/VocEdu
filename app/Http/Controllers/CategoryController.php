<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryBuy;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request, CategoryRepository $categoryRepository)
    {
        $pid = $request->input('pid');
        return $this->success($categoryRepository->list($pid));
    }

    public function buy(CategoryBuy $request, CategoryRepository $categoryRepository)
    {
        $validated = $request->validated();

        $member = $request->user('api');
        $cid = $validated['cid'];

        $bool = $categoryRepository->saveCategoryOfMember($cid, $member);

        return $bool ? $this->success() : $this->failure();
    }

    public function tree(Request $request, CategoryRepository $categoryRepository)
    {
        $pid = $request->input('pid');
        return $this->success($categoryRepository->tree($pid));
    }
}
