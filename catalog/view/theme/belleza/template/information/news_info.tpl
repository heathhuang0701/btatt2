<?php echo $header; ?>
<div class="allbox bg01">
	<div class="main_box">
		<h1><?php echo $news['title'];?></h1>
		
		<div class="team_box">
			<div class="left_box">
				<h3>公告時間: <?php echo $news['time']; ?></h3>
				<a href="<?php echo $back;?>"><?php echo $text_back; ?></a>
			</div>
			<div class="right_box">
				<?php echo $news['content']; ?>
				</div>	
			</div>
		</div>
	</div>
</div>
<script>
<!--
$(document).ready(function() {
	$('.thumbnails').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery: {
			enabled:true
		}
	});
});
-->
</script>


<?php echo $footer; ?>