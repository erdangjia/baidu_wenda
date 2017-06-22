<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller {

    public function index() {
        $id = 1; //文章id
        $sql = "pid=0";

        $count = M('comment')->where($sql)->count();
        $Page = new \Think\PageAjax($count, 10, '', array("site" => $p));
    
        $comments = M("comment")->field("id,uid,content,addtime")->where($sql)->order("id DESC")->limit(10)->select();
        foreach ($comments as $k => $v) {
            $comments[$k]['sub'] = M("comment")->field("id,uid,content,pid_sub")->where("pid = " . $v['id'] . "")->order("id ASC")->select();
        }
        $assignArr = array(
            "id" => $id,
            "comments_num" => $count,
            "totalpage" => ceil($count / 10),
        );
        $emots = M("emot")->cache(true)->select();

        $this->assign($assignArr);

        $this->assign("comments", $comments);
        $this->assign("emots", $emots);
        $this->assign("page", $Page->show());
        $this->display();
    }

}
