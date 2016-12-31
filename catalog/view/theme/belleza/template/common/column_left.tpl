<?php if ($modules) { ?>
<column id="column-left" class="col-sm-3 hidden-xs">
  <div class="pro_left">
  <?php foreach ($modules as $module) { ?>
  <?php echo $module; ?>
  <?php } ?>
  </div>
</column>
<?php } ?>