<?php

// +----------------------------------------------------------------------
// | TOPThink [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://topthink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 二当家的 <416148489@qq.com> <http://www.erdangjiade.com>
// +----------------------------------------------------------------------
// | SinaSDK.class.php 2013-02-25
// +----------------------------------------------------------------------

class SinaSDK extends ThinkOauth {

    /**
     * 获取requestCode的api接口
     * @var string
     */
    protected $GetRequestCodeURL = 'https://api.weibo.com/oauth2/authorize';

    /**
     * 获取access_token的api接口
     * @var string
     */
    protected $GetAccessTokenURL = 'https://api.weibo.com/oauth2/access_token';

    /**
     * API根路径
     * @var string
     */
    protected $ApiBase = 'https://api.weibo.com/2/';

    /**
     * 组装接口调用参数 并调用接口
     * @param  string $api    微博API
     * @param  string $param  调用API的额外参数
     * @param  string $method HTTP请求方法 默认为GET
     * @return json
     */
    public function call($api, $param = '', $method = 'GET', $multi = false) {
        /* 新浪微博调用公共参数 */
        $params = array(
            'access_token' => $this->Token['access_token'],
            'status'=>urlencode("输入内容测试"),
            'url' => "http://www.erdangjiade.com/Public/images/other/mobile.jpg"
        );
        $vars = $this->param($params, $param);
//            print_r($params);print_r($param);
//            print_r($vars);
//             print_r($this->url($api, '.json'));
    
        $data = $this->http($this->url($api, '.json'), $vars, $method, array(), $multi);
        return json_decode($data, true);
    }

    /**
     * 解析access_token方法请求后的返回值
     * @param string $result 获取access_token的方法的返回值
     */
    protected function parseToken($result, $extend) {
        $data = json_decode($result, true);
        if ($data['access_token'] && $data['expires_in'] && $data['remind_in'] && $data['uid']) {
            $data['openid'] = $data['uid'];
            unset($data['uid']);
            return $data;
        } else
            throw new Exception("获取新浪微博ACCESS_TOKEN出错：{$data['error']}");
    }

    /**
     * 获取当前授权应用的openid
     * @return string
     */
//    public function openid() {
//		if(!empty($this->Token)){
//			 $data = $this->http($this->url('oauth2/get_token_info'), array('access_token' => $this->Token["access_token"]));
//			 if($data){
//				print_r($data);exit;
//			 }else{
//				   throw new Exception('没有获取到openid！');
//			 }
//		}
//    }
    public function openid() {
        $data = $this->Token;
        if ($data['openid']){
              return $data['openid'];
        } else{
            throw new Exception('没有获取到新浪微博用户ID2！');
        }
    }

}
