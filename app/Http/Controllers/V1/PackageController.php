<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryPackageRequest;
use App\Repositories\PackageRepository;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/package/index",
     *      operationId="/api/v1/package/index",
     *      tags={"Package v1"},
     *      summary="套餐列表",
     *      description="Package list",
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
     *                          @OA\Property(property="id", type="integer", description="package id"),
     *                          @OA\Property(property="name", type="string", description="套餐名"),
     *                          @OA\Property(property="explain", type="string", description="套餐说明"),
     *                          @OA\Property(property="price", type="integer", description="售价(元)"),
     *                          @OA\Property(property="oriPrice", type="integer", description="原价(元)"),
     *                          @OA\Property(property="expireDate", type="integer", description="套餐购买后有效期"),
     *                          @OA\Property(property="serviceContent", type="string", description="标签,逗号隔开"),
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
     * @param CategoryPackageRequest $request
     * @param PackageRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(CategoryPackageRequest $request, PackageRepository $repository)
    {
        $categoryId = $request->validated()['cid'];

        $list = $repository->list($categoryId);

        return $this->success($list);
    }
}
