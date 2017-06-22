<?php

namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller {

    function _initialize() {
        header("Content-type: text/html; charset=utf-8");

        $action = strtolower(CONTROLLER_NAME);
        $returnUrl = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ""; //当前页面
        $config = getTableConfig();
        $assignArr = array(
            "control" => $action,
            "mod" => strtolower(ACTION_NAME),
            "returnUrl" => $returnUrl,
            "version" => C("version")
        );
        $this->assign($assignArr);
        $this->assign("config", $config);
        $this->assign("url_cur", __SELF__);
    }

}
