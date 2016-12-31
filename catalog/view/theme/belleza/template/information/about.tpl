<?php echo $header; ?>
<div class="allbox bg02">
	<div class="main_box">
		<h1><?php echo $text_about;?></h1>
		<div class="class_box">

		<div class="googlemap">
           <iframe src="https://www.google.com/maps/embed?pb=!1m0!3m2!1szh-TW!2stw!4v1473179174328!6m8!1m7!1sMkt5jFulEqMAAAQZHw5xfA!2m2!1d25.06713633414337!2d121.4756399036908!3f315!4f0!5f0.7820865974627469" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
		<div class="about_box">
			<?php echo $team_info; ?>
		</div>
		<div class="about_box">
			<?php echo $prod_info; ?>
		</div>
        
		<div class="mg_box">
			<form id="form1" method="POST" action="<?php echo $check;?>"> 
				<h1><?php echo $text_seek;?></h1>
				<div class="mg_left">
					<p><?php echo $entry_company; ?></p>
					<input type="text" name="company" value="" placeholder="<?php echo $entry_company; ?>" />
					<p><?php echo $entry_name; ?></p>
					<input type="text" name="name" value="" placeholder="<?php echo $entry_name; ?>" />
					<p><?php echo $entry_content; ?></p>
					<textarea name="content" id="contents" rows="5" cols="5" placeholder="<?php echo $entry_content; ?>"></textarea>
				</div>
				<div class="mg_right">
					<p><?php echo $entry_phone; ?></p>
					<input type="text" name="phone" value="" placeholder="<?php echo $entry_phone; ?>" />
					<p><?php echo $entry_code; ?></p>
					<input type="text" name="code" id="captha" class="verifyCode" placeholder="<?php echo $entry_code; ?>" value="">
					<div class="code_img verifyCodeImg">
						<img id="imgcode" src="system/engine/captcha.php" alt="<?php echo $entry_code;?>"> 
					</div>
					<a class="btnRefreshVerifyCode" href="javascript:void();" onclick="refresh_code();"><i class="icon-refresh"></i><?php echo $text_reset;?></a>
					<div class="mg_btn">
						<a onclick="$('#form1').submit();"><?php echo $button_check; ?></a>
						<a href="<?php echo $cancel;?>"><?php echo $button_cancel; ?></a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php echo $footer; ?>
<script>
function refresh_code()
{  
	$('#imgcode').attr('src',"system/engine/captcha.php?"+(new Date()).getTime());

} 
</script>