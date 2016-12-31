<div class="pro_card">
    <div class="card_box">
        <a href="https://credit.allpay.com.tw/form_Sc.php?c=1030958">
            <img src="img/card.jpg" alt="">
            <p><?php echo $text_credit_1;?></p>
        </a>
    </div>
    <div class="card_box">
        <a href="https://ecpay.com.tw/0visa.php?c=459521">
            <img src="img/card2.jpg" alt="">
            <p><?php echo $text_credit_2;?></p>
        </a>
    </div>
</div>
<div class="pro_list">
    <ul>
        <?php 
        foreach($categories as $category)
        {
        ?>
        <li>
        	<a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
            <?php 
            if($category['children'])
            {
            ?>
            <ul class="rightbtn">
            	<?php
                foreach($category['children'] as $child)
                { 
            	?>
            	<li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
            	<?php 
                }
            	?>
            </ul>
            <?php
            }
            ?> 
        </li>
		<?php 
        }
        ?>
    </ul>
</div>
<div class="pro_pro">
    <h2><?php echo $text_bestseller; ?></h2>
    <ul>
        <?php 
        if(count($bestseller) > 0)
        {
            foreach($bestseller as $best)
            {
            ?>
            <li>
                <a href="<?php echo $best['href']; ?>">
                    <div><img src="<?php echo $best['thumb']; ?>" alt="<?php echo $best['name']; ?>" title="<?php echo $best['name']; ?>"></div>
                    <p><?php echo $best['name']; ?></p>
                </a>
            </li>
            <?php
            }
        }
        ?>
    </ul>
</div>
<div class="pro_pro">
    <h2><?php echo $text_history; ?></h2>
    <ul>
        <?php 
        if(count($history) > 0)
        {
            foreach($history as $hist)
            {
            ?>
            <li>
                <a href="<?php echo $hist['href']; ?>">
                    <div><img src="<?php echo $hist['thumb']; ?>" alt="<?php echo $hist['name']; ?>" title="<?php echo $hist['name']; ?>"></div>
                    <p><?php echo $hist['name']; ?></p>
                </a>
            </li>
            <?php
            }
        }
        ?>
    </ul>
</div>
<?php
if(isset($kvbar))
{
?>
<div class="pro_pro">
	<a href="<?php echo $kvbar['link']; ?>" target="_blank"><img src="<?php echo $kvbar['image']; ?>" title="<?php echo $kvbar['title']; ?>" /></a>
</div>
<?php 
}
?>