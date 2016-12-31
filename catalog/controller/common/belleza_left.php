<?php
class ControllerCommonBellezaLeft extends Controller {
	public function index() {
		$this->load->model('design/banner');
		$this->load->model('tool/image');
		$this->load->model('extension/module');
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');

		$data['text_credit_1'] = $this->language->get('text_credit_1');
		$data['text_credit_2'] = $this->language->get('text_credit_2');
		$data['text_history'] = $this->language->get('text_history');
		$data['text_bestseller'] = $this->language->get('text_bestseller');
		
		// (固定) 目錄
		$parts = array();
		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach($categories as $category)
		{
			$children_data = array();
			$children = $this->model_catalog_category->getCategories($category['category_id']);

			$filter_data = array(
				'filter_category_id'  => $category['category_id'],
				'filter_sub_category' => true
			);

			foreach($children as $child) {
				$filter_data = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);

				$children_data[] = array(
					'category_id' => $child['category_id'],
					'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
					'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
				);
			}
		



			$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
				'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);
		}
		
		$data['bestseller'] = array();
		
		// (固定) 熱銷商品
		$setting_info = $this->model_extension_module->getModule(33);
		
		$results = $this->model_catalog_product->getBestSellerProducts($setting_info['limit']);

		if ($results) {
			foreach ($results as $result) {
				if ($result['image'] && is_file(DIR_IMAGE.$result['image'])) {
					$image = $this->model_tool_image->resize($result['image'], 400,300);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 400,300);
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}

				$data['bestseller'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => utf8_substr($result['name'],0,50),
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				);
			}
		}
		
		// (固定) 瀏覽紀錄
		$data['history'] = array();
		$history = $this->request->cookie['product_history'];
		if($history != '')
		{
			$results = $this->model_catalog_product->getProducts(array('filter_txt' => $history));

			foreach ($results as $result)
			{
				if ($result['image'] && is_file(DIR_IMAGE.$result['image'])) {
					$image = $this->model_tool_image->resize($result['image'], 400,300);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 400,300);
				}
	
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
	
				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}
	
				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}
	
				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}
	
				$data['history'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => utf8_substr($result['name'],0,50),
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
				
			}
			array_reverse($data['history']);
		}	

		// (固定) 左下輪播
		$results = $this->model_design_banner->getBanner(10);

		$setting_info = $this->model_extension_module->getModule(27);
		foreach ($results as $result) {
			if(is_file(DIR_IMAGE . $result['image'])) {
				$data['kvbar'] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], 342,88)
				);
				break;
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/belleza_left.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/belleza_left.tpl', $data);
		} else {
			return $this->load->view('default/template/common/belleza_left.tpl', $data);
		}
	}
}