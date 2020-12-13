<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\ChapterInfo;
use App\Repositories\CategoryRepository;
use App\Repositories\ChapterRepository;
use App\Http\Controllers\Controller;

class ChapterController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/chapter/index",
     *      operationId="/api/v1/chapter/index",
     *      tags={"Chapter v1"},
     *      summary="章节列表",
     *      description="Category's chapter list",
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
     *          in="query",
     *      ),
     *      @OA\Parameter(
     *          name="pid",
     *          description="章节id（有传这个参数的时候, 返回此章节下的子章节）",
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
     *                          @OA\Property(property="id", type="integer", description="章节id"),
     *                          @OA\Property(property="name", type="string", description="章节名称"),
     *                          @OA\Property(property="subLock", type="integer", description="子章节是否锁住, 0-不锁, 1-有锁"),
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
     * @param ChapterInfo $request
     * @param ChapterRepository $chapterRepository
     * @param CategoryRepository $categoryRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ChapterInfo $request,
                          ChapterRepository $chapterRepository,
                          CategoryRepository $categoryRepository)
    {
        $validated = $request->validated();
        $cid = $validated['cid'];         // chapter category_id
        $pid = $validated['pid'] ?? null; // chapter parent_id

        $chapterList = $chapterRepository->list($cid, $pid);

        // check subLock OR reset
        $member = $request->user('api');
        $category = $categoryRepository->newQuery()->find($cid);
        if ($category && $categoryRepository->categoryMember($category, $member)) {
            foreach ($chapterList as &$item) {
                $item['subLock'] = 0;
            }
            unset($item);
        }

        return $this->success($chapterList);
    }

    public function tree(ChapterInfo $request, ChapterRepository $chapterRepository)
    {
        $cid = $request->validated()['cid'];

        return $this->success($chapterRepository->tree($cid));
    }
}
