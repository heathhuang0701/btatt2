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
                    </div>
					<div class="row">
						<div id="content" class="col-sm-9" style="min-height:0px;">
						  <label class="control-label" for="input-search"><?php echo $entry_search; ?></label>
						  <div class="row">
							<div class="col-sm-4">
							  <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search" class="form-control" />
							</div>
							<div class="col-sm-3">
							  <select id="cate_id" name="category_id" class="form-control">
								<option value="0"><?php echo $text_category; ?></option>
								<?php foreach ($categories as $category_1) { ?>
								<?php if ($category_1['category_id'] == $category_id) { ?>
								<option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
								<?php } else { ?>
								<option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
								<?php } ?>
								<?php foreach ($category_1['children'] as $category_2) { ?>
								<?php if ($category_2['category_id'] == $category_id) { ?>
								<option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
								<?php } else { ?>
								<option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
								<?php } ?>
								<?php foreach ($category_2['children'] as $category_3) { ?>
								<?php if ($category_3['category_id'] == $category_id) { ?>
								<option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
								<?php } else { ?>
								<option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
								<?php } ?>
								<?php } ?>
								<?php } ?>
								<?php } ?>
							  </select>
							</div>
							<div class="col-sm-3">
							  <label class="checkbox-inline">
								<?php if ($sub_category) { ?>
								<input type="checkbox" name="sub_category" value="1" checked="checked" />
								<?php } else { ?>
								<input type="checkbox" name="sub_category" value="1" />
								<?php } ?>
								<?php echo $text_sub_category; ?></label>
							</div>
						  </div>
						  <p>
							<label class="checkbox-inline">
							  <?php if ($description) { ?>
							  <input type="checkbox" name="description" value="1" id="description" checked="checked" />
							  <?php } else { ?>
							  <input type="checkbox" name="description" value="1" id="description" />
							  <?php } ?>
							  <?php echo $entry_description; ?></label>
						  
							  <input type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn btn-primary" />
						  </p>
						</div>
					</div>


				  <div class="row">
					<div class="col-sm-3 hidden-xs">
					 
					</div>
					<div class="col-sm-1 col-sm-offset-2 text-right">
					  <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
					</div>
					<div class="col-sm-3 text-right">
					  <select id="input-sort" class="form-control col-sm-3" onchange="location = this.value;">
						<?php foreach ($sorts as $sorts) { ?>
						<?php if ($sorts['value'] == $sort . '-' . $order) { ?>
						<option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
						<?php } ?>
						<?php } ?>
					  </select>
					</div>
					<div class="col-sm-1 text-right">
					  <label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
					</div>
					<div class="col-sm-2 text-right">
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
								<img onclick="prod('<?php echo $product['href']; ?>');" src="<?php echo $product['thumb']; ?>" alt="<?php echo utf8_substr($product['name'],0,20).'..'; ?>" title="<?php echo $product['name']; ?>" />
								<h2><?php echo $product['name']; ?></h2>
								<p><?php echo ($product['special'])?$product['special']:$product['price']; ?></p>
								<a href="<?php echo $product['href']; ?>" ><?php echo $button_product; ?></a><!--onclick="cart.add('<?php echo $feature['product_id']; ?>');"-->
							</li>
							<?php
							} 
							?>
						</ul>
						<?php 
						}
						?>
					</div>
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

<script type="text/javascript"><!--
$('#button-search').bind('click', function() {
	url = 'index.php?route=product/search';

	var search = $('#content input[name=\'search\']').prop('value');

	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').prop('value');

	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}

	var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');

	if (sub_category) {
		url += '&sub_category=true';
	}

	var filter_description = $('#content input[name=\'description\']:checked').prop('value');

	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

$('#input-search').bind('keydown', function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('#cate_id').on('change', function() {
	if (this.value == '0') {
		$('input[name=\'sub_category\']').prop('disabled', true);
	} else {
		$('input[name=\'sub_category\']').prop('disabled', false);
	}
});

$('#cate_id').trigger('change');

function prod(href)
{
	location.href = href;
}

--></script>
<?php echo $footer; ?>