<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request, CategoryRepository $categoryRepository)
    {
        $pid = $request->input('pid');
        return $this->success($categoryRepository->list($pid));
    }

    public function tree(Request $request, CategoryRepository $categoryRepository)
    {
        $pid = $request->input('pid');
        return $this->success($categoryRepository->tree($pid));
    }
}
