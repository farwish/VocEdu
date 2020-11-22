<?php

namespace App\Http\Controllers\VD;

use App\Http\Requests\CategoryOpen;
use App\Http\Requests\CategorySearch;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/category/index",
     *      operationId="/api/category/index",
     *      tags={"Category v0"},
     *      summary="科目分类列表",
     *      description="Category list",
     *      security={
     *          {"bearerXxx": {}}
     *      },
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="`Bearer <access_token>`若需调试，统一在顶部 Authorize 中设置",
     *          in="header"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="data", type="array",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="id", type="integer", description="分类id"),
     *                          @OA\Property(property="name", type="string", description="分类名称"),
     *                      ),
     *                  ),
     *                  @OA\Property(property="message", type="string", default="success"),
     *                  @OA\Property(property="code", type="integer", default=0),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", default=""),
     *              @OA\Property(property="message", type="string", default="登录校验不通过"),
     *              @OA\Property(property="code", type="integer", default=-1),
     *         )
     *      ),
     * )
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
     * @OA\Get(
     *      path="/api/category/search",
     *      operationId="/api/category/search",
     *      tags={"Category v0"},
     *      summary="检索科目分类",
     *      description="Search category by name",
     *      security={
     *          {"bearerXxx": {}}
     *      },
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="`Bearer <access_token>`若需调试，统一在顶部 Authorize 中设置",
     *          in="header"
     *      ),
     *      @OA\Parameter(
     *          name="n",
     *          description="科目名称",
     *          required=true,
     *          in="query",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="data", type="array",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="id", type="integer", description="分类id"),
     *                          @OA\Property(property="name", type="string", description="分类名称"),
     *                      ),
     *                  ),
     *                  @OA\Property(property="message", type="string", default="success"),
     *                  @OA\Property(property="code", type="integer", default=0),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", default=""),
     *              @OA\Property(property="message", type="string", default="登录校验不通过"),
     *              @OA\Property(property="code", type="integer", default=-1),
     *         )
     *      ),
     * )
     *
     * @param Request $request
     * @param CategoryRepository $categoryRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(CategorySearch $request, CategoryRepository $categoryRepository)
    {
        $name = $request->validated()['n'];

        $categories = $categoryRepository->searchLastCategoryByName($name);

        return $this->success($categories);
    }

    /**
     * @OA\Get(
     *      path="/api/category/opened",
     *      operationId="/api/category/opened",
     *      tags={"Category v0"},
     *      summary="用户开通的科目列表",
     *      description="User opened categories",
     *      security={
     *          {"bearerXxx": {}}
     *      },
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="`Bearer <access_token>`若需调试，统一在顶部 Authorize 中设置",
     *          in="header"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="data", type="array",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="name", type="string", description="科目名称"),
     *                          @OA\Property(property="categoryId", type="integer", description="科目id"),
     *                          @OA\Property(property="expiredAt", type="string", description="到期时间,如: 2021-11-02"),
     *                      ),
     *                  ),
     *                  @OA\Property(property="message", type="string", default="success"),
     *                  @OA\Property(property="code", type="integer", default=0),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", default=""),
     *              @OA\Property(property="message", type="string", default="登录校验不通过"),
     *              @OA\Property(property="code", type="integer", default=-1),
     *         )
     *      ),
     * )
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

    /**
     * @OA\Post(
     *      path="/api/category/open",
     *      operationId="/api/category/open",
     *      tags={"Category v0"},
     *      summary="执行科目开通",
     *      description="Open the category",
     *      security={
     *          {"bearerXxx": {}}
     *      },
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="`Bearer <access_token>`若需调试，统一在顶部 Authorize 中设置",
     *          in="header"
     *      ),
     *      @OA\Parameter(
     *          name="cid",
     *          description="科目id",
     *          required=true,
     *          in="query"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="data", default=null),
     *                  @OA\Property(property="message", type="string", default="success"),
     *                  @OA\Property(property="code", type="integer", default=0)
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", default=""),
     *              @OA\Property(property="message", type="string", default="登录校验不通过"),
     *              @OA\Property(property="code", type="integer", default=-1)
     *         )
     *      ),
     * )
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

    public function tree(Request $request, CategoryRepository $categoryRepository)
    {
        $pid = $request->input('pid');
        return $this->success($categoryRepository->tree($pid));
    }
}
