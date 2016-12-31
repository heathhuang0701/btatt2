<?php echo $header; ?>
<div class="allbox bg01">
	<div class="main_box">
		<h1><?php echo $class['title'];?></h1>
		<div class="team_box">
			<div class="left_box">
				<div class="people">
					<img src="<?php echo $class['image'];?>" alt="<?php echo $class['title'];?>">
				</div>
                <p></p>
				<a href="<?php echo $back;?>"><?php echo $text_back; ?></a>
			</div>
			<div class="right_box">
				<p><?php echo $class['info'];?></p>
                <hr />
				<?php echo $class['description']; ?>
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