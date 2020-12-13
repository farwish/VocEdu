<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppMenuRequest;
use App\Repositories\AppMenuRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class AppMenuController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/menu/index",
     *      operationId="/api/v1/menu/index",
     *      tags={"App Menu v1"},
     *      summary="APP卡片菜单列表",
     *      description="Menu list",
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
     *                          @OA\Property(property="id", type="integer", description="menu id"),
     *                          @OA\Property(property="title", type="string", description="标题"),
     *                          @OA\Property(property="subTitle", type="string", description="副标题"),
     *                          @OA\Property(property="icon", type="string", description="图标"),
     *                          @OA\Property(property="color", type="string", description="颜色"),
     *                          @OA\Property(property="nextFormat", type="string", description="下页格式"),
     *                          @OA\Property(property="slug", type="string", description="特殊标记"),
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
     * @param AppMenuRequest $request
     * @param AppMenuRepository $menuRepository
     * @param CategoryRepository $categoryRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(AppMenuRequest $request,
                          AppMenuRepository $menuRepository,
                          CategoryRepository $categoryRepository)
    {
        $validated = $request->validated();

        $list = $menuRepository->list();

        // check subLock OR reset
        $member = $request->user('api');
        $cid = $validated['cid'];
        $category = $categoryRepository->newQuery()->find($cid);
        if ($category && $categoryRepository->categoryMember($category, $member)) {
            foreach ($list as &$item) {
                $item['subLock'] = 0;
            }
            unset($item);
        }

        return $this->success($list);
    }
}
