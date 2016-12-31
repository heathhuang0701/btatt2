<?php
class ControllerCommonHome extends Controller {
	public function index()
	{
		$this->load->language('module/featured');	
		
		$this->load->model('design/banner');
		$this->load->model('tool/image');
		$this->load->model('extension/module');
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}
		
		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.transitions.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');

		$data['text_tax'] = $this->language->get('text_tax');
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['button_product'] = $this->language->get('button_product');
		
		// (固定) 首頁輪播
		$data['banners'] = array();		

		$results = $this->model_design_banner->getBanner(7);
		$setting_info = $this->model_extension_module->getModule(27);
		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting_info['width'], $setting_info['height'])
				);
			}
		}
		
		// (固定) 分類地圖
		$data['categories'] = array();
		$categories = $this->model_catalog_category->getCategories(0);
		foreach($categories as $category)
		{
			if($category['top'])
			{
				// Level 2
				$children_data = array();
				$children = $this->model_catalog_category->getCategories($category['category_id']);
				foreach($children as $child)
				{
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'name'  => $child['name'].($this->config->get('config_product_count')?' ('.$this->model_catalog_product->getTotalProducts($filter_data).')':''),
						'href'  => $this->url->link('product/category', 'path='.$category['category_id'].'_'.$child['category_id'])
					);
				}
				if($category['image'] != '' && is_file(DIR_IMAGE.$category['image']))
				{
					$img = $this->model_tool_image->resize($category['image'],360,180);
				}
				else
				{
					$img = $this->model_tool_image->resize('new_pro.jpg',360,180);
				}
				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column']?$category['column']:1,
					'href'     => $this->url->link('product/category','path='.$category['category_id']),
					'image'    => $img
				);
			}
		}

		// 20161003 美麗紋首頁更動 先註解
		/*
		# (固定) 廠商品牌露出
		$results = $this->model_design_banner->getBanner(8);
		$setting_info = $this->model_extension_module->getModule(29);
		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['firms'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting_info['width'], $setting_info['height'])
				);
			}
		}

		# (固定) 推薦商品
		$setting_info = $this->model_extension_module->getModule(28);
		$data['features'] = array();
		if (!empty($setting_info['product'])) {
			$products = array_slice($setting_info['product'], 0, (int)$setting_info['limit']);

			foreach ($products as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);
				if ($product_info) {
					if ($product_info['image'] && is_file(DIR_IMAGE.$product_info['image'])) {
						$image = $this->model_tool_image->resize($product_info['image'], $setting_info['width'], $setting_info['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting_info['width'], $setting_info['height']);
					}

					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}

					if ((float)$product_info['special']) {
						$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $product_info['rating'];
					} else {
						$rating = false;
					}

					$data['features'][] = array(
						'product_id'  => $product_info['product_id'],
						'thumb'       => $image,
						'name'        => $product_info['name'],
						'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'rating'      => $rating,
						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
					);
				}
			}
		}
		
		$data['belleza_left'] = $this->load->controller('common/belleza_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		*/
		
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/home.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/home.tpl', $data));
		}
	}
}