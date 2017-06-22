<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
        <title>PHP仿77素材评论系统</title>
        <link rel="shortcut icon" href="/jquery/8/816/demo/Public/images/favicon.ico" type="image/x-icon" /> 
        <link rel="stylesheet" href="/jquery/8/816/demo/Public/css/style.css" type="text/css" /> 

    </head> 
    <body>
        <div id="header" style="display:none;">
            <div class="tg_tools_home">
                <div class="logo">
                    <a class="logo-bd"  href="http://www.erdangjiade.com"><img src="/jquery/8/816/demo/Public/images/logo.png" alt="77素材logo"/></a>
                </div>
                <form action="http://www.erdangjiade.com/search.html" method="GET" id="form_search" onsubmit="return searchSub()">
                    <div id='search'>
                        <div class="search_area">
                            <input type='submit' value='搜 索' class='btn_search'/>
                            <div class="search_select">
                                <span class="icon-search"></span>
                            </div>
                            <input type='text' value='<?php echo ((isset($keyword) && ($keyword !== ""))?($keyword):"请输入搜索内容"); ?>'  class="search_input"  autocomplete="off" id="search_input" data-default="请输入搜索内容" onblur="checkInputBlur($(this))" onfocus="checkInputFocus($(this))" />
                            <input type="hidden" name="keyword"/>
                        </div>
                        <div class="search_box hide" id="search_box"></div>
                        <div class='search_keywords' >
                            <span>热门搜索：</span>
                            <a href="http://www.erdangjiade.com/search/search.html?keyword=手机" class="red">手机</a>
                            <a href="http://www.erdangjiade.com/js/8-0-0-0">导航菜单</a>
                            <a href="http://www.erdangjiade.com/search/search.html?keyword=bootstrap">bootstrap</a>
                            <a href="http://www.erdangjiade.com/search/search.html?keyword=后台">后台</a>
                            <a href="http://www.erdangjiade.com/search/search.html?keyword=上传"class="red">上传</a>
                            <a href="http://www.erdangjiade.com/search/search.html?keyword=购物车">购物车</a>
                            <a href="http://www.erdangjiade.com/js/106-0-0-0" class="red">日期时间</a>
                            <a href="http://www.erdangjiade.com/search/search.html?keyword=弹出层">弹出层</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id='nav' class='nav'>
            <div class='nav_main clearfix'>
                <a href='http://www.erdangjiade.com' class="menu<?php echo (getEqual($control,'index',' current')); ?>">首 页</a>
                <a href='http://www.erdangjiade.com/js' class="menu<?php echo (getEqual($control,'js',' current')); ?>">jQuery特效</a>
                <a href='http://www.erdangjiade.com/php' class="menu<?php echo (getEqual($control,'php',' current')); ?>">PHP</a>
                <a href='http://www.erdangjiade.com/templates' class="menu<?php echo (getEqual($control,'templates',' current')); ?>">网站模板</a>
                <span class='icon_hot'></span>
            </div>
        </div>
<div class="breadcrumbs">
    <span>&gt;</span><a href="/jquery/8/816/demo/js">网页特效</a>
</div>
<div  class="container clearfix">

    <div class="detail">
        <div class="detail_foot clearfix">
            <div class="comments">
                <div class="title">
                    评论<span class="num_area">（<em class="comments_num" id="comments_num"><?php echo ($comments_num); ?></em>）</span>
                </div>  

                <div class="comment_send clearfix">
                    <div class="comment_avatar">
                        <span class="userPic">
                            <img class='userPic avatar user_my_avatar' width="60" height="60" src="/jquery/8/816/demo/Public/images/avatar.jpg" alt="头像">
                        </span>
                        <font class="username"></font>
                    </div>
                    <div class="comment_sendPart" id='reply_0'>
                        <textarea id="textareaComment" class="textarea_comment" name="content"  autocomplete="off"  data-default="发布评论" onblur="checkInputBlur($(this))" onfocus="checkInputFocus($(this));
                        if ($(this).val() != '发布评论')
                            $(this).css({'color': '#333'})">发布评论</textarea>
                        <div class="btn_p clearfix">
                            <span class="comment_tip" id="comment_tip_0" data-top="11" data-foot="36"></span>
                            <button class="btn_subGrey btn" type="button" onclick="subcomment('<?php echo ($id); ?>', '<?php echo ($mtype); ?>', 0)">提 交</button>
                            <span class="emotion" tabindex="1" data-id='0'></span>
                        </div>
                    </div>
                </div>
                <div  class="comment_wrap" id="comment_wrap">
                    <ul class="comment_listBox">
                        <?php if(is_array($comments)): foreach($comments as $key=>$row): ?><li class="comment_list clearfix" id="comment_<?php echo ($row["id"]); ?>" <?php if($comments_num%10-1 == $key or $key%10 == 9): ?>style='border-bottom:none'<?php endif; ?>>
                            <div class="comment_avatar">
                                <span class='userPic'><img width="36" height="36" src="<?php echo (getUserAvatar($row["uid"])); ?>" alt="<?php echo ($row["uname"]); ?>头像"></span>
                                <span class="grey"><?php echo (getNumName($comments_num-$key-1)); ?></span>
                            </div>
                            <div class="comment_conBox">
                                <div class="comment_avatar_time">
                                    <div class="time"><?php echo (tranTime($row["addtime"])); ?></div> <?php echo (getUserName($row["uid"])); ?>
                                </div>
                                <div class="comment_conWrap clearfix">
                                    <div class="comment_action"><a class="reply" onclick="reply_btn('<?php echo ($row["id"]); ?>')">回复</a> </div>
                                    <div class="comment_con"><?php echo (getCommentContent($row["content"])); ?></div>
                                </div>
                                <div id='reply_<?php echo ($row["id"]); ?>' class='reply_area'>
                                    <textarea  class="textarea_comment" name="content" autocomplete="off"></textarea>
                                    <div class="btn_p clearfix">
                                        <span class="comment_tip" id="comment_tip_<?php echo ($row["id"]); ?>" data-top="4" data-foot="29"></span>
                                        <button class="btn_subGrey btn" onclick="subcomment('<?php echo ($id); ?>', '<?php echo ($mtype); ?>', '<?php echo ($row["id"]); ?>', 0)" type="button">提交</button>
                                        <span class="emotion" tabindex="1" data-id='<?php echo ($row["id"]); ?>'></span>
                                    </div>
                                </div>
                                <div class="blockquote_wrap">
                                    <?php if(is_array($row['sub'])): foreach($row['sub'] as $key2=>$row2): ?><blockquote class="comment_blockquote">
                                            <div class="comment_floor"><?php echo ($key2+1); ?></div>
                                            <div class="comment_conWrap clearfix">
                                                <div class="comment_con">
                                                    <?php echo (getUidUrl($row2["uid"])); ?>：
                                                    <p><?php echo (getTan($row2["pid_sub"])); echo (getCommentContent($row2["content"])); ?></p>

                                                </div>
                                                <div class="comment_action_sub">
                                                    <a class="reply" onclick="reply_btn('<?php echo ($row2["id"]); ?>')">回复</a>
                                                </div>
                                            </div>
                                            <div id="reply_<?php echo ($row2["id"]); ?>" class="reply_area">
                                                <textarea class="textarea_comment" autocomplete="off" name="content"></textarea>
                                                <div class="btn_p clearfix">
                                                    <span id="comment_tip_<?php echo ($row2["id"]); ?>" class="comment_tip" data-foot="29" data-top="4"></span>
                                                    <button class="btn_subGrey btn" type="button" onclick="subcomment('<?php echo ($id); ?>', '<?php echo ($mtype); ?>', '<?php echo ($row["id"]); ?>', '<?php echo ($row2["id"]); ?>')">提交</button>
                                                    <span class="emotion" data-id="<?php echo ($row2["id"]); ?>" tabindex="<?php echo ($row2["id"]); ?>"></span>
                                                </div>
                                            </div>
                                        </blockquote><?php endforeach; endif; ?>
                                </div>
                            </div>
                            </li><?php endforeach; endif; ?>
                    </ul>
                    <?php if($comments_num > 10): ?><div class="pager" id="detail-page" data-id="<?php echo ($id); ?>" data-mtype='<?php echo ($mtype); ?>' data-totalnum="<?php echo ($comments_num); ?>"><?php echo ($page); ?></div><?php endif; ?>
                </div>
            </div>
        </div>
        <div class="smileBoxOuter" id="smileBoxOuter" tabindex="2">
            <ul class="smileBox">
                <?php if(is_array($emots)): foreach($emots as $key=>$row): if($key < 44): ?><li><a href="javascript:void(0)" class="smile<?php echo ($row["id"]); ?>" title="<?php echo ($row["name"]); ?>"></a></li><?php endif; endforeach; endif; ?>
            </ul>
            <ul class="smileBox" style="display:none;">
                <?php if(is_array($emots)): foreach($emots as $key=>$row): if($key > 44): ?><li><a href="javascript:void(0)" class="smile<?php echo ($row["id"]); ?>" title="<?php echo ($row["name"]); ?>"></a></li><?php endif; endforeach; endif; ?>
            </ul>
            <div class="smilePage">
                <a href="javascript:void(0)" class="current">1</a>
                <a href="javascript:void(0)">2</a>
            </div>
        </div>    
    </div>
</div>
<div class="footer" id="footer" data-url="/jquery/8/816/demo/" data-logout="/jquery/8/816/demo/Download/logout?r=<?php echo ($url_cur); ?>" data-id="<?php echo ($id); ?>" data-mtype="<?php echo ($mtype); ?>"> 
    <div class="footer_main clearfix">
        <div class="guide">
            <span class="guide_icon"></span>
            <ul class="ul_foot">
                <li><strong>网站模板</strong></li>
                <li><a href="/jquery/8/816/demo/templates/3-0-0-0-0-0">行业模板</a><a href="/jquery/8/816/demo/templates/7-0-0-0-0-0">专题模板</a></li>
                <li><a href="/jquery/8/816/demo/templates/4-0-0-0-0-0">商城模板</a><a href="/jquery/8/816/demo/templates/8-0-0-0-0-0">后台模板</a></li>
                <li><a href="/jquery/8/816/demo/templates/5-0-0-0-0-0">企业模板</a><a href="/jquery/8/816/demo/templates/9-0-0-0-0-0">其他模板</a></li>
                <li><a href="/jquery/8/816/demo/templates/31-0-0-0-96-0">求职招聘</a><a href="/jquery/8/816/demo/templates/22-0-0-0-96-0">订餐外送</a></li>
                <li><a href="/jquery/8/816/demo/templates/69-0-0-0-0-0">个人博客</a><a href="/jquery/8/816/demo/templates/0-0-0-0-96-0">中文模板</a></li>
            </ul>
        </div>
        <div class="stores">
            <span class="stores_icon"></span>
            <ul class="ul_foot">
                <li><strong>jquery特效</strong></li>
                <li><a href="/jquery/8/816/demo/js/7-0-0-0">图片代码</a><a href="/jquery/8/816/demo/js/7-0-0-0">悬浮层/弹出层</a></li>
                <li><a href="/jquery/8/816/demo/js/8-0-0-0">导航菜单</a><a href="/jquery/8/816/demo/js/14-0-0-0">其它特效</a></li>
                <li><a href="/jquery/8/816/demo/js/9-0-0-0">选项卡/滑动门</a><a href="/jquery/8/816/demo/js/53-0-0-0">PHP+Ajax</a></li>
                <li><a href="/jquery/8/816/demo/js/11-0-0-0">表单代码</a><a href="/jquery/8/816/demo/js/128-0-0-0">jQuery插件</a></li>
            </ul>
        </div>
        <div class="rebate">
            <span class="rebate_icon"></span>
            <ul class="ul_foot">
                <li><strong>推荐jQuery</strong></li>
                <li><a href="http://www.erdangjiade.com/js/177.html">datepicker</a><a href="http://www.erdangjiade.com/js/44.html">flowplayer</a></li>
                <li><a href="http://www.erdangjiade.com/js/1.html">jQuery购物车</a><a href="http://www.erdangjiade.com/js/85.html">jquery表单验证</a></li>
                <li><a href="http://www.erdangjiade.com/js/200.html">lightbox</a><a href="http://www.erdangjiade.com/js/125.html">jquery滚动条</a></li>
                <li><a href="http://www.erdangjiade.com/js/45.html">fancybox</a><a href="http://www.erdangjiade.com/js/268.html">WebUploader</a></li>
                <li><a href="http://www.erdangjiade.com/js/107.html">fullcalendar</a><a href="http://www.erdangjiade.com/js/3.html">上传</a></li>
            </ul>
        </div>
        <div class="follow">
            <span class="follow_icon"></span>
            <ul>
                <li>
                    <strong>联系我们</strong>
                </li>
                <li>
                    <a  class="qq-chat" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo (C("qq")); ?>&site=qq&menu=yes" target="_blank">
                        <img alt="QQ在线客服" src="/jquery/8/816/demo/Public/images/qq-chat.png">
                    </a>

                </li>
                <li>qq群：35291327</li>
                <li>邮箱：<?php echo (C("qq")); ?>@qq.com</li>
                <li>手机：18005151538</li>
            </ul>
        </div>
        <div class="friendly">
            <?php if(!empty($friends)): ?><div class="link_exchange">
                    <strong>友情链接：</strong>
                    <?php if(is_array($friends)): foreach($friends as $key=>$row): ?><a target="_blank" href="<?php echo ($row["url"]); ?>"><?php echo ($row["name"]); ?></a><?php endforeach; endif; ?>
                </div><?php endif; ?>
            <div class="foot_menu">
                <a href="/jquery/8/816/demo/help/template" target="_blank">扒模板</a>
                <a href="/jquery/8/816/demo/help/contact" target="_blank">联系我们</a>
                <a href="/jquery/8/816/demo/help/index" target="_blank">关于我们</a>
                <a href="/jquery/8/816/demo/help/job" target="_blank">招纳贤士</a>
                <a href="/jquery/8/816/demo/sitemap.html" target="_blank">网站地图</a>
                <span class="address">Copyright&copy;2010-2015 All Rights Reserved. 苏ICP备15009298</span>
            </div>
        </div>
    </div>
</div>

<div id="windown_box" class="modal fade">
    <div class="pop_title">
        <div class="pop_name">登录</div>
        <i class="pop_close" onclick="$('#windown_box').modal('hide')"></i>
    </div>
    <div class="pop_content">
        <div class="form_item">
            <div class="item_tip">用户名/邮箱</div>
            <input id="email" name="email"  class="form_input" type="text" autocomplete="off" tabindex="1" value="" onblur="blurInputLoginBox($(this))"  onfocus ="focusInputLoginBox($(this))"/>
        </div>
        <div class="form_item">
            <div class="item_tip">密码</div>
            <input name="pwd" id="pwd"class="form_input" type="password" tabindex="2" value="" onblur="blurInputLoginBox($(this))"  onfocus ="focusInputLoginBox($(this))" />
        </div>
        <div class="captchaBox">
            <div class="two_weeks">
                <input id="rememberme" class="ckeckBox" type="checkbox" name="rememberme">
                <label for="rememberme">两周内免登录</label>
                <a  href="/jquery/8/816/demo/reg.html" target="_blank" class="loginbox_reg">免费注册</a>
            </div>
        </div>
        <p class="notice_error"></p>
        <input id="btn_login" class="btn" type="button" onclick="sublogin()" tabindex="4" value="登  录">
        <a class="a_underline" href="/jquery/8/816/demo/forget.html">忘记密码？</a>
        <div class="co_login" style="margin:20px 0 0">
            联合登录
            <a class="a_underline" href="/jquery/8/816/demo/Index/login/type/qq.html">腾讯QQ</a>
            <a class="a_underline" href="/jquery/8/816/demo/Index/login/type/sina.html">新浪微博</a>
            <a class="a_underline" href="/jquery/8/816/demo/Index/login/type/renren.html">人人网</a>
            绑定送<span class="red">200</span>积分
        </div>
    </div>
</div>
<script src="/jquery/8/816/demo/Public/js/jquery.js" type="text/javascript"></script>
<script src="/jquery/8/816/demo/Public/js/common.js" type="text/javascript"></script>
</body>
</html>