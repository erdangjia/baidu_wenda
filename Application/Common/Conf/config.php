<?php

$host = $_SERVER['HTTP_HOST'];
$arr = array(
    'DB_TYPE' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'demo',
    'DB_USER' => "root",
    'DB_PWD' => "",
    'DB_PORT' => 3306,
    'DB_PREFIX' => 'sucai_',
    'DB_CHARSET' => 'utf8',
    'MODULE_ALLOW_LIST' => array(
        'Home',
    ),
    'LOG_RECORD' => false, //日志开启

    'URL_MODEL' => 2,
    'LOAD_EXT_FILE' => 'common',
    'SHOW_PAGE_TRACE' => false,
    'SITE_URL' => $SITE_URL,
    'upload_max_size' => 100 * 1024 * 1024,
    'pagenum' => 10,
    'COOKIE_EXPIRE' => 3600 * 24 * 7,
    'version' => $version,
    'HTML_CACHE_ON' => $html, // 开启静态缓存
    'points' => array(
        'bamoban' => '5000', //扒模板积分
        'email_check_active' => '30', //邮箱验证激活
        'sign_day' => '20', //每日签到
        'comment' => '10', //评论
        'sign_month' => '1000', //连续签到一月
        'paybei' => '50', 
    ),
    'privateKey' => '*&09%$_s@??ddg22hhh'
);
if ($host == 'localhost') {
    unset($arr['TMPL_EXCEPTION_FILE']);
}
return $arr;
