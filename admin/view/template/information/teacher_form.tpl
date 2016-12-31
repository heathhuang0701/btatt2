<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body"> 
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" value="<?php echo $name; ?>" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-info"><?php echo $entry_info; ?></label>
            <div class="col-sm-10">
			  <textarea name="info" rows="5" placeholder="<?php echo $entry_info; ?>" id="input-info" class="form-control"><?php echo $info; ?></textarea>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-image-list"><?php echo $entry_image_list; ?></label>
            <div class="col-sm-10">
              <a href="" id="thumb-image-list" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb_list; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              <input type="hidden" name="image_list" value="<?php echo $image_list; ?>" id="input-image-list" />
            </div>
          </div>  
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-image-circle"><?php echo $entry_image_circle; ?></label>
            <div class="col-sm-10">
              <a href="" id="thumb-image-circle" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb_circle; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              <input type="hidden" name="image_circle" value="<?php echo $image_circle; ?>" id="input-image-circle" />
            </div>
          </div>  
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort"><?php echo $entry_sort; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sort" placeholder="<?php echo $entry_sort; ?>" id="input-sort" class="form-control" value="<?php echo $sort; ?>" />
            </div>
          </div>
          
          <div class="table-responsive">
            <table id="thumbs" class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left" style="width:40%;"><?php echo $entry_thumb; ?></td>
				  <td class="text-left" style="width:40%;"><?php echo $entry_thumb_info; ?></td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
                <?php $add_row = 0; ?>
                <?php foreach ($thumb as $key => $th) { ?>
                <tr id="add-row<?php echo $add_row; ?>">
                  <td class="text-left">
                      <a href="" id="thumb-image-thumb-<?php echo $add_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb_thumb[$key]['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                      <input type="hidden" name="thumb[<?php echo $add_row; ?>][thumb]" value="<?php echo $th['thumb']; ?>" id="input-image-thumb-<?php echo $add_row; ?>" />
                  </td>
				  <td class="text-left">
					  <input type="text" name="thumb[<?php echo $add_row; ?>][info]" value="<?php echo $th['info']; ?>" id="input-image-thumb-info-<?php echo $add_row; ?>" />
				  </td>
                  <td class="text-left"><button type="button" onclick="$('#add-row<?php echo $add_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                </tr>
                <?php $add_row++; ?>
                <?php } ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2"></td>
                  <td class="text-left"><button type="button" onclick="addThumb();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
<script type="text/javascript"><!--
$('#input-info').summernote({height: 300});
$('input[name=\'path\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					category_id: 0,
					name: '<?php echo $text_none; ?>'
				});

				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'path\']').val(item['label']);
		$('input[name=\'parent_id\']').val(item['value']);
	}
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'filter\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/filter/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['filter_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter\']').val('');

		$('#category-filter' + item['value']).remove();

		$('#category-filter').append('<div id="category-filter' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="category_filter[]" value="' + item['value'] + '" /></div>');
	}
});

$('#category-filter').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

var add_row = <?php echo $add_row; ?>;

function addThumb() 
{
    html  = '<tr id="add-row' + add_row + '">';
	html += '<td class="text-left">';
    html += '<a href="" id="thumb-image-thumb-' + add_row + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>';
    html += '<input type="hidden" name="thumb[' + add_row + '][thumb]" value="" id="input-image-thumb-' + add_row + '" />';
	html += '</td>';
	html += '<td class="text-left">';
	html += '<input type="text" name="thumb[' + add_row + '][info]" value="" id="input-image-thumb-info-' + add_row + '" />';
	html += '</td>';

	
	html += '<td class="text-left"><button type="button" onclick="$(\'#add-row' + add_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '</tr>';
	
	$('#thumbs tbody').append(html);
	
	add_row++;
}
//--></script> 
</div>
<?php echo $footer; ?>