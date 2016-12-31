<!DOCTYPE html>
<html lang="zh-TW">
<head>
<?php
$type_renew_version = '17';
?>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<meta property="og:title" content="美麗紋專業刺青" />
	<meta name="description" content="提供專業刺青服務和用具" />
	<meta property="og:image" content="catalog/view/theme/belleza/img/fb.jpg" />
    
	<base href="<?php echo $base; ?>" />
    <?php 
    if ($title) { 
    ?>
    <title><?php echo $title; ?></title>
    <?php 
    } 
    if ($description) { 
    ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php 
    } 
    if ($keywords) { 
    ?>
    <meta name="keywords" content= "<?php echo $keywords; ?>" />
    <?php 
    } 
    ?>
    <?php 
    if ($icon) { 
    ?>
    <link href="<?php echo $icon; ?>" rel="icon" />
    <?php
    } 
    foreach ($links as $link) { 
    ?>
    <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
    <?php 
    } 
    ?>
    
    <link rel="stylesheet" media="screen" href="catalog/view/theme/belleza/stylesheet/bootstrap.min.css?<?php echo $type_renew_version; ?>" />
    
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/belleza/stylesheet/stylesheet.css?<?php echo $type_renew_version; ?>" />
    <!--<link rel="stylesheet" type="text/css" href="catalog/view/theme/belleza/stylesheet/jpreloader.css?<?php echo $type_renew_version; ?>" />-->
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/belleza/stylesheet/jquery.bxslider.css?<?php echo $type_renew_version; ?>" />
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/belleza/stylesheet/style.css?<?php echo $type_renew_version; ?>" />
	
    <link rel="stylesheet" type="text/css" href="catalog/view/javascript/font-awesome/css/font-awesome.min.css?<?php echo $type_renew_version; ?>" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" />
    
    <?php
    foreach ($styles as $style) { 
    ?>
    <link href="<?php echo $style['href']; ?>?<?php echo $type_renew_version; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
    <?php
    }
    ?>
	<style type="text/css">
	.topdistance 
	{ 
		margin-top: 145px;
		line-height: 20px;
	} 
	#content
	{
		color:#FFF;
	}
	h1,h2,h3,legend
	{
		color:#FFF;
	}
	h1
	{
		display: block;
		font-size: 2em;
		margin-top: 0.67em;
		margin-bottom: 0.67em;
		margin-left: 0;
		margin-right: 0;
		font-weight: bold;
	}
	h2
	{
		display: block;
		font-size: 1.5em;
		margin-top: 0.83em;
		margin-bottom: 0.83em;
		margin-left: 0;
		margin-right: 0;
		font-weight: bold;
	}
	h3
	{
		display: block;
		font-size: 1.17em;
		margin-top: 1em;
		margin-bottom: 1em;
		margin-left: 0;
		margin-right: 0;
		font-weight: bold;
	}
	.form-group > .control-label, .checkbox label, .radio label, .panel
	{
		color:#000;
	}
	.newpro_item p
	{
		text-decoration:none;
		color:#FFF;
	}
    </style> 
    <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js?<?php echo $type_renew_version; ?>"></script>
    <script src="catalog/view/javascript/jquery.cookie.js?<?php echo $type_renew_version; ?>"></script>
    <script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js?<?php echo $type_renew_version; ?>"></script>
    <script src="catalog/view/javascript/common.js?<?php echo $type_renew_version; ?>" type="text/javascript"></script>
    <!--<script src="catalog/view/javascript/jpreloader.min.js?<?php echo $type_renew_version; ?>"></script>-->
	<script src="catalog/view/javascript/TweenMax.min.js?<?php echo $type_renew_version; ?>" type="text/javascript"></script>
    <script src="catalog/view/javascript/jquery.bxslider.min.js?<?php echo $type_renew_version; ?>"></script>
    <script src="catalog/view/javascript/style.js?<?php echo $type_renew_version; ?>"></script>
    <?php
    foreach ($scripts as $script) {
    ?>
    <script src="<?php echo $script; ?>" type="text/javascript"></script>
    <?php
    }
?>
    
    

</head>

<body style="background-color:#000" class="<?php echo $class; ?>">

<!--<div id="jSplash"><img src="catalog/view/theme/belleza/img/logo.png"></div>-->
<!-- 選單列 開始 -->
<div class="header_box">
	<div class="logo">
		<a href="<?php echo $url_index; ?>"><img src="catalog/view/theme/belleza/img/logo.png"></a>
	</div>
	<div class="nav_box">
		<div class="serch_box">
			<div class="serch_bar" id="search">
                <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_search; ?>" />
				<span><button type="button"></button></span>
			</div>
			<div class="icon_box">
            
				<a href="https://www.facebook.com/%E7%BE%8E%E9%BA%97%E7%B4%8B%E5%88%BA%E9%9D%92%E7%B4%8B%E8%BA%AB%E5%99%A8%E6%9D%90-Belleza-Tattoo-Supply-189983241022330/" target="_blank" alt="facebook"><img src="catalog/view/theme/belleza/img/fb_icon.jpg" alt="facebook"></a>
				<a href="https://www.youtube.com/user/Sonicchung" target="_blank" alt="youtube"><img src="catalog/view/theme/belleza/img/youtube_icon.jpg" alt="youtube"></a>
				<a href="img/bellezaline2.jpg" target="_blank" alt="line"><img src="catalog/view/theme/belleza/img/line_icon.jpg" alt="line"></a>
				<a href="img/WECHAT-VINCENT.jpg" target="_blank" alt="wechat"><img src="catalog/view/theme/belleza/img/wechat_icon.jpg" alt="wechat"></a>
				<a href="https://www.instagram.com/bellezatattoo/" target="_blank" alt="instagram"><img src="catalog/view/theme/belleza/img/instagram_icon.jpg" alt="instagram"></a>
                <a href="<?php echo $url['cart']; ?>" alt="shopping"><img src="catalog/view/theme/belleza/img/shopping_icon.jpg" alt="shopping"></a>
			</div>
			<div class="m_menu">
				<a href="javascript:;" class="m_munebtn"><img src="catalog/view/theme/belleza/image/m_menu.jpg"></a>
				<a href="javascript:;" class="m_closebtn"><img src="catalog/view/theme/belleza/image/m_close.jpg"></a>
			</div>
		</div>
		<div class="nav_bar">
			<ul>
				<li><a href="<?php echo $url_index; ?>">首頁</a></li>
				<li class="porbtn">
					<a href="<?php echo $url['index']; ?>">所有商品</a>
                    <?php if ($categories) { ?>
					<ul class="subbtn">
                    	<?php foreach ($categories as $category) { ?>
                        <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
				</li>
                <li><a href="<?php echo $url['teacher']; ?>">紋身團隊</a></li>
                <li><a href="<?php echo $url['class']; ?>">課程諮詢</a></li>
                <li><a href="<?php echo $url['board']; ?>">刺客留言</a></li>
                <li><a href="<?php echo $url['about']; ?>">關於美麗紋/經銷商諮詢</a></li>
				<li><a href="<?php echo $url['news']; ?>">最新消息</a></li>
				<li class="porbtn">
					<a href="<?php echo $account; ?>">登入/註冊</a>
					<ul class="subbtn">
                    <?php 
                    if($logged)
                    { 
                    ?>
                        <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
                        <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
                        <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
                        <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
                        <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
                    <?php
                    }
                    else
                    { 
                    ?>
                        <li><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
                        <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
                    <?php
                    }
                    ?>
                    </ul>
				</li>
			</ul>
		</div>	
	</div>
</div>

<div class="m_munelist">
	<ul>
		<li><a href="index.php">首頁</a></li>
		<li class="m_porbtn">
			<a href="javascript:;">所有商品</a>
            <?php if ($categories) { ?>
			<ul class="m_subbtn">
            	<?php foreach ($categories as $category) { ?>
				<li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                <?php } ?>
			</ul>
            <?php } ?>
		</li>
		<li><a href="<?php echo $url['teacher']; ?>">紋身團隊</a></li>
		<li><a href="<?php echo $url['class']; ?>">課程諮詢</a></li>
		<li><a href="<?php echo $url['board']; ?>">刺客留言</a></li>
		<li><a href="<?php echo $url['about']; ?>">關於美麗紋/經銷商諮詢</a></li>
		<li><a href="<?php echo $url['news']; ?>">最新消息</a></li>
        <li class="m_porbtn">
            <a href="<?php echo $account; ?>">登入/註冊</a>
            <ul class="m_subbtn">
            <?php 
            if($logged)
            { 
            ?>
                <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
                <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
                <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
                <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
                <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
            <?php
            }
            else
            { 
            ?>
                <li><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
                <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
            <?php
            }
            ?>
            </ul>
        </li>
	</ul>
</div>
<!-- 選單列 結束 -->

<!-- ICON -->
<div class="shoppingbox"><a href="<?php echo $url['cart']; ?>" alt="shopping"><img src="catalog/view/theme/belleza/img/big_shopping_icon.jpg" alt="shopping"></a></div>