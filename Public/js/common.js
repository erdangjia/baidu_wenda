$(function() {
    isLogin();
    var site_url = $("#footer").attr("data-url");
    /**表情***/
    if ($(".emotion").length > 0) {
        $(".emotion").click(function() {
            var left = $(this).offset().left;
            var top = $(this).offset().top;
            var id = $(this).attr("data-id");
            $("#smileBoxOuter").css({
                "left": left,
                "top": top + 20
            }).show().attr("data-id", id)
        });
        $("#smileBoxOuter,.emotion").hover(function() {
            $("#smileBoxOuter").attr("is-hover", 1)
        },
                function() {
                    $("#smileBoxOuter").attr("is-hover", 0)
                });
        $(".emotion,#smileBoxOuter").blur(function() {
            var is_hover = $("#smileBoxOuter").attr("is-hover");
            if (is_hover != 1) {
                $("#smileBoxOuter").hide()
            }
        });
        $(".smileBox").find("a").click(function() {
            var textarea_id = $("#smileBoxOuter").attr("data-id");
            var textarea_obj = $("#reply_" + textarea_id).find("textarea");
            var textarea_val = textarea_obj.val();
            if (textarea_val == "发布评论") {
                textarea_obj.val("")
            }
            var title = "[" + $(this).attr("title") + "]";
            textarea_obj.val(textarea_obj.val() + title).focus();
            $("#smileBoxOuter").hide()
        });
        $("#smileBoxOuter").find(".smilePage").children("a").click(function() {
            $(this).addClass("current").siblings("a").removeClass("current");
            var index = $(this).index();
            $("#smileBoxOuter").find(".smileBox").eq(index).show().siblings(".smileBox").hide()
        });
        $(".comment_blockquote").hover(function() {
            $(".comment_action_sub").css({
                "visibility": "hidden"
            });
            $(this).find(".comment_action_sub").css({
                "visibility": "visible"
            })
        }, function() {
            $(".comment_action_sub").css({
                "visibility": "hidden"
            })
        })
    }
    if ($("#detail-page").length > 0) {
        var id = $("#detail-page").attr("data-id");
        var mtype = $("#detail-page").attr("data-mtype");
        var totalnum = $("#detail-page").attr("data-totalnum");
        $("#comment_wrap").on("click",".pager a",function(){
             var page = parseInt($(this).attr("data-page"));
            $("#detail-page").children("a").removeClass("current");
            $("#detail-page").children("a").eq(page - 1).addClass("current");
            $("#comment_wrap").html("<div style='padding:20px 0;text-align:center;'><img src='" + site_url + "Public/images/loading.gif'></div>");
            $.get(getUrl("Box/comments"), {
                p: page,
                id: id,
                totalnum: totalnum,
                mtype: mtype
            },
            function(data) {
                $("#comment_wrap").html(data)
            })
        })
    }
});
function getUrl(strs) {
    var url = $("#footer").attr("data-url") + strs;
    return url
}
function goUrl(url) {
    if (url == -1) {
        history.go(-1)
    } else {
        document.location.href = url
    }
}
function showWindowBox() {
    $("#windown_box").modal("toggle")
}
function hideWindowBox() {
    $("#windown_box").modal("hide")
}
function animateShowTip(obj, tip) {
    obj.text(tip);
    var top = obj.attr("data-top");
    obj.animate({
        top: top,
        "height": "16px"
    },
    500)
}
function animateHideTip(obj) {
    var foot = obj.attr("data-foot");
    obj.animate({
        top: foot,
        "height": "0"
    },
    500)
}
function subcomment(id, mtype, pid, pid_sub) {
    var pid_common = pid;
    if (pid_sub > 0) {
        pid_common = pid_sub
    }
    var textarea_obj = $("#reply_" + pid_common).find("textarea");
    var comment = textarea_obj.val();
    comment = comment == "发布评论" ? "" : comment;
    if (comment == "") {
        animateShowTip($("#comment_tip_" + pid_common), "您是不是忘了说点什么？");
        setTimeout("animateHideTip($('#comment_tip_" + pid_common + "'))", 3000);
        return false
    }
//    comment = encodeURIComponent(comment);

    $.post(getUrl("Ajax/subcomment"), {
        id: id,
        mtype: mtype,
        content: comment,
        pid: pid,
        pid_sub: pid_sub
    },
    function(data) {
        var li = "";
        if (data.code == -1) {
            showWindowBox();
            $("#windown_box").attr("data-func", "subcomment('" + id + "', '" + mtype + "', '" + pid + "', '" + pid_sub + "')")
        } else {
            if (data.code == 200) {
                var username = $(".comment_avatar").find(".username").text();
                if (pid_common == 0) {
                    var num = parseInt($("#comments_num").text());
                    $("#comments_num").text(num + 1);
                    var avatar = $(".comment_avatar").find(".avatar").attr("src");
                    var lou_tip = "";
                    if (num == 0) {
                        lou_tip = "沙发"
                    } else {
                        if (num == 1) {
                            lou_tip = "椅子"
                        } else {
                            if (num == 2) {
                                lou_tip = "板凳"
                            } else {
                                lou_tip = num + "楼"
                            }
                        }
                    }
                    li = "<li class='comment_list clearfix'><div class='comment_avatar'><span class='userPic'>\n<img width='36' height='36' src='" + avatar + "'></span><span class='grey'>" + lou_tip + "</span></div>\n<div class='comment_conBox'><div class='comment_avatar_time'><div class='time'>刚刚</div>" + username + "</div>\n<div class='comment_conWrap clearfix'><div class='comment_con'>" + data.comment + "</div></div></div></li>";
                    $(".comment_listBox").prepend(li)
                } else {
                    var length_reply = parseInt($("#comment_" + pid_common).find(".comment_blockquote").length);
                    li = "<blockquote class='comment_blockquote'><div class='comment_floor'>" + (length_reply + 1) + "</div><div class='comment_conWrap'>\n<div class='comment_con'>" + username + "：<p> " + data.comment + "</p></div></div></blockquote>";
                    $("#comment_" + pid).find(".blockquote_wrap").append(li);
                    $("#reply_" + pid).hide();
                    if (pid_sub > 0) {
                        $("#reply_" + pid_sub).hide()
                    }
                }
                if (data.points > 0) {
                    showSuccessTip("评论成功，获得" + data.points + "积分！")
                } else {
                    showSuccessTip("评论成功！")
                }
                textarea_obj.val("")
            } else {
                animateShowTip($("#comment_tip_" + pid_common), data.error);
                setTimeout("animateHideTip($('#comment_tip_" + pid_common + "'))", 3000)
            }
        }
    },"json")
}
function isLogin() {
    var mtype = $("#footer").attr("data-mtype");
    var id = $("#footer").attr("data-id");
    $.post(getUrl("Ajax/isLogin"), {
        mtype: mtype,
        id: id
    },
    function(data) {
        loginSuccess(data)
    }, "json")
}
function loginSuccess(data) {
    var username = data.username;
    if (username) {
        $(".username").text(username);
        $(".avatar").attr("src", data.avatar);
        $(".haslogin").removeClass("hide");
        $(".nologin").addClass("hide");
        if (data.is_collect == 1) {
            $(".poster_likes ").children(".like_status").addClass("lm_liked").removeClass("lm_like")
        }
        if (data.msg_num > 0) {
            $("#msg_notify").html("<em>" + data.msg_num + "</em>");
        }
        hideWindowBox();
        var func = $("#windown_box").attr("data-func");
        if (func) {
            eval(func)
        }
        $("#nav_login").remove();
        setInterval("getMsgNum()", 500000);//500秒请求一次
        if ($("#topic-edit").length > 0) {
            var uid_detail = $("#topic-edit").attr("data-uid");
            if (data.userid == uid_detail) {
                $("#topic-edit").show();
            }
        }

    }
    $("#login_area").slideToggle();
}
function reply_btn(id) {
    $(".reply_area").hide();
    $("#reply_" + id).slideToggle(500, function() {
        $("#reply_" + id).find("textarea").focus()
    })
}
function hideMsgBox() {
    $("#msg-box").fadeOut()
}
function showSuccessTip(data) {
    $("#msg-box").show();
    $("#msg-box-content").html(data);
    setTimeout("hideMsgBox()", 2000)
}
function checkInputBlur(obj) {
    var default_words = obj.attr("data-default");
    if (obj.val() == "") {
        obj.val(default_words);
        obj.css({
            "color": "#a9a9a9"
        })
    }
}
function checkInputFocus(obj) {
    var default_words = obj.attr("data-default");
    if (obj.val() == default_words) {
        obj.val("").css({
            "color": "#333333"
        })
    }
}