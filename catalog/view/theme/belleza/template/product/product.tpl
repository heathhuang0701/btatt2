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
					<div class="pro_pagetop">
						<div class="page_left">
                        	<ul class="thumbnails" style="overflow:hidden;">
								<li class="probig"><a class="thumbnail" title="<?php echo $heading_title; ?>" href="<?php echo $popup; ?>"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
							
                            <?php if($images) 
                            {
                                foreach($images as $image) 
                                {
                                ?>
								<li class="image-additional"><a class="thumbnail" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
                            <?php 
                                } 
                            } 
                            ?>
							</ul>
						</div>
						<div class="page_right" id="product">
							<div class="page_txt">
								<h2><?php echo $heading_title; ?></h2>
                                <?php if ($manufacturer) { ?>
                                <p><?php echo $text_manufacturer; ?> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a></p>
                                <?php } ?>
                                <p><?php echo $text_model; ?> <?php echo $model; ?></p>
                                <?php if ($reward) { ?>
                                <p><?php echo $text_reward; ?> <?php echo $reward; ?></p>
                                <?php } ?>
                                <p><?php echo $text_stock; ?> <?php echo $stock; ?></p>
							</div>
							<div class="page_txt">
                                <?php if (!$special) { ?>
                                  <h2><?php echo $price; ?></h2>
                                <?php } else { ?>
                                <p style="text-decoration: line-through;"><?php echo $price; ?></p>
								<h2><?php echo $special; ?></h2>                            
                                <?php } ?>
                                <?php if ($tax) { ?>
                                <p><?php echo $text_tax; ?> <?php echo $tax; ?></p>
                                <?php } ?>
                                <?php if ($points) { ?>
                                <p><?php echo $text_points; ?> <?php echo $points; ?></p>
                                <?php } ?>
                                <?php if ($discounts) { ?>
                                <?php foreach ($discounts as $discount) { ?>
                                <p><?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?></p>
                                <?php } ?>
                              <?php } ?>
							
                               <?php if ($options) { ?>
                                <p><?php echo $text_option; ?></p>
                                <?php foreach ($options as $option) { ?>
                                <?php if ($option['type'] == 'select') { ?>
                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                  <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
                                    <option value=""><?php echo $text_select; ?></option>
                                    <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                    <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                                    <?php if ($option_value['price']) { ?>
                                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                    <?php } ?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                </div>
                                <?php } ?>
                                <?php if ($option['type'] == 'radio') { ?>
                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                  <label class="control-label"><?php echo $option['name']; ?></label>
                                  <div id="input-option<?php echo $option['product_option_id']; ?>">
                                    <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                    <div class="radio">
                                      <label>
                                        <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                                        <?php echo $option_value['name']; ?>
                                        <?php if ($option_value['price']) { ?>
                                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                        <?php } ?>
                                      </label>
                                    </div>
                                    <?php } ?>
                                  </div>
                                </div>
                                <?php } ?>
                                <?php if ($option['type'] == 'checkbox') { ?>
                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                  <label class="control-label"><?php echo $option['name']; ?></label>
                                  <div id="input-option<?php echo $option['product_option_id']; ?>">
                                    <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                    <div class="checkbox">
                                      <label>
                                        <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                                        <?php echo $option_value['name']; ?>
                                        <?php if ($option_value['price']) { ?>
                                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                        <?php } ?>
                                      </label>
                                    </div>
                                    <?php } ?>
                                  </div>
                                </div>
                                <?php } ?>
                                <?php if ($option['type'] == 'image') { ?>
                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                  <label class="control-label"><?php echo $option['name']; ?></label>
                                  <div id="input-option<?php echo $option['product_option_id']; ?>">
                                    <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                    <div class="radio">
                                      <label>
                                        <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                                        <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> <?php echo $option_value['name']; ?>
                                        <?php if ($option_value['price']) { ?>
                                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                        <?php } ?>
                                      </label>
                                    </div>
                                    <?php } ?>
                                  </div>
                                </div>
                                <?php } ?>
                                <?php if ($option['type'] == 'text') { ?>
                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                  <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                </div>
                                <?php } ?>
                                <?php if ($option['type'] == 'textarea') { ?>
                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                  <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
                                </div>
                                <?php } ?>
                                <?php if ($option['type'] == 'file') { ?>
                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                  <label class="control-label"><?php echo $option['name']; ?></label>
                                  <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                                  <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
                                </div>
                                <?php } ?>
                                <?php if ($option['type'] == 'date') { ?>
                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                  <div class="input-group date">
                                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                    </span></div>
                                </div>
                                <?php } ?>
                                <?php if ($option['type'] == 'datetime') { ?>
                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                  <div class="input-group datetime">
                                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                    <span class="input-group-btn">
                                    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                    </span></div>
                                </div>
                                <?php } ?>
                                <?php if ($option['type'] == 'time') { ?>
                                <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                  <div class="input-group time">
                                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                    <span class="input-group-btn">
                                    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                    </span></div>
                                </div>
                                <?php } ?>
                                <?php } ?>
                                <?php } ?>
                            </div>  
                            <div class="pagetxt">
                            	<p><?php echo $entry_qty; ?></p>
                            </div>              
							<div class="pagebtn">
								<select name="quantity" id="input-quantity">
									<?php 
									for($qt=1;$qt<=10;$qt++)
									{
										if($qt >= $minimum) echo '<option value="'.$qt.'">'.$qt.'</option>';
									}
									?>
								</select>
								<!--<input type="text" value="<?php echo $minimum; ?>" size="2" />-->
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
								<?php
								if($quantities > 0)
								{
								?>
								<a href="javascript:;" id="button-cart"><?php echo $button_cart; ?></a>
								<?php
								}
								?>
							</div>
						</div>
					</div>
                    <?php 
                    if(count($add_price) > 0)
                    {
                    ?>
					<div class="pro_addlist">
						<h2><?php echo $text_add_price_area;?></h2>
                        <?php 
                        foreach($add_price as $add)
                        {
                        ?>
						<div class="addbox">
							<div class="boximg"><a href="<?php echo $add['href']; ?>"><img src="<?php echo $add['image']; ?>" alt="<?php echo $add['alt']; ?>" title="<?php echo $add['alt']; ?>" /></a></div>
							<div class="boxtxt"><input type="checkbox" value="1" class="add_check_item" name="add_item[<?php echo $add['product_id']; ?>]" /><span></span><p><?php echo $add['text']; ?></p>
                            </div>
						</div>
                        <?php
                        }
                        ?>
					</div>
                    <?php 
                    }
                    if(count($products) > 0)
                    {
                    ?>
					<div class="pro_addlist">
						<h2><?php echo $text_related; ?></h2>
                        <?php
                        foreach($products as $related)
                        {
                        ?>
						<div class="addbox">
							<div class="boximg"><a href="<?php echo $related['href']; ?>"><img src="<?php echo $related['thumb']; ?>" alt="<?php echo $related['alt']; ?>" title="<?php echo $related['alt']; ?>" /></a></div>
							<div class="boxtxt">
                                <span><?php echo $related['price']; ?></span><p><?php echo $related['name']; ?></p>
                                <a href="<?php echo $related['href']; ?>"><?php echo $button_product; ?></a>
                            </div>
						</div>
                        <?php
                        }
                        ?>
					</div>
                    <?php
                    }
                    ?>
					<div class="pro_infobox">
						<h2>商品說明</h2>
						<?php echo $description; ?>  
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
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});

$('#button-cart').on('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea, .add_check_item:checked'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) {
				
				$('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('#cart > button').html('<i class="fa fa-shopping-cart"></i> ' + json['total']);

				$('html, body').animate({ scrollTop: 0 }, 'slow');

				$('#cart > ul').load('index.php?route=common/cart/info ul li');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});

$('#review').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#form-review").serialize(),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
});

$(document).ready(function() {
	$('.thumbnails').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery: {
			enabled:true
		}
	});
	add_view_history(<?php echo $product_id; ?>);
});



// 添加瀏覽紀錄
function add_view_history(id)
{
	// 初始可以插入cookie信息 
	var check = true; 
	var history = $.cookie("product_history"); 
	var res = '';
	if(typeof history != 'undefined')
	{
		res = history.split(',');
	}
	var len = 0;
	
	if(res != '')
	{
		for(var j in res) 
		{
			len = len + 1;
			if(parseInt(res[j]) == id)
			{
				// 已经存在，不能插入
				check = false;  
				return false; 
			} 
		}
	}
	
	if(check == true)
	{
		var start = 0; 
		var txt = '';
		if(len > 5)
		{
			start = 1;
		} 
		for(var i = start;i < len;i++)
		{ 
			txt = txt + res[i] + ',';
		} 
		txt = txt + id;
		$.cookie("product_history",txt,{expires:1}); 
	}
}

//--></script>
<?php echo $footer; ?>