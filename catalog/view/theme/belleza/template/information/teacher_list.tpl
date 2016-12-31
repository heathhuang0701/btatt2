<?php echo $header; ?>
<div class="main_box">
	<h1><?php echo $heading_title; ?></h1>
	<div class="team_box">
        <?php 
        if(count($teachers) >0)
        {
        ?>
        <ul>
        	<?php 
            foreach($teachers as $teacher)
            {
            ?>
			<li><a href="<?php echo $teacher['href']; ?>"><img src="<?php echo $teacher['thumb']; ?>" alt=""><p><?php echo $teacher['name']; ?></p></a></li>
			<?php
            }
            ?>
		</ul>
        <?php 
        }
        ?>
	</div>
</div>
<?php echo $footer; ?>