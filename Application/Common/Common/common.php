<?php

function get_extension($file) {
    $fileArr = explode("?", $file);
    $type = strtolower(substr(strrchr($fileArr[0], '.'), 1));
    return $type;
}

function getPointsState($type) {
    if ($type == 0) {
        $word = "<span style='color:#333'>待审核</span>";
    } elseif ($type == 5) {
        $word = "<span style='color:#FF6600'>已完成</span>";
    } elseif ($type == 1) {
        $word = "<span style='color:red'>已审核</span>";
    } else {
        $word = "<span style='color:#FF0000'>审核失败</span>";
    }
    return $word;
}

function addPoints($mtype, $money, $uid, $title, $status, $fuhao) {
    $data['addtime'] = time();
    $data['uid'] = $uid ? $uid : session("userid");
    $data['mtype'] = $mtype;
    $data['money'] = $money;
    $data['title'] = $title;
    $data['status'] = $status ? $status : 0;
    $data['fuhao'] = $fuhao ? $fuhao : 0;
    $lastid = M("points")->add($data);
    if ($lastid > 0) {
        if ($fuhao == 1) {
            M('user')->where("id=" . $data['uid'] . "")->setInc('money', $data['money']); //setInc加
        } else {
            M('user')->where("id=" . $data['uid'] . "")->setDec('money', $data['money']); //setInc加
        }
    }
    return $lastid;
}

//公共函数
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true) {
    if (function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    $fix = '';
    if (strlen($slice) < strlen($str)) {
        $fix = '...';
    }
    return $suffix ? $slice . $fix : $slice;
}

function getUserAvatar($id) {
    $logo_default = __APP__ . "/Public/images/avatar.jpg";
    $logo_rs = '';
    if ($id) {
        $logo = C("files.avatar") . $id . ".jpg";
        $arr = array("jpg", "png", "gif", "jpeg");
        foreach ($arr as $v) {
            $logo = C("files.avatar") . $id . "." . $v;
            if (file_exists($logo)) {
                $logo_rs = __APP__ . "/" . $logo;
                break;
            }
        }
        if ($logo_rs == '') {
            $logo_rs = $logo_default;
        }
    } else {
        $logo_rs = $logo_default;
    }
    return $logo_rs;
}


function getChecked($ids, $id) {
    if (!empty($ids)) {
        $ids = explode(",", $ids);
        if (in_array($id, $ids)) {
            return "checked";
        }
    }
}

function getSingleField($id, $table, $field, $word) {
    if (!empty($id)) {
        $ids = explode(",", $id);
        if (count($ids) >= 2) {
            $info = M($table)->field($field)->where("id in (" . $id . ")")->find();
        } else {
            $info = M($table)->field($field)->where("id = " . $id . "")->find();
        }
        if ($info[$field] != '') {
            return $info[$field];
        } else {
            return $word;
        }
    }
}

function getEqual($a, $b, $rs, $fuhao = 'eq') {
    if ($fuhao > 0) {
        if ($a % $fuhao == $b) {
            return $rs;
        }
    } else {
        if ($fuhao == 'eq') {
            if ($a == $b) {
                return $rs;
            }
        } elseif ($fuhao == 'gt') {
            if ($a > $b) {
                return $rs;
            }
        } elseif ($fuhao == 'in') {
            $arr = explode(",", $b);
            if (in_array($a, $arr)) {
                return $rs;
            }
        }
    }
}


function getTableFile($table) {
    $commonTable = array("accounts", "friends");
    $ordTable = array("dictionary", "modals_tags");
    if (in_array($table, $commonTable)) {
        $ord = "ord ASC";
        $where = "is_check=1";
    } elseif (in_array($table, $ordTable)) {
        $ord = "ord ASC,id DESC";
    }
    $lists = F('' . $table . '/data');
    if (empty($lists)) {
        $lists = M($table)->where($where)->order($ord)->select();

        F('' . $table . '/data', $lists);
    }
    return $lists;
}

function getTableConfig() {
    $config = F('config/data');
    if (empty($config)) {
        $config = M("config")->where("id = 1")->find();
        F('config/data', $config);
    }
    return $config;
}

function getGb2312($file) {
    return iconv('UTF-8', 'GB2312', $file);
}

function getUtf8($file) {
    return iconv('GB2312', 'UTF-8', $file);
}


function getTableInfo($mtype, $field = 'table') {
    switch ($mtype) {
        case "1":
            $table = 'modals';
            break;
        case "2":
            $table = 'js';
            break;
        case "3":
            $table = 'sites';
            break;
        case "4":
            $table = 'psd';
            break;
        case "12":
            $table = 'tools';
            break;
        case "21":
            $table = 'topic';
            break;
    }
    $arr = array("table" => $table);
    return $arr[$field];
}


function getTan($id) {
    if ($id > 0) {
        $comment = M("comment")->field("uid")->where("id = " . $id . "")->find();
        return "回复 " . getUidUrl($comment['uid']) . "";
    }
}

function getUidUrl($uid) {
    return "<a class='blue'  target='_blank' href='" . __APP__ . "/space/uid/" . $uid . "' >" . getUserName($uid) . "</a> ";
}

function getUserName($uid) {
    return "test".rand(1000,9999);
}
function addCommentContent($content){
          return  str_replace("\r\n","<br />",$content);
//          return $rs;
}
function getCommentContent($content) {

    $content = stripslashes($content);
    $content = str_replace("[code]", "<pre><code class='html'>", $content);
    $content = str_replace("[code='html']", "<pre><code class='html'>", $content);
    $content = str_replace("[code='js']", "<pre><code class='js'>", $content);
    $content = str_replace("[code='css']", "<pre><code class='css'>", $content);
    $content = str_replace("[code='php']", "<pre><code class='php'>", $content);
    $content = str_replace("[/code]", "</code></pre>", $content);
    $tagsArr = array("code", "pre", "em", "b", "strong", "p", "br", "a", "span", "dd", "dl", "dt", "table", "tr", "th", "td", "thead", "tbody", "img",
        "h1", "h2", "h3", "h4", "h5", "h5", "div", "i", "dfn", "u", "ins", "strike", "s", "del", "font", "hr", "center", "caption", "html", "body", "ul", "li", "ol", "select", "small", "input", "textarea"
    );
    $tags = "";
    foreach ($tagsArr as $v) {
        $tags .="<" . $v . ">";
    }
    return strip_tags($content, $tags);
}

function getUserId() {
    $userid = session("userid");
    return $userid;
}
?>
