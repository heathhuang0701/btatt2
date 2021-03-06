<?php
class ControllerApiCart extends Controller {
	public function add() {
		$this->load->language('api/cart');

		$json = array();

		if (isset($this->request->post['product'])) {
			$this->cart->clear();
			foreach($this->request->post['product'] as $product)
			{
				if (isset($product['option'])) {
					$option = $product['option'];
				} else {
					$option = array();
				}
				if(!isset($product['add_item']))
				{
					$product['add_item'] = array();
				}
				
				$this->cart->add($product['product_id'], $product['quantity'], $option, 0, $product['add_item']);
			}
		}

		if (isset($this->request->post['product_id'])) {
			$this->load->model('api/product');

			$product_info = $this->model_api_product->getProduct($this->request->post['product_id']);

			if ($product_info) {
				if (isset($this->request->post['quantity'])) {
					$quantity = $this->request->post['quantity'];
				} else {
					$quantity = 1;
				}

				if (isset($this->request->post['option'])) {
					$option = array_filter($this->request->post['option']);
				} else {
					$option = array();
				}

				$product_options = $this->model_api_product->getProductOptions($this->request->post['product_id']);

				foreach ($product_options as $product_option) {
					if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
						$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
					}
				}

				if (!isset($json['error']['option'])) {
					$this->cart->add($this->request->post['product_id'], $quantity, $option, 0, array());

					$json['success'] = $this->language->get('text_success');

					unset($this->session->data['shipping_method']);
					unset($this->session->data['shipping_methods']);
					unset($this->session->data['payment_method']);
					unset($this->session->data['payment_methods']);
				}
			} else {
				$json['error']['store'] = $this->language->get('error_store');
			}
		}
	

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function edit() {
		$this->load->language('api/cart');

		$json = array();


		$this->cart->update($this->request->post['key'], $this->request->post['quantity']);

		$json['success'] = $this->language->get('text_success');

		unset($this->session->data['shipping_method']);
		unset($this->session->data['shipping_methods']);
		unset($this->session->data['payment_method']);
		unset($this->session->data['payment_methods']);
		unset($this->session->data['reward']);
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove() {
		$this->load->language('api/cart');

		$json = array();

		// Remove
		if (isset($this->request->post['key'])) {
			$this->cart->remove($this->request->post['key']);

			unset($this->session->data['vouchers'][$this->request->post['key']]);

			$json['success'] = $this->language->get('text_success');

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);
		}
		

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function products() {
		$this->load->language('api/cart');

		$json = array();


		// Stock
		if (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
			$json['error']['stock'] = $this->language->get('error_stock');
		}

		// Products
		$json['products'] = array();

		$products = $this->cart->getProducts();

		foreach($products as $product)
		{
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$json['error']['minimum'][] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
			}

			$option_data = array();

			foreach ($product['option'] as $option) {
				$option_data[] = array(
					'product_option_id'       => $option['product_option_id'],
					'product_option_value_id' => $option['product_option_value_id'],
					'name'                    => $option['name'],
					'value'                   => $option['value'],
					'type'                    => $option['type']
				);
			}

			$adds = array();
			// 加價購
			if(count($product['add_products']) > 0)
			{
				foreach($product['add_products'] as $add)
				{
					$adds[] = array(
						'key'         => $add['key'],
						'product_id'  => $add['product_id'],
						'name'        => $add['name'],
						'model'       => $add['model'],
						'is_main'     => $add['is_main'],
						'main_id'     => $add['main_id'],
						'quantity'    => $add['quantity'],
						'shipping'    => $add['shipping'],
						'price'       => $this->currency->format($add['price']),
						'total'       => $this->currency->format($add['total']),
						'tax'         => $this->tax->getTax($add['price'], $add['tax_class_id']),
						'stock'       => $add['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))
					);	
				}
			}
			
			$json['products'][] = array(
				'key'        => $product['key'],
				'product_id' => $product['product_id'],
				'name'       => $product['name'],
				'model'      => $product['model'],
				'is_main'    => $product['is_main'],
				'main_id'    => $product['main_id'],
				'option'     => $option_data,
				'quantity'   => $product['quantity'],
				'stock'      => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
				'shipping'   => $product['shipping'],
				'price'      => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'))),
				'total'      => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']),
				'reward'     => $product['reward'],
				'add_products' => $adds
			);
		}

		// Voucher
		$json['vouchers'] = array();

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $key => $voucher) {
				$json['vouchers'][] = array(
					'code'             => $voucher['code'],
					'description'      => $voucher['description'],
					'from_name'        => $voucher['from_name'],
					'from_email'       => $voucher['from_email'],
					'to_name'          => $voucher['to_name'],
					'to_email'         => $voucher['to_email'],
					'voucher_theme_id' => $voucher['voucher_theme_id'],
					'message'          => $voucher['message'],
					'amount'           => $this->currency->format($voucher['amount'])
				);
			}
		}

		// Totals
		$this->load->model('api/extension');

		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();

		$sort_order = array();

		$results = $this->model_api_extension->getExtensions('total');

		foreach ($results as $key => $value) {
			$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
		}

		array_multisort($sort_order, SORT_ASC, $results);

		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('api/' . $result['code']);

				$this->{'model_api_' . $result['code']}->getTotal($total_data, $total, $taxes);
			}
		}

		$sort_order = array();

		foreach ($total_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $total_data);

		$json['totals'] = array();

		foreach ($total_data as $total) {
			$json['totals'][] = array(
				'title' => $total['title'],
				'text'  => $this->currency->format($total['value'])
			);
		}
	

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}