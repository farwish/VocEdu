<?php

namespace App\Http\Controllers\VD;

use App\Http\Requests\AuthLogin;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/auth/login",
     *      operationId="/api/auth/login",
     *      tags={"Auth v0"},
     *      summary="登录",
     *      description="Get a JWT via given credentials",
     *      @OA\Parameter(
     *          name="mobile",
     *          description="手机号",
     *          required=true,
     *          in="query"
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="密码",
     *          required=true,
     *          in="query"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="data", type="object",
     *                      @OA\Property(property="access_token", type="string"),
     *                  ),
     *                  @OA\Property(property="message", default="success"),
     *                  @OA\Property(property="code", type="integer", default=0),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Success request",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", default=""),
     *              @OA\Property(property="message", type="string", default="手机号不正确"),
     *              @OA\Property(property="code", type="integer", default=-1),
     *         )
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
     *      )
     *  ),
     *
     * @param AuthLogin $authLogin
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLogin $authLogin)
    {
        $credentials = $authLogin->validated();

        if (! $token = auth('api')->attempt($credentials)) {
            return $this->failure('登录校验不通过', 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Get(
     *      path="/api/auth/me",
     *      operationId="/api/auth/me",
     *      tags={"Auth v0"},
     *      summary="当前登录账号信息",
     *      description="Get the authenticated User",
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
     *                  @OA\Property(property="data", type="object",
     *                      @OA\Property(property="mobile", type="string"),
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $info = auth('api')->user();

        // column filter
        $allowReturnInfoKeys = ['mobile', 'email', 'name'];
        if ($info) {
            foreach ($info->toArray() as $name => $value) {
                if (!in_array($name, $allowReturnInfoKeys)) {
                    unset($info[$name]);
                }
            }
        }

        if (! $info) {
            return $this->failure('没有登录信息');
        }

        return $this->success($info);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/logout",
     *      operationId="/api/auth/logout",
     *      tags={"Auth v0"},
     *      summary="登出",
     *      description="Log the user out.",
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
     *                  @OA\Property(property="data", default=null),
     *                  @OA\Property(property="message", type="string", default="退出成功"),
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return $this->success(null, '退出成功');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $data = [
            'access_token' => $token,
            // 'expires_in' => auth('api')->factory()->getTTL(), // 返回展示作用，实际控制为 JWT_TTL
            // 'token_type' => 'bearer',
        ];

        return $this->success($data);
    }
}
