<?php

declare(strict_types=1);

namespace App\Job;

use Hyperf\AsyncQueue\Job;
use PHPMailer\PHPMailer\PHPMailer;

class SendEmailJob extends Job
{
    public $params;

    public function __construct($params)
    {
        // 这里最好是普通数据，不要使用携带 IO 的对象，比如 PDO 对象
        $this->params = $params;
    }

    public function handle()
    {
        $params = $this->params;
        co(function() use ($params) {
            $mail = new PHPMailer; //PHPMailer对象
            $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
            $mail->IsSMTP(); // 设定使用SMTP服务
            $mail->SMTPDebug = 0; // 关闭SMTP调试功能
            $mail->SMTPAuth = true; // 启用 SMTP 验证功能
            $mail->SMTPSecure = 'ssl'; // 使用安全协议
            $mail->Host = 'smtp.163.com'; // SMTP 服务器
            $mail->Port = '465'; // SMTP服务器的端口号
            $mail->Username = 'm13193835328@163.com'; // SMTP服务器用户名
            $mail->Password = 'yulu1213'; // SMTP服务器密码
            $mail->SetFrom('m13193835328@163.com', 'yuyulu'); // 邮箱，昵称
            $mail->Subject = 'title test';
            $mail->MsgHTML('hello world');
            $mail->AddAddress($params['email']); // 收件人
            $mail->Send();
        });
    }
}
