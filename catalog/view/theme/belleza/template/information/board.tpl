<?php echo $header; ?>
<div class="allbox bg01">
	<div class="main_box">
		<h1>刺客留言 Q&A</h1>
		<div class="class_box">
        <form method="POST" action="<?php echo $submit; ?>" name="form" id="form1" />
		<div class="mg_box">
			<div class="mg_left">
                <p><?php echo $entry_name; ?></p>
                <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" />
                <p><?php echo $entry_email; ?></p>
                <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" />
                <p><?php echo $entry_code; ?></p>
                <input type="text" name="code" id="captha" class="verifyCode" placeholder="<?php echo $entry_code; ?>" value="">
                <div class="code_img verifyCodeImg">
                    <img id="imgcode" src="system/engine/captcha.php" alt="<?php echo $entry_code;?>"> 
                </div>
                <a class="btnRefreshVerifyCode" href="javascript:void();" onclick="refresh_code();"><i class="icon-refresh"></i><?php echo $text_reset;?></a>
			</div>
			<div class="mg_right">
                <p><?php echo $entry_title; ?></p>
                <input type="text" name="title" id="title" placeholder="<?php echo $entry_title; ?>" value="<?php echo $title; ?>" />
                <p><?php echo $entry_content; ?></p>
                <textarea name="content" id="contents" placeolder="<?php echo $entry_content; ?>" ><?php echo $content; ?></textarea>
                <a onclick="$('#form1').submit();"><?php echo $text_submit; ?></a>
			</div>
		</div>
        </form>

        <div class="mg_main">
            <h2><?php echo $text_board; ?></h2>
                <?php 
                if($boards)
                {
                    foreach($boards as $board)
                    {
                ?>
                <div class="mg_mg">
                    <div class="mgmg_left"><p><?php echo $board['name']; ?></p></div>
                    <div class="mgmg_right">
                        <div class="mg_text">
                            <img src="img/aron.png">
                            <h3><?php echo $board['title']; ?></h3>
                            <span><?php echo $board['time']; ?></span>
                            <p><?php echo nl2br($board['content']); ?></p>
                            <?php 
                            if($board['reply'] != '')
                            {
                            ?>
                            <p style="color:#F00;"><?php echo $text_rely;?></p>
                            <p style="color:#F00;"><?php echo $board['reply']; ?></p>
                            <span><?php echo nl2br($board['reply_time']); ?></span>
                            <p></p>
                        <?php
                        }
                        ?>
						</div>
					</div>
				</div>
                <?php
                    }
                }
                ?>
        </div>
    	<?php if(isset($pagination)) {
        ?>
        <div class="list_btn">
            <ul>
                <li <?php if(!isset($pagination['last'])) echo 'style="display:none;"'; ?>><a href="<?php echo (isset($pagination['last']))?$pagination['last']:''; ?>"></a></li>
                <?php 
                foreach($pagination['num'] as $k => $p)
                {
                ?>
                    <li><a href="<?php echo $p; ?>"><?php echo $k; ?></a></li>
                <?php
                }
                for($i=1;$i<=$pgcnt;$i++)
                {
                ?>
                    <li style="display:none;"><a href="#"><?php echo $i; ?></a></li>
                <?php
                }
                ?>
                <li <?php if(!isset($pagination['next'])) echo 'style="display:none;"'; ?>><a href="<?php echo (isset($pagination['next']))?$pagination['next']:''; ?>"></a></li>
            </ul>
        </div>
        <?php } ?>
	</div>
</div>
<?php echo $footer; ?>
<script>
function refresh_code()
{  
	$('#imgcode').attr('src',"system/engine/captcha.php?"+(new Date()).getTime());

} 
</script>