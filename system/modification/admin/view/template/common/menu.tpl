<ul id="menu">
  <li id="dashboard"><a href="<?php echo $home; ?>"><i class="fa fa-dashboard fa-fw"></i> <span><?php echo $text_dashboard; ?></span></a></li>
  
  
	<!-- CATALOG -->
    <?php
    if(isset($category) || isset($product) || isset($recurring) || isset($filter) || isset($attribute) || isset($attribute_group) || isset($option) || isset($manufacturer) || isset($review) )
    {
    ?>
	<li id="catalog"><a class="parent"><i class="fa fa-tags fa-fw"></i> <span><?php echo $text_catalog; ?></span></a>
    	<ul>
            <?php if(isset($category)){ ?><li><a href="<?php echo $category; ?>"><?php echo $text_category; ?></a></li><?php } ?>
            <?php if(isset($product)){ ?><li><a href="<?php echo $product; ?>"><?php echo $text_product; ?></a></li><?php } ?>
            <?php if(isset($recurring)){ ?><li><a href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?></a></li><?php } ?>
            <?php if(isset($filter)){ ?><li><a href="<?php echo $filter; ?>"><?php echo $text_filter; ?></a></li><?php } ?>
            <?php
            if(isset($attribute) || isset($attribute_group))
            {
            ?>
            <li><a class="parent"><?php echo $text_attribute; ?></a>
                <ul>
                    <?php if(isset($attribute)){ ?><li><a href="<?php echo $attribute; ?>"><?php echo $text_attribute; ?></a></li><?php } ?>
                    <?php if(isset($attribute_group)){ ?><li><a href="<?php echo $attribute_group; ?>"><?php echo $text_attribute_group; ?></a></li><?php } ?>
                </ul>
            </li>
            <?php
            }
            ?>
            <?php if(isset($option)){ ?><li><a href="<?php echo $option; ?>"><?php echo $text_option; ?></a></li><?php } ?>
            <?php if(isset($manufacturer)){ ?><li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li><?php } ?>
            <?php if(isset($review)){ ?><li><a href="<?php echo $review; ?>"><?php echo $text_review; ?></a></li><?php } ?>
		</ul>
	</li>
    <?php
    }
    ?>
    
    
    <!-- EXTENSION -->
    <?php
    if(isset($installer) || isset($modification) || isset($module) || isset($shipping) || isset($payment) || isset($total) || isset($feed) || isset($fraud))
    {
    ?> 
  	<li id="extension"><a class="parent"><i class="fa fa-puzzle-piece fa-fw"></i> <span><?php echo $text_extension; ?></span></a>
        <ul>
            <?php if(isset($installer)){ ?><li><a href="<?php echo $installer; ?>"><?php echo $text_installer; ?></a></li><?php } ?>
            <?php if(isset($modification)){ ?><li><a href="<?php echo $modification; ?>"><?php echo $text_modification; ?></a></li><?php } ?>
            <?php if(isset($module)){ ?><li><a href="<?php echo $module; ?>"><?php echo $text_module; ?></a></li><?php } ?>
            <?php if(isset($shipping)){ ?><li><a href="<?php echo $shipping; ?>"><?php echo $text_shipping; ?></a></li><?php } ?>
            <?php if(isset($payment)){ ?><li><a href="<?php echo $payment; ?>"><?php echo $text_payment; ?></a></li><?php } ?>
            <?php if(isset($total)){ ?><li><a href="<?php echo $total; ?>"><?php echo $text_total; ?></a></li><?php } ?>
            <?php if(isset($feed)){ ?><li><a href="<?php echo $feed; ?>"><?php echo $text_feed; ?></a></li><?php } ?>
            <?php if(isset($fraud)){ ?><li><a href="<?php echo $fraud; ?>"><?php echo $text_fraud; ?></a></li><?php } ?>
        </ul>
	</li>
    <?php
    }
    ?>
    
    <!-- SALE -->
    <?php
    if(isset($order) || isset($order_recurring) || isset($return) || isset($voucher) || isset($voucher_theme))
    {
    ?> 
    <li id="sale"><a class="parent"><i class="fa fa-shopping-cart fa-fw"></i> <span><?php echo $text_sale; ?></span></a>
        <ul>
            <?php if(isset($order)){ ?><li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li><?php } ?>
            <?php if(isset($order_recurring)){ ?><li><a href="<?php echo $order_recurring; ?>"><?php echo $text_order_recurring; ?></a></li><?php } ?>
            <?php if(isset($return)){ ?><li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li><?php } ?>
            <?php
            if(isset($voucher) || isset($voucher_theme))
            {
            ?>
            <li><a class="parent"><?php echo $text_voucher; ?></a>
            	<ul>
                    <?php if(isset($voucher)){ ?><li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li><?php } ?>
                    <?php if(isset($voucher_theme)){ ?><li><a href="<?php echo $voucher_theme; ?>"><?php echo $text_voucher_theme; ?></a></li><?php } ?>
            	</ul>
            </li>
            <?php
            }
            ?>
        </ul>
    </li>
    <?php
    }
    ?>
  
    <!-- CUSTOMER -->
    <?php
    if(isset($customer) || isset($customer_group) || isset($custom_field) || isset($customer_ban_ip))
    {
    ?> 
    <li id="customer"><a class="parent"><i class="fa fa-user fa-fw"></i> <span><?php echo $text_customer; ?></span></a>
        <ul>
			<?php if(isset($customer)){ ?><li><a href="<?php echo $customer; ?>"><?php echo $text_customer; ?></a></li><?php } ?>
            <?php if(isset($customer_group)){ ?><li><a href="<?php echo $customer_group; ?>"><?php echo $text_customer_group; ?></a></li><?php } ?>
            <?php if(isset($custom_field)){ ?><li><a href="<?php echo $custom_field; ?>"><?php echo $text_custom_field; ?></a></li><?php } ?>
            <?php if(isset($customer_ban_ip)){ ?><li><a href="<?php echo $customer_ban_ip; ?>"><?php echo $text_customer_ban_ip; ?></a></li><?php } ?>
        </ul>
    </li>
    <?php
    }
    ?>
    
	<!-- MARKETING -->
    <?php
    if(isset($marketing) || isset($affiliate) || isset($coupon) || isset($contact))
    {
    ?> 
    <li id="marketing"><a class="parent"><i class="fa fa-share-alt fa-fw"></i> <span><?php echo $text_marketing; ?></span></a>
        <ul>
            <?php if(isset($marketing)){ ?><li><a href="<?php echo $marketing; ?>"><?php echo $text_marketing; ?></a></li><?php } ?>
            <?php if(isset($affiliate)){ ?><li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li><?php } ?>
            <?php if(isset($coupon)){ ?><li><a href="<?php echo $coupon; ?>"><?php echo $text_coupon; ?></a></li><?php } ?>
            <?php if(isset($contact)){ ?><li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li><?php } ?>
        </ul>
    </li>
    <?php
    }
    ?>
	
    <!-- SETTING --> 
    <?php
    if(isset($setting) || isset($class) || isset($teacher) || isset($board) || isset($news) )
    {
    ?>
    <li id="setting"><a class="parent"><i class="fa fa-files-o fa-fw"></i> <span><?php echo $text_setting; ?></span></a>
        <ul>
            <?php if(isset($setting)){ ?><li><a href="<?php echo $setting; ?>"><?php echo $text_setting; ?></a></li><?php } ?>
            <?php if(isset($class)){ ?><li><a href="<?php echo $class; ?>"><?php echo $text_class; ?></a></li><?php } ?>
            <?php if(isset($teacher)){ ?><li><a href="<?php echo $teacher; ?>"><?php echo $text_teacher; ?></a></li><?php } ?>
            <?php if(isset($board)){ ?><li><a href="<?php echo $board; ?>"><?php echo $text_board; ?></a></li><?php } ?>
			<?php if(isset($news)){ ?><li><a href="<?php echo $news; ?>"><?php echo $text_news; ?></a></li><?php } ?>
        </ul>
    </li>
    
    <?php
    }
    ?>

	<!-- SYSTEM --> 
    <?php
    if(isset($user) || isset($user_permission) || isset($layout) || isset($banner) || isset($location) || isset($language) || isset($currency) || isset($stock_status) || isset($order_staus) || isset($return_status) || isset($return_action) || isset($return_reason) || isset($country) || isset($zone) || isset($geo_zone) || isset($tax_class) || isset($tax_rate) || isset($length_class) || isset($weight_class))
    {
    ?>
	<li id="system"><a class="parent"><i class="fa fa-cog fa-fw"></i> <span><?php echo $text_system; ?></span></a>
        <ul>
            <?php
            if(isset($user) || isset($user_group))
            {
            ?>
            <li><a class="parent"><?php echo $text_user; ?></a>
                <ul>
                    <?php if(isset($user)){ ?><li><a href="<?php echo $user; ?>"><?php echo $text_user; ?></a></li><?php } ?>
                    <?php if(isset($user_group)){ ?><li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li><?php } ?>
                </ul>
            </li>
            <?php
            }
            ?>
			
            <?php
            if(isset($layout) || isset($banner))
            {
            ?>
            <li><a class="parent"><?php echo $text_design; ?></a>
                <ul>
                    <?php if(isset($layout)){ ?><li><a href="<?php echo $layout; ?>"><?php echo $text_layout; ?></a></li><?php } ?>
                    <?php if(isset($banner)){ ?><li><a href="<?php echo $banner; ?>"><?php echo $text_banner; ?></a></li><?php } ?>
                </ul>
            </li>
            <?php
            }
            ?>
            
            <?php
            if(isset($location) || isset($language) || isset($currency) || isset($stock_status) || isset($order_staus) || isset($return_status) || isset($return_action) || isset($return_reason) || isset($country) || isset($zone) || isset($geo_zone) || isset($tax_class) || isset($tax_rate) || isset($length_class) || isset($weight_class))
            {
            ?>    
            <li><a class="parent"><?php echo $text_localisation; ?></a>
                <ul>
                    <?php if(isset($location)){ ?><li><a href="<?php echo $location; ?>"><?php echo $text_location; ?></a></li><?php } ?>
                    <?php if(isset($language)){ ?><li><a href="<?php echo $language; ?>"><?php echo $text_language; ?></a></li><?php } ?>
                    <?php if(isset($currency)){ ?><li><a href="<?php echo $currency; ?>"><?php echo $text_currency; ?></a></li><?php } ?>
                    <?php if(isset($stock_status)){ ?><li><a href="<?php echo $stock_status; ?>"><?php echo $text_stock_status; ?></a></li><?php } ?>
                    <?php if(isset($order_status)){ ?><li><a href="<?php echo $order_status; ?>"><?php echo $text_order_status; ?></a></li><?php } ?>
                    
                    <?php
                    if(isset($return_status) || isset($return_action) || isset($return_reason))
                    {
                    ?>   
                    <li><a class="parent"><?php echo $text_return; ?></a>
            			<ul>
                            <?php if(isset($return_status)){ ?><li><a href="<?php echo $return_status; ?>"><?php echo $text_return_status; ?></a></li><?php } ?>
                            <?php if(isset($return_action)){ ?><li><a href="<?php echo $return_action; ?>"><?php echo $text_return_action; ?></a></li><?php } ?>
                            <?php if(isset($return_reason)){ ?><li><a href="<?php echo $return_reason; ?>"><?php echo $text_return_reason; ?></a></li><?php } ?>
                        </ul>
            		</li>
                    <?php
                    }
                    ?> 
                    
                    <?php if(isset($country)){ ?><li><a href="<?php echo $country; ?>"><?php echo $text_country; ?></a></li><?php } ?>
                    <?php if(isset($zone)){ ?><li><a href="<?php echo $zone; ?>"><?php echo $text_zone; ?></a></li><?php } ?>
                    <?php if(isset($geo_zone)){ ?><li><a href="<?php echo $geo_zone; ?>"><?php echo $text_geo_zone; ?></a></li><?php } ?>

                    <?php
                    if(isset($tax_class) || isset($tax_rate))
                    {
                    ?>  
                    <li><a class="parent"><?php echo $text_tax; ?></a>
                    	<ul>
                            <?php if(isset($tax_class)){ ?><li><a href="<?php echo $tax_class; ?>"><?php echo $text_tax_class; ?></a></li><?php } ?>
                            <?php if(isset($tax_rate)){ ?><li><a href="<?php echo $tax_rate; ?>"><?php echo $text_tax_rate; ?></a></li><?php } ?>
                        </ul>
            		</li>
                 	<?php
                    }
                    ?> 
                    
                    <?php if(isset($length_class)){ ?><li><a href="<?php echo $length_class; ?>"><?php echo $text_length_class; ?></a></li><?php } ?>
                    <?php if(isset($weight_class)){ ?><li><a href="<?php echo $weight_class; ?>"><?php echo $text_weight_class; ?></a></li><?php } ?>
            	</ul>
            </li>
            <?php
            }
            ?>  
        </ul>
    </li>
    <?php
    }
    ?>
  
  
	<!-- TOOLS --> 
    <?php
    if(isset($upload) || isset($backup) || isset($error_log))
    {
    ?>
    <li id="tools"><a class="parent"><i class="fa fa-wrench fa-fw"></i> <span><?php echo $text_tools; ?></span></a>
        <ul>
            <?php if(isset($upload)){ ?><li><a href="<?php echo $upload; ?>"><?php echo $text_upload; ?></a></li><?php } ?>
            <?php if(isset($backup)){ ?><li><a href="<?php echo $backup; ?>"><?php echo $text_backup; ?></a></li><?php } ?>
            <?php if(isset($error_log)){ ?><li><a href="<?php echo $error_log; ?>"><?php echo $text_error_log; ?></a></li><?php } ?>
        </ul>
    </li>
    <?php
    }
    ?>
  
	<!-- REPORTS --> 
    <?php
    if(isset($report_sale_order) || isset($report_sale_tax) || isset($report_sale_shipping) || isset($report_sale_return) || isset($report_sale_coupon) || isset($report_product_viewed) || isset($report_product_purchased) || isset($report_customer_online) || isset($report_customer_activity) || isset($report_customer_order) || isset($report_customer_reward) || isset($report_customer_credit) || isset($report_marketing) || isset($report_affiliate) || isset($report_affiliate_activity))
    {
    ?>
    <li id="reports"><a class="parent"><i class="fa fa-bar-chart-o fa-fw"></i> <span><?php echo $text_reports; ?></span></a>
        <ul>
            <?php if(isset($report_sale_order)){ ?><li><a href="<?php echo $report_sale_order; ?>"><?php echo $text_report_sale_order; ?></a></li><?php } ?>
            
			<?php
            if(isset($report_sale_order) || isset($report_sale_tax) || isset($report_sale_shipping) || isset($report_sale_return) || isset($report_sale_coupon))
            {
            ?>
            <li><a class="parent"><?php echo $text_sale; ?></a>
                <ul>
                    <?php if(isset($report_sale_order)){ ?><li><a href="<?php echo $report_sale_order; ?>"><?php echo $text_report_sale_order; ?></a></li><?php } ?>
                    <?php if(isset($report_sale_tax)){ ?><li><a href="<?php echo $report_sale_tax; ?>"><?php echo $text_report_sale_tax; ?></a></li><?php } ?>
                    <?php if(isset($report_sale_shipping)){ ?><li><a href="<?php echo $report_sale_shipping; ?>"><?php echo $text_report_sale_shipping; ?></a></li><?php } ?>
                    <?php if(isset($report_sale_return)){ ?><li><a href="<?php echo $report_sale_return; ?>"><?php echo $text_report_sale_return; ?></a></li><?php } ?>
                    <?php if(isset($report_sale_coupon)){ ?><li><a href="<?php echo $report_sale_coupon; ?>"><?php echo $text_report_sale_coupon; ?></a></li><?php } ?>
                </ul>
            </li>
            <?php
            }
            ?>
            
            <?php
            if(isset($report_product_viewed) || isset($report_product_purchased))
            {
            ?>
            <li><a class="parent"><?php echo $text_product; ?></a>
                <ul>
                    <?php if(isset($report_product_viewed)){ ?><li><a href="<?php echo $report_product_viewed; ?>"><?php echo $text_report_product_viewed; ?></a></li><?php } ?>
                    <?php if(isset($report_product_purchased)){ ?><li><a href="<?php echo $report_product_purchased; ?>"><?php echo $text_report_product_purchased; ?></a></li><?php } ?>
                </ul>
            </li>
            <?php
            }
            ?>
            
            <?php
            if(isset($report_customer_online) || isset($report_customer_activity) || isset($report_customer_order) || isset($report_customer_reward) || isset($report_customer_credit))
            {
            ?>
            <li><a class="parent"><?php echo $text_customer; ?></a>
                <ul>
                    <?php if(isset($report_customer_online)){ ?><li><a href="<?php echo $report_customer_online; ?>"><?php echo $text_report_customer_online; ?></a></li><?php } ?>
                    <?php if(isset($report_customer_activity)){ ?><li><a href="<?php echo $report_customer_activity; ?>"><?php echo $text_report_customer_activity; ?></a></li><?php } ?>
                    <?php if(isset($report_customer_order)){ ?><li><a href="<?php echo $report_customer_order; ?>"><?php echo $text_report_customer_order; ?></a></li><?php } ?>
                    <?php if(isset($report_customer_reward)){ ?><li><a href="<?php echo $report_customer_reward; ?>"><?php echo $text_report_customer_reward; ?></a></li><?php } ?>
                    <?php if(isset($report_customer_credit)){ ?><li><a href="<?php echo $report_customer_credit; ?>"><?php echo $text_report_customer_credit; ?></a></li><?php } ?>
                </ul>
            </li>
            <?php
            }
            ?>
            
            <?php
            if(isset($report_marketing) || isset($report_affiliate) || isset($report_affiliate_activity))
            {
            ?>
            <li><a class="parent"><?php echo $text_marketing; ?></a>
                <ul>
                    <?php if(isset($report_marketing)){ ?><li><a href="<?php echo $report_marketing; ?>"><?php echo $text_marketing; ?></a></li><?php } ?>
                    <?php if(isset($report_affiliate)){ ?><li><a href="<?php echo $report_affiliate; ?>"><?php echo $text_report_affiliate; ?></a></li><?php } ?>
                    <?php if(isset($report_affiliate_activity)){ ?><li><a href="<?php echo $report_affiliate_activity; ?>"><?php echo $text_report_affiliate_activity; ?></a></li><?php } ?>
                </ul>
            </li>
            <?php
            }
            ?>
        </ul>
    </li>
    <?php
    }
    ?>    
</ul>
