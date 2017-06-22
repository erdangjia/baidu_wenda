<?php

namespace Home\Controller;

use Think\Controller;
class BoxController extends Controller {
      public function comments() {
        $id = I("get.id", 0, 'int');
        $mtype = I("get.mtype", 1, 'int');
        $p = I("get.p", 1, "int");
        $totalnum = I("get.totalnum", 1, "int");
        $start = 10 * ($p - 1);
        $sql = "tid = " . $id . " AND pid = 0";
        $Page = new \Think\PageAjax($totalnum, 10, '', array("site" => $p));
        $url_action = __APP__ . '/' . getMtype($mtype) . '/' . $id . "-p-pagenum";

$Page->setConfig('link', $url_action);
        $comments = M("comment")->field("id,uid,content,addtime")->where($sql)->order("id DESC")->limit($start . ",10")->select();
//        echo M("comment")->getlastsql();
        foreach ($comments as $k => $v) {
            $comments[$k]['sub'] = M("comment")->field("id,uid,content,pid_sub")->where("mtype = " . $mtype . " AND tid = " . $id . " AND pid = " . $v['id'] . "")->order("id ASC")->select();
        }
        $this->assign("id", $id);
        $this->assign("mtype", $mtype);
        $this->assign("comments", $comments);
        $this->assign("comments_num", $totalnum - ($page - 1) * 10);
        $this->assign("page", $Page->show());
        $this->display();
    }

}
