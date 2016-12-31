<?php echo $header; ?>
<div class="bx-wrapper">
	<div class="bx-controls-direction"><a class="bx-prev" href="">Prev</a><a class="bx-next" href="">Next</a></div>
	<ul class="bxslider">
    <?php 
    if(count($indexes) > 0)
    {
    	$i=0;
    	foreach($indexes as $apky => $indexs)
        {
        	if($i>5) break;
            if($indexs['link'] != '')
            {
            	echo '<li><a href="'.$indexs['link'].'"><img src="'.$indexs['image'].'" class="pic" /><img src="'.$indexs['image_app'].'" class="mpic" title="'.$indexs['title'].'" /></a></li>';
        	}
            else
            {
            	echo '<li><img src="'.$indexs['image'].'" class="pic" /><img src="'.$indexs['image_app'].'" class="mpic" title="'.$indexs['title'].'" /></li>';
            }
            $i++;
        }
    }
    else
    {
    ?>
    	<li><img src="img/pic1.jpg" class="pic" /><img src="catalog/view/theme/belleza/image/m_pic1.jpg" class="mpic" ></li>
    <?php
    }
    ?>
	</ul>
</div>
<?php echo $footer; ?>


<script type="text/javascript">
<!--

setTimeout('turn()',5000);
function turn()
{
	$('.bx-next').click();
	setTimeout('turn()',5000);
}
-->
</script>