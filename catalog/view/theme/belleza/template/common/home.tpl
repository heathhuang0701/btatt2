<?php echo $header; ?>

<div class="allbox">
	<div class="main_box">
		<div class="pro_main">
			<div class="pro_top">
                <div id="slideshow" style="opacity: 1;">
                    <?php foreach ($banners as $banner) { ?>
                    <div class="item">
                    	<?php if ($banner['link']) { ?>
                    	<a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
                    	<?php } else { ?>
                    	<img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
                    	<?php } ?>
                    </div>
                    <?php } ?>
                </div>
			</div>

			<div class="pro_all">
			<h3>ALL PRODUCTS  產品分類</h3>
				<div class="newpro">
					<?php 
					foreach($categories as $key=>$category)
					{
						if($key%3 == 0) echo '<ul>';
					?>
					<li class="newpro_item">
						<a href="<?php echo $category['href']; ?>">
							<div>
								<img src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>">
							</div>
							<h4><?php echo $category['name']; ?></h4>
							<p>
							<?php 
							if(count($category['children']) > 0)
							{
								foreach($category['children'] as $child)
								{
									echo '<a href="'.$child['href'].'">'.$child['name'].'</a><br />';
								}
							}
							?>
							</p>	
						</a>
					</li>
					<?php
						if($key%3 == 2 || count($categories)-1 == $key) echo '</ul>';
					}
					?>	
				</div>
			</div>
		</div>
	</div>
</div>

<?php echo $footer; ?>
<script type="text/javascript">
<!--
$('#slideshow').owlCarousel({
	items: 6,
	autoPlay: 3000,
	singleItem: true,
	navigation: true,
	navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
	pagination: true
});

$('#carousel').owlCarousel({
	items: 6,
	autoPlay: 3000,
	navigation: true,
	navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
	pagination: true
});

setTimeout('turn()',5000);
function turn()
{
	$('.bx-next').click();
	setTimeout('turn()',5000);
}

-->
</script>