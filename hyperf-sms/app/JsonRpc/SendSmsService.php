<?php
namespace App\JsonRpc;

use Hyperf\Di\Annotation\Inject;
use Hyperf\DbConnection\Db;
use Hyperf\RpcServer\Annotation\RpcService;

/**
 * @RpcService(name="SendSmsService", protocol="jsonrpc-http", server="jsonrpc-http")
 */
class SendSmsService {

    /**
     * @Inject
     * @var ClientFactory
     */
    private $clientFactory;

    public function sendSms(string $phone,string $ip,string $type,string $area_code,string $locale) :array
    {
        if (!isset($phone)) {
            return ['code' => 500, 'msg' => '手机号不能为空'];
        };
        $sms_log = Db::table('sms_logs')
            ->where('phone', $phone)
            ->where('area_code',$area_code)
            ->where('used', 0)
            ->orderBy('id', 'desc')
            ->first();
            
        if (!empty($sms_log) && Carbon::now()->modify('-15 minutes')->lt($sms_log->created_at)) {
            return  [
                'code' => 500,
                'msg' => '验证码十五分钟内有效',
            ];
        }

        $code = mt_rand(100000, 999999);
        $string = $this->getText($type,$code,$locale);
        try {
            // $options 等同于 GuzzleHttp\Client 构造函数的 $config 参数
            $options = [];
            // $client 为协程化的 GuzzleHttp\Client 对象
            $client = $this->clientFactory->create($options);
            $api_send_url = 'https://u.smsyun.cc/sms-partner/access/b03g36/sendsms';
            //云信接口参数
            $postFields = array (
                'smstype' =>'4',//短信发送
                'clientid'  =>  '',
                'password' => md5(''),
                'mobile' => $phone,
                'content' => $string,
                'sendtime' => date('Y-m-d H:i:s'),
                'extend'=>'00',
                'uid'=>'00'
            );
            $jsonFields = json_encode($postFields);
            $response = $client->request('POST', $api_send_url, [
                'body' => $jsonFields,
                'headers' => array(
                    'Accept-Encoding: identity',
                    'Content-Length: ' . strlen($jsonFields),
                    'Accept:application/json',
                    'Content-Type: application/json; charset=utf-8'   //json版本需要填写  Content-Type: application/json;
                ),
            ]);

            $body = $response->getBody();
            $result = json_decode($body,true);
            if ($result['data'][0]['code'] === 0) {
                Db::table('sms_logs')
                ->insert([
                    'area_code' => $area_code,
                    'phone' => $phone,
                    'code' => $code,
                    'content' => $area_code,
                    'ip' => $ip,
                    'result' => '',
                ]);
               
                return ['code' => 200,'msg' => '发送成功！'];
            } else {
                return ['code' => 500,'msg' => $result['data'][0]['code'].','.$result['data'][0]['msg']];
            }

        } catch (\Exception $e) {
            return ['code' => 500,'msg' => $e->getMessage()];
        }
    }
}