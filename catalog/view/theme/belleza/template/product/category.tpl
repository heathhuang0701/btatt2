<?php echo $header; ?>

<div class="allbox">
	<div class="main_box">
		<div class="pro_main">
			<div class="pro_all">
                <ul class="breadcrumb">
                    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                    <?php } ?>
                </ul>
				<div class="pro_left">
					<?php echo $belleza_left; ?>
				</div>
				<div class="pro_right">
					<div class="pro_infobox">
                    	<h2><?php echo $heading_title; ?></h2>
                    
					
                      <?php if ($thumb || $description) { ?>
                      <div class="row">
                        <?php if ($thumb) { ?>
                        <div class="col-sm-2"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="img-thumbnail" /></div>
                        <?php } ?>
                        <?php if ($description) { ?>
                        <div class="col-sm-10"><?php echo $description; ?></div>
                        <?php } ?>
                      </div>

                      <?php } ?>
                      
                      <?php if ($categories) { ?>
                      <h2><?php echo $text_refine; ?></h2>
                      <?php if (count($categories) <= 5) { ?>
                      <div class="row">
                        <div class="col-sm-3">
                          <ul>
                            <?php foreach ($categories as $category) { ?>
                            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                            <?php } ?>
                          </ul>
                        </div>
                      </div>
                      <?php } else { ?>
                      <div class="row">
                        <?php foreach (array_chunk($categories, ceil(count($categories) / 4)) as $categories) { ?>
                        <div class="col-sm-3">
                          <ul>
                            <?php foreach ($categories as $category) { ?>
                            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                            <?php } ?>
                          </ul>
                        </div>
                        <?php } ?>
                      </div>
                      <?php }
                      } 
                      ?>
                        <div class="row">
                        	<div class="col-md-6">
                            	<label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
                        		<select id="input-sort" class="form-control" onchange="location = this.value;">
                        		<?php foreach ($sorts as $sorts) { ?>
                        		<?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                        			<option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
                        			<?php } else { ?>
                        			<option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                        		<?php } ?>
                        		<?php } ?>
                        		</select>
                            </div>
                            <div class="col-md-6">
                            	<label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
                        		<select id="input-limit" class="form-control" onchange="location = this.value;">
                                    <?php foreach ($limits as $limits) { ?>
                                    <?php if ($limits['value'] == $limit) { ?>
                                    <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                                <?php } ?>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
      				

                        <div class="probox_list">
                            <?php 
                            if(count($products) > 0)
                            {
                            ?>
                            <ul>
                                <?php
                                foreach($products as $product)
                                {
                                ?>
                                <li>
                                    <img onclick="prod('<?php echo $product['href']; ?>');" src="<?php echo $product['thumb']; ?>" alt="<?php echo utf8_substr($product['name'],0,20).'..'; ?>" title="<?php echo $product['name']; ?>" width="300" height="200" />
                                    <h2><?php echo $product['name']; ?></h2>
                                    <p><?php echo ($product['special'])?$product['special']:$product['price']; ?></p>
                                    <a href="<?php echo $product['href']; ?>" ><?php echo $button_product; ?></a>
                                </li>
                                <?php
                                } 
                                ?>
                            </ul>
                            <?php 
                            }
                            ?>
                        </div>
                        <?php
                        if(isset($kvbar))
                        {
                        ?>
                        <div class="reimg">
                            <a href="<?php echo $kvbar['link']; ?>" target="_blank"><img src="<?php echo $kvbar['image']; ?>" alt="<?php echo $kvbar['title']; ?>" title="<?php echo $kvbar['title']; ?>" /></a>
                        </div>
                        <?php
                        }
                        ?>
                        <?php if(isset($pagination)) { ?>
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
                            <?php echo $results; ?>
                        </div>
                        <?php } ?>
                     </div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php echo $footer; ?>
<script>
function prod(href)
{
	location.href = href;
}
</script>
