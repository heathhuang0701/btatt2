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
            <label class="col-sm-2 control-label" for="input-title"><?php echo $entry_title; ?></label>
            <div class="col-sm-10">
              <input type="text" name="title" placeholder="<?php echo $entry_title; ?>" id="input-title" class="form-control" value="<?php echo $title; ?>" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-content"><?php echo $entry_content; ?></label>
            <div class="col-sm-10">
              <textarea name="content" placeholder="<?php echo $entry_content; ?>" id="input-content" class="form-control"><?php echo $content; ?></textarea>
			</div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-time"><?php echo $entry_time; ?></label>
            <div class="col-sm-10">
			  <div class="input-group datetime">
				<input type="text" name="time" placeholder="<?php echo $entry_time; ?>" data-date-format="YYYY-MM-DD HH:mm:ss" id="input-time" class="form-control" value="<?php echo $time; ?>" />
				<span class="input-group-btn">
					<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
				</span>
			  </div>
			</div>
			
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
            <div class="col-sm-10">
              <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
            </div>
          </div>  		  
		  
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-show"><?php echo $entry_show; ?></label>
            <div class="col-sm-10">
			  <select name="show" id="input-show">
				<option value="0" <?php if($show == '0') echo 'selected="selected"'; ?>><?php echo $option_hide;?></option>
				<option value="1" <?php if($show == 1) echo 'selected="selected"'; ?>><?php echo $option_show;?></option>
			  </select>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
<script type="text/javascript"><!--

$('#input-content').summernote({height: 300});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

//--></script> 
</div>
<?php echo $footer; ?>