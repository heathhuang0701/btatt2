<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><!--<a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>-->
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-category').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-category">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center" ><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left" colspan="4"></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($boards) { ?>
                <?php foreach ($boards as $board) { ?>
                <tr>
                  <td class="text-center" rowspan="4"><?php if (in_array($board['id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $board['id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $board['id']; ?>" />
                    <?php } ?>
                  </td>
                  <td class="text-left"><?php echo $column_name; ?></td>
                  <td class="text-left"><?php echo $board['name']; ?></td>
                  <td class="text-left"><?php echo $column_email; ?></td>
                  <td class="text-left"><?php echo $board['email']; ?></td>
                </tr>  
                <tr>
                  <td class="text-left"><?php echo $column_title; ?></td>
                  <td class="text-left"><?php echo $board['title']; ?></td>
                  <td class="text-left"><?php echo $column_time; ?></td>
                  <td class="text-left"><?php echo $board['time']; ?></td>
                </tr>  
                <tr>
                  <td class="text-left" colspan="3"><?php echo $board['content']; ?></td>
                  <td class="text-left">
                  	<?php echo $column_status.': '.$board['status'];?>
                  	<a href="<?php echo $board['change'];?>" title="<?php echo ($board['show']==1)?$button_hide:$button_show; ?>" class="btn btn-<?php echo ($board['show']==1)?'danger':'success'; ?>"><i class="fa fa-random"></i></a>
                  </td>
                </tr>
                <tr>
                  <td class="text-right" colspan="3">
                  	<textarea name="reply" id="reply<?php echo $board['id']; ?>" place="<?php echo $text_content; ?>" class="form-control"><?php echo $board['reply']; ?></textarea>
                    <input type="hidden" name="id" id="id<?php echo $board['id']; ?>" value="<?php echo $board['id']; ?>" />
                  </td>
                  <td>
                  	<a href="javascript:void(0);" onclick="reply(<?php echo $board['id'];?>);" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                  </td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <input type="hidden" value="<?php echo $page; ?>" id="page" name="page" />
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
<script>
<!--
function reply(id)
{
	$.ajax({
		url: '<?php echo $reply_url; ?>',
		type: 'post',
		data: $('#reply'+id+', #id'+id+', #page '),
		dataType: 'json',
		success: function(json) 
		{
			if(json['redirect']) 
			{
				location = json['redirect'];
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}
-->
</script>