<?php echo $header; ?>

<div class="allbox bg02">
	<div class="main_box">
		<h1><?php echo $heading_title; ?></h1>
		<div class="class_box news">
            <?php 
            if(count($newses) > 0)
            {
            ?>
            <ul>
                <?php 
                foreach($newses as $news)
                {
                ?>
                <li>
                    <a href="<?php echo $news['href']; ?>">
                        <img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>">
                        <p><?php echo $news['title']; ?></p>
						<p><?php echo $news['time']; ?></p>
                    </a>
                </li>
                <?php 
                }
                ?>
            </ul>
            <?php 
            }
            ?>
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
            </div>
		</div>
	</div>
</div>

<?php echo $footer; ?>