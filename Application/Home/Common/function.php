<?php

function getEncode($words) {
    return urlencode($words);
}

function tranTime($time) {
    $rtime = date("m-d H:i", $time);
    $htime = date("H:i", $time);
    $time = time() - $time;
    if ($time < 60) {
        $str = '刚刚';
    } elseif ($time < 60 * 60) {
        $min = floor($time / 60);
        $str = $min . '分钟前';
    } elseif ($time < 60 * 60 * 24) {
        $h = floor($time / (60 * 60));
        $str = $h . '小时前 ' . $htime;
    } elseif ($time < 60 * 60 * 24 * 3) {
        $d = floor($time / (60 * 60 * 24));
        if ($d == 1)
            $str = '昨天 ' . $rtime;
        else
            $str = '前天 ' . $rtime;
    }
    else {
        $str = $rtime;
    }
    return $str;
}



function getArrayField($id, $arr, $field = 'name') {
    if ($id > 0) {
        foreach ($arr as $v) {
            if ($v['id'] == $id) {
                return $v[$field];
                break;
            }
        }
    }
}

function getArrayOne($id, $arr) {
    if ($id > 0) {
        foreach ($arr as $k => $v) {
            if ($k == $id) {
                return $v;
                break;
            }
        }
    }
}

function getNumName($num) {
    $words = $num . "楼";
    if ($num == 0) {
        $words = "沙发";
    } elseif ($num == 1) {
        $words = "椅子";
    } elseif ($num == 2) {
        $words = "板凳";
    }
    return $words;
}

function getMtypeTable($mtype, $file = '') {
    if ($mtype == 1) {
        $table = 'modals';
    } else if ($mtype == 2) {
        if ($file == 1) {
            $table = 'jquery';
        } else {
            $table = 'js';
        }
    } else if ($mtype == 3) {
        $table = 'sites';
    } else if ($mtype == 4) {
        $table = 'psd';
    } else if ($mtype == 12) {
        $table = 'tools';
    } else if ($mtype == 21) {
        $table = 'topic';
    }
    return $table;
}


function getTableField($field, $table) {
    $rs = F($field);
    if (empty($rs)) {
        $info = M($table)->field($field)->where("id = 1")->find();
        $rs = $info[$field];
    }
    return $rs;
}

function getTitleWidth($id) {
    if ($id == '9') {
        $width = "100";
    } else if ($id == '12') {
        $width = "135";
    }
    return $width > 0 ? "width:" . $width . "px" : "";
}

function getImplodeField($colors, $dictionary, $mtype = '1') {
    if ($colors) {
        $lists = M($dictionary)->field("name,id")->where("id in (" . $colors . ")")->select();
        $names = "";
        foreach ($lists as $v) {
            $names .= "<a href='" . __APP__ . "/" . getMtype($mtype) . "/0-" . $v['id'] . "-0-0-0-0' target='_blank'>" . $v['name'] . "</a>&nbsp;";
        }
        return $names;
    }
}

function getMtype($mtype) {
    if ($mtype == 2) {
        $rs = 'js';
    } elseif ($mtype == 3) {
        $rs = 'site';
    } elseif ($mtype == 4) {
        $rs = 'psd';
    } elseif ($mtype == 12) {
        $rs = 'tools';
    } elseif ($mtype == 21) {
        $rs = 'topic';
    } else {
        $rs = 'templates';
    }
    return $rs;
}

function getContent($content, $type) {
    if ($type == 1) {
        $rs = "<pre><code class='html'>" . htmlspecialchars($content) . "</code></pre>";
    } else if ($type == 2) {
        $rs = "<pre><code class='js'>" . htmlspecialchars($content) . "</code></pre>";
    } else if ($type == 3) {
        $rs = "<pre><code class='css'>" . htmlspecialchars($content) . "</code></pre>";
    } else if ($type == 4) {
        $rs = "<h3>" . $content . "</h3>";
    } else if ($type == 5) {
        $imgs = explode("|", $content);
        $id = I("get.id");
        $rs = "<div class='demo_image'><img src=" . __APP__ . "/jquery/" . getFileBei($id) . "/" . $id . "/demo/" . $imgs['0'] . " alt=" . $imgs['1'] . "></div>";
    } else if ($type == 6) {
        $rs = "<pre><code class='php'>" . htmlspecialchars($content) . "</code></pre>";
    } else {
        $rs = "<p>" . $content . "</p>";
    }
    return $rs;
}

function getUeditorContent($content) {
    $content = stripslashes($content);
    $content = str_replace('<pre class="brush:html;toolbar:false">', "<pre><code class='html'>", $content);
    $content = str_replace('<pre class="brush:php;toolbar:false">', "<pre><code class='php'>", $content);
    $content = str_replace('<pre class="brush:css;toolbar:false">', "<pre><code class='js'>", $content);
    $content = str_replace('<pre class="brush:js;toolbar:false">', "<pre><code class='css'>", $content);
    $content = str_replace('</pre>', "</code></pre>", $content);

    $tagsArr = array("code", "pre", "em", "b", "strong", "p", "br", "a", "span", "dd", "dl", "dt", "table", "tr", "th", "td", "thead", "tbody",
        "h1", "h2", "h3", "h4", "h5", "h5", "div", "i", "dfn", "u", "ins", "strike", "s", "del", "font", "hr", "center", "caption", "html", "body", "ul", "li", "ol", "select", "small", "input", "textarea"
    );
    $tags = "";
    foreach ($tagsArr as $v) {
        $tags .="<" . $v . ">";
    }
    return strip_tags($content, $tags);
}




function getTags($tags, $keyword_show, $mtype = 2) {
    $table = getTableInfo($mtype);
    if ($tags) {
        $lists = M("" . $table . "_tags")->field("name")->where("id in (" . $tags . ")")->cache(true)->select();
        $str = '';
        foreach ($lists as $v) {
            $style = '';
            if ($keyword_show != '' && strstr($keyword_show, $v['name'])) {
                $style = "style='color:red'";
            }
            if ($table == 'modals') {
                $table = 'templates';
            } else if ($table == 'sites') {
                $table = 'site';
            }
            $str .= "<a target='_blank' class='list-tag' " . $style . "  href='" . __APP__ . "/" . $table . "/tag-" . $v['name'] . ".html'>" . $v['name'] . "</a>";
        }
        return $str;
    }
}

function getServiceChinese($keyword) {
    if ($keyword && C("DB_USER") != 'root') {
        $keyword = iconv("gb2312", "UTF-8", $keyword);
    }
    return $keyword;
}

function getMtypeUrl($table) {
    if ($table == 'modals') {
        $table = 'templates';
    } else if ($table == 'sites') {
        $table = 'site';
    }
    return $table;
}

function getAddtimeSql() {
//    if (C("DB_PWD") != '') {
//        $time = time();
//        $sql = " AND addtime < " . $time . "";
//        return $sql;
//    }
}

function getMtypeInfo($id, $mtype) {
    $table = getTableInfo($mtype);
    if ($table != 'tools') {
        $detail = M($table)->field("name,tags,uid")->where("id = " . $id . "")->find();
        return $detail;
    }
}

function getMtypeField($id, $mtype, $field = 'name') {
    if ($id > 0) {
        $table = getTableInfo($mtype);
        $detail = M($table)->field($field)->where("id = " . $id . "")->find();
        return $detail[$field];
    }
}

function getMtypeHref($id, $mtype) {
    if ($mtype == 12) {
        $info = M("tools")->field("code")->cache(true)->where("id = '" . $id . "'")->find();
        $id = $info['code'];
    }
    return __APP__ . "/" . getMtype($mtype) . "/" . $id;
}

function getMtypeLogo($id, $mtype) {
    if ($mtype != 21) {
        return getModalsLogo($id, 'middle', getMtypeTable($mtype, 0));
    }
}

function getCommentToUser($id, $mtype, $pid) {
    if ($pid == 0) {
        $info = getMtypeInfo($id, $mtype);
    } else {
        $info = M("comment")->field("uid")->where("id = " . $pid . "")->find();
    }
    return array("nickname" => getUserName($info['uid']), "uid" => $info['uid']);
}

function getMtypeTitle($mtype) {
    if ($mtype == 2) {
        $rs = '网页特效';
    } elseif ($mtype == 3) {
        $rs = '精选网址';
    } elseif ($mtype == 4) {
        $rs = '网站psd';
    } else {
        $rs = '网站模板';
    }
    return $rs;
}

function setSessionCookie($k, $v) {
    session($k, $v);
    cookie($k, $v);
}

function getSessionCookie($k) {
    $s_k = session($k);
    $rs = $s_k ? $s_k : cookie($k);
    return $rs;
}

function emptySessionCookie($k) {
    session($k, null);
    cookie($k, null);
}

function getFieldThreeNamea($field) {
    if ($field == 'sina') {
        $rs = "新浪微博";
    } else if ($field == 'renren') {
        $rs = "人人网";
    } else if ($field == 'qq') {
        $rs = "腾讯微博";
    }
    return $rs;
}

function getMd5($str) {
    return md5(C('config.pwd') . $str);
}

function getDownloadUrl($id, $mtype) {
    return U('Download/zip', array('id' => $id, 'mtype' => $mtype, 'x' => getMd5($id . $mtype)));
}

function getParamThree($paramArr) {
    $param = "";
    $i = 0;
    foreach ($paramArr as $k => $v) {
        if ($i > 0) {
            $param .= "&" . $k . "=" . $v;
        } else {
            $param .= $k . "=" . $v;
        }
        $i++;
    }
    return $param;
}

function getDetailPage($id_get) {
    $id = strip_tags($id_get);
    if (strstr($id, "p-")) {
        $arr = explode("-", $id);
        $id = intval($arr[0]);
        $p = $arr[2] > 0 ? $arr[2] : 1;
    } else {
        $id = strip_tags(I("get.id"));
        $p = 1;
    }
    return array("id" => $id, "p" => $p);
}

function addMessage($type, $tid, $pid, $mtype, $touid, $content) {
    $userid = getUserid();
    if ($userid == '') {
        exit;
    }
    $format_type = "";
    if ($type == 'comment') {
        if ($pid > 0) {
            $format_type = "message";
        } else {
            $format_type = "reply";
        }
    }

    $data['type'] = $type;
    $data['tid'] = $tid;
    $data['pid'] = $pid; //留言id
    $data['mtype'] = $mtype;
    $data['uid'] = $userid;
    $data['touid'] = $touid;
    $data['format_type'] = $format_type;
    $data['addtime'] = time();
    $data['content'] = $content;
    M("messages")->add($data);
}

function getMessageFormat($format_type, $tid, $mtype, $content, $uid, $to_uid) {
    $table = getMtypeTable($mtype);
    $info = M($table)->field("name")->where("id = '" . $tid . "'")->find();
    $name = "<a href='" . getMtypeHref($tid, $mtype) . "' target='_blank'>" . $info['name'] . "</a>";
//    $username = "<a href='".__APP__."/space/uid/".$uid."' target='_blank'>" . getUserName($uid) . "</a>";
    $to_username = "<a href='" . __APP__ . "/space/uid/" . $to_uid . "' target='_blank'>" . getUserName($to_uid) . "</a>";
    if ($format_type == 'message') {
        $title = "在 " . $name . " 提到了你！";
        $content = "回复 " . $to_username . " : " . $content . "";
    } else if ($format_type == 'reply') {
        $title = "对 " . $name . " 给予评论: ";
    }
    return array("title" => $title, "content" => $content);
}

function formatBytes($size) {
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++)
        $size /= 1024;
    return round($size, 2) . $units[$i];
}

function getHref($siteUrl, $href) {

    $first = substr($href, 0, 1);
    $four = substr($href, 0, 4);
    $domainArr = array(".com", ".cn", ".net", ".cc", ".me", ".wang", ".org", ".info", ".so", ".tv", ".co", "http", "www", ".fm");
    $is_url = 0; //判断是否
    if ($href) {
        foreach ($domainArr as $v) {
            if (strstr($href, $v)) {
                $is_url ++;
            }
        }
    }

//    if (in_array($four, array("http")) || $is_url > 0) {
    if ($is_url > 0) {
        preg_match("#[\w-]+\.(com|net|org|gov|cc|biz|info|cn|co)(\.(cn|hk|uk))*#", $siteUrl, $match);
        preg_match("#[\w-]+\.(com|net|org|gov|cc|biz|info|cn|co)(\.(cn|hk|uk))*#", $href, $match2);

        $match = getUrlDomain($siteUrl);
        $match2 = getUrlDomain($href);
        if ($match != $match2) {
            return "domain";
            exit;
        }
    }
    if ($first == '/') {
        $href = $siteUrl . $href;
    } else {
        if ($four != 'http') {
            $href = $siteUrl . "/" . $href;
        }
    }

    return $href;
}

function getUrlDomain($url) {
    $pattern = "/[/w-]+/.(com|net|org|gov|biz|com.tw|com.hk|com.ru|net.tw|net.hk|net.ru|info|cn|com.cn|net.cn|org.cn|gov.cn|mobi|name|sh|ac|la|travel|tm|us|cc|tv|jobs|asia|hn|lc|hk|bz|com.hk|ws|tel|io|tw|ac.cn|bj.cn|sh.cn|tj.cn|cq.cn|he.cn|sx.cn|nm.cn|ln.cn|jl.cn|hl.cn|js.cn|zj.cn|ah.cn|fj.cn|jx.cn|sd.cn|ha.cn|hb.cn|hn.cn|gd.cn|gx.cn|hi.cn|sc.cn|gz.cn|yn.cn|xz.cn|sn.cn|gs.cn|qh.cn|nx.cn|xj.cn|tw.cn|hk.cn|mo.cn|org.hk|is|edu|mil|au|jp|int|kr|de|vc|ag|in|me|edu.cn|co.kr|gd|vg|co.uk|be|sg|it|ro|com.mo)(/.(cn|hk))*/";
    preg_match($pattern, $url, $matches);
    if (count($matches) > 0) {
        return $matches[0];
    } else {
        $rs = parse_url($url);
        $main_url = $rs["host"];
        if (!strcmp(long2ip(sprintf("%u", ip2long($main_url))), $main_url)) {
            return $main_url;
        } else {
            $arr = explode(".", $main_url);
            $count = count($arr);
            $endArr = array("com", "net", "org"); //com.cn net.cn 等情况  
            if (in_array($arr[$count - 2], $endArr)) {
                $domain = $arr[$count - 3] . "." . $arr[$count - 2] . "." . $arr[$count - 1];
            } else {
                $domain = $arr[$count - 2] . "." . $arr[$count - 1];
            }
            return $domain;
        }
    }
}

function getDescriptionFormat($con) {
    $con = htmlspecialchars_decode($con);
    $con = strip_tags($con, "<a><p><div><code><pre><b>");
    return $con;
}

function makeRequestWithFile($url, $params, $cookie, $protocol = 'http') {
    $cookie_string = self::makeCookieString($cookie);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);

    // disable 100-continue
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));

    if (!empty($cookie_string)) {
        curl_setopt($ch, CURLOPT_COOKIE, $cookie_string);
    }

    if ('https' == $protocol) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }

    $ret = curl_exec($ch);
    $err = curl_error($ch);

    if (false === $ret || !empty($err)) {
        $errno = curl_errno($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        return array(
            'result' => false,
            'errno' => $errno,
            'msg' => $err,
            'info' => $info,
        );
    }

    curl_close($ch);

    return array(
        'result' => true,
        'msg' => $ret,
    );
}

?>
