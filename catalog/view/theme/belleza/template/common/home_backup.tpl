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
				<div class="pro_left">
				<?php echo $belleza_left; ?>
				</div>

				<div class="pro_right">
					<div class="probox_list">
                    	<?php 
                        if(count($features) > 0)
                        {
                        ?>
						<ul>
                        	<?php
                            foreach($features as $feature)
                            {
                            ?>
							<li>
								<img src="<?php echo $feature['thumb']; ?>" alt="<?php echo $feature['name']; ?>" title="<?php echo $feature['name']; ?>" />
								<h2><?php echo $feature['name']; ?></h2>
								<p><?php echo ($feature['special'])?$feature['special']:$feature['price']; ?></p>
								<a href="<?php echo $feature['href']; ?>" ><?php echo $button_product; ?></a><!--onclick="cart.add('<?php echo $feature['product_id']; ?>');"-->
							</li>
                            <?php
                            } 
                            ?>
						</ul>
                        <?php 
                        }
                        ?>
					</div>

					<div class="pro_logo">
                        <div id="carousel" class="owl-carousel">
                          <?php foreach ($firms as $firm) { ?>
                          <div class="item text-center">
                            <?php if ($firm['link']) { ?>
                            <a href="<?php echo $firm['link']; ?>"><img src="<?php echo $firm['image']; ?>" alt="<?php echo $firm['title']; ?>" title="<?php echo $firm['title']; ?>" class="img-responsive" /></a>
                            <?php } else { ?>
                            <img src="<?php echo $firm['image']; ?>" alt="<?php echo $firm['title']; ?>" class="img-responsive" />
                            <?php } ?>
                          </div>
                          <?php } ?>
                        </div>
					</div>		
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