<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Http\Request;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AccountController extends ApiController
{
    private UserRepositoryInterface $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    protected function validateRule(): array
    {
        return [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:255|confirmed'
        ];
    }

    protected function validateMessage(): array
    {
        return [
            'name.required'     => 'Tên đăng nhập là bắt buộc',
            'email.required'    => 'Email đăng nhập là bắt buộc',
            'email.email'       => 'Email đăng nhập không đúng định dạng',
            'email.unique'      => 'Email đăng nhập đã tồn tại trên hệ thống',
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min'      => 'Mật khẩu ít nhất có :min ký tự',
            'password.max'      => 'Mật khẩu có tối đa :max ký tự',
        ];
    }

    public function register(Request $request)
    {
        try {
            $this->validate($request, $this->validateRule(), $this->validateMessage());

            $params = $request->all();
            $this->user->register($params);

            $url     = env('APP_URL') . '/oauth/token';
            $options = [
                'json' => [
                    'grant_type'    => 'password',
                    'client_id'     => env('CLIENT_ID'),
                    'client_secret' => env('CLIENT_SECRET'),
                    'username'      => $params['email'],
                    'password'      => $params['password'],
                ]
            ];

            $result = (new HttpClient)->post($url, $options)->getBody()->getContents();

            return $this->successResponse(json_decode($result, true));
        } catch (ValidationException $e) {
            return $this->errorResponse([
                'errors'    => $e->validator->errors(),
                'exception' => $e->getMessage()
            ]);
        } catch (\Throwable $t) {
            throw $t;
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $url     = env('APP_URL') . '/oauth/token';
                $options = [
                    'json' => [
                        'grant_type'    => 'password',
                        'client_id'     => env('CLIENT_ID'),
                        'client_secret' => env('CLIENT_SECRET'),
                        'username'      => $credentials['email'],
                        'password'      => $credentials['password'],
                    ]
                ];

                $result = (new HttpClient)->post($url, $options)->getBody()->getContents();

                return $this->successResponse(json_decode($result, true));
            }

            return $this->errorResponse([
                'errors' => [
                    'authen' => ['Thông tin đăng nhập không chính xác.']
                ]
            ]);
        } catch (\Throwable $t) {
            throw $t;
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
