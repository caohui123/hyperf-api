<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\JsonRpc\SendSmsService;
use App\JsonRpc\SendEmailService;

class UserController extends AbstractController
{
    public function info()
    {
        $user = $this->request->getAttribute('user');
        return $this->success($user);
    }

    public function sendSms(SendSmsService $service)
    {
    	$service->sendSms($phone,$area_code,$locale,$sign);
    }

    public function sendEmail(SendEmailService $service)
    {
        $user = $this->request->getAttribute('user');
        if (!empty($user)) {
            $email = $user->email;
        } else {
            $email = 'test.email';
        }

        return $email;
        $email = '1065673465@qq.com';
        $locale = 'zh_CN';
        $sign = 'DCEP';
    	return $service->sendEmail($email,$locale,$sign);
    }

}