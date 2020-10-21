<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['mobile', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return $this->failure('登录失败', 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
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
     * Log the user out (Invalidate the token).
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
            // 'token_type' => 'bearer',
            // 'expires_in' => auth('api')->factory()->getTTL() * 60
        ];

        return $this->success($data);
    }
}
