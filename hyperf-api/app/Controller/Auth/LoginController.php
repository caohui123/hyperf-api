<?php
declare(strict_types = 1);


namespace App\Controller\Auth;

use App\Model\User;
use Phper666\JwtAuth\Jwt;
use App\Controller\AbstractController;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class LoginController extends AbstractController
{
    /**
     * @Inject
     *
     * @var Jwt
     */
    protected $jwt;

    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected $validationFactory;

    /**
     * 用户登录
     * @param  RequestInterface $request [description]
     * @return [type]                    [description]
     */
    public function login(RequestInterface $request)
    {
        $validator = $this->validationFactory->make(
            $request->all(),
            [
                'phone' => 'required',
                'password' => 'required',
            ],
            [],
            [
                'phone' => __('keys.phone'),
                'password' => __('keys.password'),
            ]
        );

        if ($validator->fails()){
            // Handle exception
            $errorMessage = $validator->errors()->first();
            return $this->failed($errorMessage);
        }

        $user = User::query()
        ->where('phone', $request->input('phone'))
        ->first();

        if(empty($user)){
            return $this->failed(__('messages.user_not_exists'));
        }

        //验证用户账户密码
        if (password_verify($request->input('password'), $user->password)) {
            $userData = [
                'uid'       => $user->id,
                'account'  => $user->account,
            ];
            
            $token = $this->jwt->getToken($userData);
            $data  = [
                'token' => (string) $token,
                'exp'   => $this->jwt->getTTL(),
            ];
            return $this->success($data);
        }

        return $this->failed(__('messages.login_failed'));
    }

    /**
     * 用户登出
     * @return [type] [description]
     */
    public function logout()
    {
        if ($this->jwt->logout()) {
            return $this->success('','退出登录成功');
        };
        return $this->failed('退出登录失败');
    }
}