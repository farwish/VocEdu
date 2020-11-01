<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryOpen;
use App\Http\Requests\CategorySearch;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * category list
     *
     * @param Request $request
     * @param CategoryRepository $categoryRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, CategoryRepository $categoryRepository)
    {
        $pid = $request->input('pid');
        return $this->success($categoryRepository->list($pid));
    }

    /**
     * Member open category
     *
     * @param CategoryOpen $request
     * @param CategoryRepository $categoryRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function open(CategoryOpen $request, CategoryRepository $categoryRepository)
    {
        $validated = $request->validated();

        $member = $request->user('api');
        $cid = $validated['cid'];

        $bool = $categoryRepository->saveCategoryMember($cid, $member);

        return $bool ? $this->success() : $this->failure();
    }

    /**
     * Member opened categories
     *
     * @param Request $request
     * @param CategoryRepository $categoryRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function opened(Request $request, CategoryRepository $categoryRepository)
    {
        $member = $request->user('api');

        $openedCategories = $categoryRepository->categoryMemberMyAll($member);

        return $this->success($openedCategories);
    }

    public function search(CategorySearch $request, CategoryRepository $categoryRepository)
    {
        $name = $request->validated()['n'];

        $categories = $categoryRepository->searchLastCategoryByName($name);

        return $this->success($categories);
    }

    public function tree(Request $request, CategoryRepository $categoryRepository)
    {
        $pid = $request->input('pid');
        return $this->success($categoryRepository->tree($pid));
    }
}
