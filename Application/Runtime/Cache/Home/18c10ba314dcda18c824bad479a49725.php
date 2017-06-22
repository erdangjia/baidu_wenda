<?php if (!defined('THINK_PATH')) exit();?><ul class="comment_listBox">
    <?php if(is_array($comments)): foreach($comments as $key=>$row): ?><li class="comment_list clearfix" id="comment_<?php echo ($row["id"]); ?>" <?php if($comments_num%10-1 == $key or $key%10 == 9): ?>style='border-bottom:none'<?php endif; ?>>
        <div class="comment_avatar">
            <span class='userPic'><img width="36" height="36" src="http://www.erdangjiade.com/Public/images/avatar.jpg" alt="<?php echo ($row["uname"]); ?>头像"></span>
            <span class="grey"><?php echo (getNumName($comments_num-$key-1)); ?></span>
        </div>
        <div class="comment_conBox">
            <div class="comment_avatar_time">
                <div class="time"><?php echo (tranTime($row["addtime"])); ?></div> <?php echo (getUserName($row["uid"])); ?>
            </div>
            <div class="comment_conWrap clearfix">
                <div class="comment_action"><a class="reply" onclick="reply_btn('<?php echo ($row["id"]); ?>')">回复</a> </div>
                <div class="comment_con"><?php echo (stripslashes($row["content"])); ?></div>
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
                                <p><?php echo (getTan($row2["pid_sub"])); echo (stripslashes($row2["content"])); ?></p>

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
<div class="pager" id="detail-page" data-id="<?php echo ($id); ?>" data-mtype='<?php echo ($mtype); ?>' data-totalnum="<?php echo ($comments_num); ?>"><?php echo ($page); ?></div>