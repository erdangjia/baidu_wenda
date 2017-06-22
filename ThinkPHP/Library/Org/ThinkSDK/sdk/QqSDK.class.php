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
// | QqSDK.class.php 2013-02-25
// +----------------------------------------------------------------------

class QqSDK extends ThinkOauth {

    /**
     * 获取requestCode的api接口
     * @var string
     */
    protected $GetRequestCodeURL = 'https://graph.qq.com/oauth2.0/authorize';

    /**
     * 获取access_token的api接口
     * @var string
     */
    protected $GetAccessTokenURL = 'https://graph.qq.com/oauth2.0/token';

    /**
     * 获取request_code的额外参数,可在配置中修改 URL查询字符串格式
     * @var srting
     */
    protected $Authorize = 'scope=get_user_info,add_share,add_t,add_pic_t';

    /**
     * API根路径
     * @var string
     */
    protected $ApiBase = 'https://graph.qq.com/';

    /**
     * 组装接口调用参数 并调用接口
     * @param  string $api    微博API
     * @param  string $param  调用API的额外参数
     * @param  string $method HTTP请求方法 默认为GET
     * @return json
     */
    public function call($api, $param = '', $method = 'GET', $multi = false) {
        /* 腾讯QQ调用公共参数 */
        $params = array(
            'oauth_consumer_key' => $this->AppKey,
            'access_token' => $this->Token['access_token'],
            'openid' => $this->openid(),
            'format' => 'json'
        );
        $data = $this->http($this->url($api), $this->param($params, $param), $method,array(),$multi);
        return json_decode($data, true);
    }

    /**
     * 解析access_token方法请求后的返回值 
     * @param string $result 获取access_token的方法的返回值
     */
    protected function parseToken($result, $extend) {
        parse_str($result, $data);
        if ($data['access_token'] && $data['expires_in']) {
            $this->Token = $data;
            $data['openid'] = $this->openid();
            return $data;
        } else
            throw new Exception("获取腾讯QQ ACCESS_TOKEN 出错：{$result}");
    }

    /**
     * 获取当前授权应用的openid
     * @return string
     
    public function openid() {
        $data = $this->Token;
        $data['openid'] = $data['openid'] ? $data['openid'] : $_COOKIE['openid'];
        $data['access_token'] = $data['access_token'] ? $data['access_token'] : $_COOKIE['token'];
        if (isset($data['openid']))
            return $data['openid'];
        elseif ($data['access_token']) {
            $data = $this->http($this->url('oauth2.0/me'), array('access_token' => $data['access_token']));
            $data = json_decode(trim(substr($data, 9), " );\n"), true);
            if (isset($data['openid']))
                return $data['openid'];
            else
                throw new Exception("获取用户openid出错：{$data['error_description']}");
        } else {
            throw new Exception('没有获取到openid！');
        }
    }
*/
/**
     * 获取当前授权应用的openid
     * @return openid client_id
     */
    public function openid() {
		if(!empty($this->Token)){
			 $data = $this->http($this->url('oauth2.0/me'), array('access_token' => $this->Token["access_token"]));
			 if($data){
				$lpos = strpos($data, "("); 
				$rpos = strrpos($data, ")"); 
				$data = substr($data, $lpos+1, $rpos-$lpos-1); 
				$json = json_decode($data);
				$openid = $json->openid; 
				return $openid;
			 }else{
				   throw new Exception('没有获取到openid！');
			 }
		}
    }
	/*
	 *获取网络上的图片
	 */
	public function get_local_pic_url($img_url){
		
		
	}
	/* 
*功能：php完美实现下载远程图片保存到本地 
*参数：文件url,保存文件目录,保存文件名称，使用的下载方式 
*当保存文件名称为空时则使用远程文件原来的名称 
*/ 
	function getImage($url,$save_dir='',$filename='',$type=0){ 
	    $save_dir=THINK_PATH.".".TEMP_PATH;
		if(trim($url)==''){ 
			return array('file_name'=>'','save_path'=>'','error'=>1); 
		} 
		if(trim($save_dir)==''){ 
			$save_dir='./'; 
		} 
		if(trim($filename)==''){//保存文件名 
			$ext=strrchr($url,'.'); 
			if($ext!='.gif'&&$ext!='.jpg'){ 
				return array('file_name'=>'','save_path'=>'','error'=>3); 
			} 
			$filename=time().$ext; 
		} 
		if(0!==strrpos($save_dir,'/')){ 
			$save_dir.='/'; 
		} 
	 //创建保存目录 
	  if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){ 
		  return array('file_name'=>'','save_path'=>'','error'=>5); 
	  } 
	  //获取远程文件所采用的方法  
	  if($type){ 
			$ch=curl_init(); 
			$timeout=5; 
			curl_setopt($ch,CURLOPT_URL,$url); 
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout); 
			$img=curl_exec($ch); 
			curl_close($ch); 
	  }else{ 
			ob_start();  
			readfile($url); 
			$img=ob_get_contents();  
			ob_end_clean();  
		} 
		//$size=strlen($img); 
		//文件大小  
		$fp2=@fopen($save_dir.$filename,'a'); 
		fwrite($fp2,$img); 
		fclose($fp2); 
		unset($img,$url); 
		return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0); 
	} 

}
