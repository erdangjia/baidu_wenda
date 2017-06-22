<?php

namespace Home\Controller;

use Think\Controller;

class AjaxController extends Controller {

    public function checkLogin() {
//        $pwd = I('post.pwd');
        $username = I('post.username');
        $userid = 1;
        setSessionCookie("userid", $userid);
        setSessionCookie("username", $username);
        echo json_encode(array("username" => $username, "userid" => $userid, "avatar" => "http://www.erdangjiade.com/Public/images/avatar.jpg", "tip" => "", "error" => ""));
    }

    public function isLogin() {
        $userinfo = array("username" => "test", "userid" => getUserId(), "avatar" => "http://www.erdangjiade.com/Public/images/avatar.jpg");
        echo json_encode($userinfo);
    }

    public function subcomment() {
        $data['uid'] = getUserid();
        $data['mtype'] = I("post.mtype", 0, 'int');
        if ($data['uid'] == '') {
            echo json_encode(array("code" => -1));
        } else {
            $content = addslashes(str_replace("\n", "<br />", $_POST['content']));
            $data['tid'] = I("post.id", 0, 'int'); //文章id
            if (strlen(preg_replace('/\[  [^\)]+?  \]/x', '', $content)) < 10) {
                echo json_encode(array("code" => "short than 10", "error" => "评论的内容不能少于10个字符。"));
                exit;
            }
            if (C("DB_PWD") != '') {
                if (time() - session("comment_time") < 60 && session("comment_time") > 0) {//2分钟以后发布
                    echo json_encode(array("code" => "fast", "error" => "您提交评论的速度太快了，请稍后再发表评论。"));
                    exit;
                }
            }



            $data['pid'] = I("post.pid", 0, 'int');
            $data['pid_sub'] = I("post.pid_sub", 0, 'int');
            $lyid = $data['pid_sub'] > 0 ? $data['pid_sub'] : $data['pid'];
            if ($lyid > 0) {
                $lyinfo = M("comment")->field("uid")->where("id='" . $lyid . "'")->find();
                $data['touid'] = $lyinfo['uid'];
            } else {
                $data['touid'] = 2;
            }

            $data['addtime'] = time();

            $emots = getTableFile("emot");

            foreach ($emots as $v) {
                $content = str_replace("[" . $v['name'] . "]", "<img alt='" . $v['name'] . "' src='" . __APP__ . "/Public/emot/" . ($v['id'] - 1) . ".gif'>", $content);
            }
            $data['content'] = addslashes($content);

            $info = M("comment")->field("id")->where("content='" . $data['content'] . "'")->find();
            if ($info['id']) {
                echo json_encode(array("code" => "comment_repeat", "error" => "检测到重复评论，您似乎提交过这条评论了"));
                exit;
            }

            $lastid = M("comment")->add($data);
            $points_comment = 20;

            if ($lastid > 0) {
                $day_start = strtotime(date("Y-m-d"));
                $day_end = $day_start + 3600 * 24;
                $comment_num_day = M("comment")->where("uid = " . $data['uid'] . " AND addtime between " . $day_start . " AND " . $day_end . "")->count();
                if ($comment_num_day <= 5) { //少于5条每天，则添加积分
//                    addPoints("comment", $points_comment, $data['uid'], "评论获得" . $points_comment . "积分", 5, 1);
                }
//                addMessage('comment', $data['tid'], $data['pid'], $data['mtype'], $data['touid'], $content);
            }
            session("comment_time", time());

            echo json_encode(array("code" => 200, "comment" => $content, "points" => $points_comment));
        }
    }

}

?>