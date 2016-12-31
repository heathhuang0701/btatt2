<?php echo $header; ?>
<div class="allbox bg01">
	<div class="main_box">
		<h1><?php echo $teacher['name'];?></h1>
		<div class="team_box">
			<div class="left_box">
				<div class="people">
					<img src="<?php echo $teacher['image'];?>" alt="<?php echo $teacher['name'];?>">
				</div>
				<p><?php echo $teacher['name'];?></p>
				<a href="<?php echo $back;?>"><?php echo $text_back; ?></a>
			</div>
			<div class="right_box">
				<p><?php echo $teacher['info'];?></p>
				<div class="work_img">
					<?php 
                    if(count($thumb)>0)
                    {
                    ?>
                    <ul class="thumbnails">
                    	<?php
                        foreach($thumb as $th)
                        { 
                        ?>
						<li><a class="thumbnail" href="<?php echo $th['popup']; ?>" title="<?php echo $th['info']; ?>"><img src="<?php echo $th['thumb']; ?>" ></a></li>
						<?php
                        }
                        ?>
					</ul>
                    <?php 
                    }
                    ?>
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