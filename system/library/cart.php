<?php
class Cart {
	private $config;
	private $db;
	private $data = array();

	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->customer = $registry->get('customer');
		$this->session = $registry->get('session');
		$this->db = $registry->get('db');
		$this->tax = $registry->get('tax');
		$this->weight = $registry->get('weight');

		if (!isset($this->session->data['cart']) || !is_array($this->session->data['cart'])) {
			$this->session->data['cart'] = array();
		}
	}
	public function getProd() {
		foreach ($this->session->data['cart'] as $key => $quantity) {
			$product = unserialize(base64_decode($key));
			$product['quantity'] = $quantity;
			pre($product);
		}
	}
	public function getProducts() 
	{
		if(!$this->data)
		{
			$total_quantity = array();
			foreach($this->session->data['cart'] as $key => $quantity)
			{
				$product = (array)unserialize(base64_decode($key));

				// 銷量控制: 考量主商品
				if(!isset($total_quantity[$product['product_id']]))
				{
					$total_quantity[$product['product_id']] = $quantity;
				}
				else
				{
					$total_quantity[$product['product_id']] += $quantity;
				}	

				// 銷量控制: 考量加價購
				if(isset($product['add_item']))
				{
					foreach($product['add_item'] as $pd => $qt)
					{
						if(!isset($total_quantity[$pd]))
						{
							$total_quantity[$pd] = $qt;
						}
						else
						{
							$total_quantity[$pd] += $qt;
						}
					}
				}
			}
			
			foreach($this->session->data['cart'] as $key => $quantity)
			{

				$product = unserialize(base64_decode($key));

				$product_id = $product['product_id'];

				$stock = true;

				// Options
				if (!empty($product['option'])) {
					$options = $product['option'];
				} else {
					$options = array();
				}

				// Profile
				if (!empty($product['recurring_id'])) {
					$recurring_id = $product['recurring_id'];
				} else {
					$recurring_id = 0;
				}
				
				// Add_Item
				if(isset($product['add_item']) && is_array($product['add_item']) && count($product['add_item']) > 0)
				{
					$add_item = $product['add_item'];
				}
				else
				{
					$add_item = array();
				}
				$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");

				if ($product_query->num_rows) {
					$option_price = 0;
					$option_points = 0;
					$option_weight = 0;

					$option_data = array();

					foreach ($options as $product_option_id => $value) {
						$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

						if ($option_query->num_rows) {
							if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
								$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

								if ($option_value_query->num_rows) {
									if ($option_value_query->row['price_prefix'] == '+') {
										$option_price += $option_value_query->row['price'];
									} elseif ($option_value_query->row['price_prefix'] == '-') {
										$option_price -= $option_value_query->row['price'];
									}

									if ($option_value_query->row['points_prefix'] == '+') {
										$option_points += $option_value_query->row['points'];
									} elseif ($option_value_query->row['points_prefix'] == '-') {
										$option_points -= $option_value_query->row['points'];
									}

									if ($option_value_query->row['weight_prefix'] == '+') {
										$option_weight += $option_value_query->row['weight'];
									} elseif ($option_value_query->row['weight_prefix'] == '-') {
										$option_weight -= $option_value_query->row['weight'];
									}

									if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
										$stock = false;
									}

									$option_data[] = array(
										'product_option_id'       => $product_option_id,
										'product_option_value_id' => $value,
										'option_id'               => $option_query->row['option_id'],
										'option_value_id'         => $option_value_query->row['option_value_id'],
										'name'                    => $option_query->row['name'],
										'value'                   => $option_value_query->row['name'],
										'type'                    => $option_query->row['type'],
										'quantity'                => $option_value_query->row['quantity'],
										'subtract'                => $option_value_query->row['subtract'],
										'price'                   => $option_value_query->row['price'],
										'price_prefix'            => $option_value_query->row['price_prefix'],
										'points'                  => $option_value_query->row['points'],
										'points_prefix'           => $option_value_query->row['points_prefix'],
										'weight'                  => $option_value_query->row['weight'],
										'weight_prefix'           => $option_value_query->row['weight_prefix']
									);
								}
							} elseif ($option_query->row['type'] == 'checkbox' && is_array($value)) {
								foreach ($value as $product_option_value_id) {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

									if ($option_value_query->num_rows) {
										if ($option_value_query->row['price_prefix'] == '+') {
											$option_price += $option_value_query->row['price'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price -= $option_value_query->row['price'];
										}

										if ($option_value_query->row['points_prefix'] == '+') {
											$option_points += $option_value_query->row['points'];
										} elseif ($option_value_query->row['points_prefix'] == '-') {
											$option_points -= $option_value_query->row['points'];
										}

										if ($option_value_query->row['weight_prefix'] == '+') {
											$option_weight += $option_value_query->row['weight'];
										} elseif ($option_value_query->row['weight_prefix'] == '-') {
											$option_weight -= $option_value_query->row['weight'];
										}

										if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
											$stock = false;
										}

										$option_data[] = array(
											'product_option_id'       => $product_option_id,
											'product_option_value_id' => $product_option_value_id,
											'option_id'               => $option_query->row['option_id'],
											'option_value_id'         => $option_value_query->row['option_value_id'],
											'name'                    => $option_query->row['name'],
											'value'                   => $option_value_query->row['name'],
											'type'                    => $option_query->row['type'],
											'quantity'                => $option_value_query->row['quantity'],
											'subtract'                => $option_value_query->row['subtract'],
											'price'                   => $option_value_query->row['price'],
											'price_prefix'            => $option_value_query->row['price_prefix'],
											'points'                  => $option_value_query->row['points'],
											'points_prefix'           => $option_value_query->row['points_prefix'],
											'weight'                  => $option_value_query->row['weight'],
											'weight_prefix'           => $option_value_query->row['weight_prefix']
										);
									}
								}
							} elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
								$option_data[] = array(
									'product_option_id'       => $product_option_id,
									'product_option_value_id' => '',
									'option_id'               => $option_query->row['option_id'],
									'option_value_id'         => '',
									'name'                    => $option_query->row['name'],
									'value'                   => $value,
									'type'                    => $option_query->row['type'],
									'quantity'                => '',
									'subtract'                => '',
									'price'                   => '',
									'price_prefix'            => '',
									'points'                  => '',
									'points_prefix'           => '',
									'weight'                  => '',
									'weight_prefix'           => ''
								);
							}
						}
					}

					$price = $product_query->row['price'];

					// Product Discounts
					$discount_quantity = 0;

					foreach ($this->session->data['cart'] as $key_2 => $quantity_2) {
						$product_2 = (array)unserialize(base64_decode($key_2));

						if ($product_2['product_id'] == $product_id) {
							$discount_quantity += $quantity_2;
						}
					}

					$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

					if ($product_discount_query->num_rows) {
						$price = $product_discount_query->row['price'];
					}

					// Product Specials
					$product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

					if ($product_special_query->num_rows) {
						$price = $product_special_query->row['price'];
					}

					// Reward Points
					$product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

					if ($product_reward_query->num_rows) {
						$reward = $product_reward_query->row['points'];
					} else {
						$reward = 0;
					}

					// Downloads
					$download_data = array();

					$download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int)$product_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

					foreach ($download_query->rows as $download) {
						$download_data[] = array(
							'download_id' => $download['download_id'],
							'name'        => $download['name'],
							'filename'    => $download['filename'],
							'mask'        => $download['mask']
						);
					}

					// Stock
					if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $total_quantity[$product_id])) {
						$stock = false;
					}

					$recurring_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "recurring` `p` JOIN `" . DB_PREFIX . "product_recurring` `pp` ON `pp`.`recurring_id` = `p`.`recurring_id` AND `pp`.`product_id` = " . (int)$product_query->row['product_id'] . " JOIN `" . DB_PREFIX . "recurring_description` `pd` ON `pd`.`recurring_id` = `p`.`recurring_id` AND `pd`.`language_id` = " . (int)$this->config->get('config_language_id') . " WHERE `pp`.`recurring_id` = " . (int)$recurring_id . " AND `status` = 1 AND `pp`.`customer_group_id` = " . (int)$this->config->get('config_customer_group_id'));

					if($recurring_query->num_rows)
					{
						$recurring = array(
							'recurring_id'    => $recurring_id,
							'name'            => $recurring_query->row['name'],
							'frequency'       => $recurring_query->row['frequency'],
							'price'           => $recurring_query->row['price'],
							'cycle'           => $recurring_query->row['cycle'],
							'duration'        => $recurring_query->row['duration'],
							'trial'           => $recurring_query->row['trial_status'],
							'trial_frequency' => $recurring_query->row['trial_frequency'],
							'trial_price'     => $recurring_query->row['trial_price'],
							'trial_cycle'     => $recurring_query->row['trial_cycle'],
							'trial_duration'  => $recurring_query->row['trial_duration']
						);
					} 
					else
					{
						$recurring = false;
					}
					
					$add_products = array();
					
					// 加價購添加
					if(count($add_item) > 0)
					{
						foreach($add_item as $no => $item)
						{
							$add_stock = true;
							
							$sql = "SELECT p.*,pd.*,a.add_price FROM " . DB_PREFIX . "add_price a
									LEFT JOIN " . DB_PREFIX . "product p  ON (a.add_product_id = p.product_id) 
									LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
									WHERE a.product_id = '" . (int)$product_id . "' AND a.add_product_id = '" . (int)$no . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
									AND p.date_available <= NOW() AND p.status = '1'";
							$add_query = $this->db->query($sql);
			
							if($add_query->num_rows) 
							{
								
								// Reward Points
								$add_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$no . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");
			
								if($add_reward_query->num_rows)
								{
									$reward = $add_reward_query->row['points'];
								}
								else
								{
									$reward = 0;
								}			
								
								// 判斷庫存
								if(!$add_query->row['quantity'] || ($add_query->row['quantity'] < $total_quantity[$no]))
								{
									$add_stock = false;
								}
							
								$add_products[] = array(
									'key'             => $key,  // 主商品的KEY
									'product_id'      => $add_query->row['product_id'],
									'name'            => $add_query->row['name'],
									'model'           => $add_query->row['model'],
									'shipping'        => $add_query->row['shipping'],
									'image'           => $add_query->row['image'],
									'quantity'        => $item,
									'subtract'        => $add_query->row['subtract'],
									'stock'           => $add_stock,
									'is_main'         => 0,
									'main_id'         => (int)$product_id,
									'price'           => $add_query->row['add_price'],
									'total'           => $add_query->row['add_price'] * $item,
									'reward'          => $reward * $item,
									'points'          => ($add_query->row['points'] ? ($add_query->row['points']) * $item : 0),
									'tax_class_id'    => $add_query->row['tax_class_id'],
									'weight'          => ($add_query->row['weight']) * $item,
									'weight_class_id' => $add_query->row['weight_class_id'],
									'length'          => $add_query->row['length'],
									'width'           => $add_query->row['width'],
									'height'          => $add_query->row['height'],
									'length_class_id' => $add_query->row['length_class_id']
								);
							}
						}
					}
					
					$this->data[$key] = array(
						'key'             => $key,
						'product_id'      => $product_query->row['product_id'],
						'name'            => $product_query->row['name'],
						'model'           => $product_query->row['model'],
						'shipping'        => $product_query->row['shipping'],
						'image'           => $product_query->row['image'],
						'option'          => $option_data,
						'download'        => $download_data,
						'quantity'        => $quantity,
						'minimum'         => $product_query->row['minimum'],
						'subtract'        => $product_query->row['subtract'],
						'stock'           => $stock,
						'is_main'         => 1,
						'main_id'         => 0,
						'price'           => ($price + $option_price),
						'total'           => ($price + $option_price) * $quantity,
						'reward'          => $reward * $quantity,
						'points'          => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $quantity : 0),
						'tax_class_id'    => $product_query->row['tax_class_id'],
						'weight'          => ($product_query->row['weight'] + $option_weight) * $quantity,
						'weight_class_id' => $product_query->row['weight_class_id'],
						'length'          => $product_query->row['length'],
						'width'           => $product_query->row['width'],
						'height'          => $product_query->row['height'],
						'length_class_id' => $product_query->row['length_class_id'],
						'recurring'       => $recurring,
						'add_products'    => $add_products
					);
					
				}
				else
				{
					$this->remove($key);
				}
			}
		}
		return $this->data;
	}
	
	public function getItem($input)
	{
		$sql = "SELECT p.*,pd.*,a.add_price FROM " . DB_PREFIX . "product p 
				LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
				LEFT JOIN " . DB_PREFIX . "add_price a ON (p.product_id = a.add_product_id) 
				WHERE p.product_id = '" . (int)$input['product_id'] . "' 
				AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
				AND p.date_available <= NOW() AND a.product_id = '" . (int)$input['main_id'] . "' 
				AND p.status = '1'";
				
		$product_query = $this->db->query($sql);

		if($product_query->num_rows > 0)
		{
			// Downloads
			$download_data = array();

			$download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int)$input['product_id'] . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

			foreach ($download_query->rows as $download) {
				$download_data[] = array(
					'download_id' => $download['download_id'],
					'name'        => $download['name'],
					'filename'    => $download['filename'],
					'mask'        => $download['mask']
				);
			}

			// Stock
			if(!$input['quantity'] || ($input['quantity'] < $product_query->row['quantity']))
			{
				$stock = false;
			}

			$recurring = false;		
			
			
			$add_items = array(
				'key'             => $key,
				'product_id'      => $product_query->row['product_id'],
				'name'            => $product_query->row['name'],
				'model'           => $product_query->row['model'],
				'shipping'        => $product_query->row['shipping'],
				'image'           => $product_query->row['image'],
				'option'          => array(),
				'download'        => $download_data,
				'quantity'        => $input['quantity'],
				'minimum'         => $product_query->row['minimum'],
				'subtract'        => $product_query->row['subtract'],
				'stock'           => $stock,
				'is_main'         => 0,
				'main_id'         => (int)$input['main_id'],
				'price'           => $product_query->row['add_price'],
				'total'           => ($product_query->row['add_price']) * $input['quantity'],
				'reward'          => 0,
				'points'          => 0,
				'tax_class_id'    => $product_query->row['tax_class_id'],
				'weight'          => ($product_query->row['weight'] + $option_weight) * $input['quantity'],
				'weight_class_id' => $product_query->row['weight_class_id'],
				'length'          => $product_query->row['length'],
				'width'           => $product_query->row['width'],
				'height'          => $product_query->row['height'],
				'length_class_id' => $product_query->row['length_class_id'],
				'recurring'       => array()
			);

		
		}
		else
		{
			return false;
		}
		
	}

	public function getRecurringProducts() {
		$recurring_products = array();

		foreach ($this->getProducts() as $key => $value) {
			if ($value['recurring']) {
				$recurring_products[$key] = $value;
			}
		}

		return $recurring_products;
	}

	public function add($product_id, $qty = 1, $option = array(), $recurring_id = 0, $add = array()) {
		$this->data = array();

		$product['product_id'] = (int)$product_id;

		if ($option) {
			$product['option'] = $option;
		}

		if ($recurring_id) {
			$product['recurring_id'] = (int)$recurring_id;
		}
		
		if(is_array($add) && count($add) > 0)
		{
			foreach($add as $kkk => $ad)
			{
				if($ad > $qty)	
				{
					$add[$kkk] = $qty;
				}
			}
			$product['add_item'] = $add;
		}

		$key = base64_encode(serialize($product));

		if ((int)$qty && ((int)$qty > 0)) {
			if (!isset($this->session->data['cart'][$key])) {
				$this->session->data['cart'][$key] = (int)$qty;
			} else {
				$this->session->data['cart'][$key] += (int)$qty;
			}
		}
	}

	public function update($key, $qty) {
		$this->data = array();

		if ((int)$qty && ((int)$qty > 0) && isset($this->session->data['cart'][$key])) {
			$this->session->data['cart'][$key] = (int)$qty;
		} else {
			$this->remove($key);
		}
	}

	public function remove($key) {
		$this->data = array();

		unset($this->session->data['cart'][$key]);
	}

	// 修改加價購	
	public function update_add_item($key, $item, $qty)
	{
		$this->data = array();
		$product = (array)unserialize(base64_decode($key));
		$adds = array();
		$quantity = $this->session->data['cart'][$key];
		
		// 不能比本來的商品多
		if($qty > $quantity)
		{
			$qty = $quantity;
		}
		$product['add_item'][(int)$item] = (int)$qty;
		
		$new = base64_encode(serialize($product));

		unset($this->session->data['cart'][$key]);

		if((int)$quantity && ((int)$quantity > 0))
		{
			if(!isset($this->session->data['cart'][$new]))
			{
				$this->session->data['cart'][$new] = (int)$quantity;
			}
			else
			{
				$this->session->data['cart'][$new] += (int)$quantity;
			}
		}
	}

	// 移除加價購
	public function remove_add_item($key, $item)
	{
		$this->data = array();
		$product = (array)unserialize(base64_decode($key));
		$adds = array();
		if(isset($product['add_item'][(int)$item]))
		{
			unset($product['add_item'][(int)$item]);
		}
		
		$quantity = $this->session->data['cart'][$key];
		
		$new = base64_encode(serialize($product));

		unset($this->session->data['cart'][$key]);

		if((int)$quantity && ((int)$quantity > 0))
		{
			if(!isset($this->session->data['cart'][$new]))
			{
				$this->session->data['cart'][$new] = (int)$quantity;
			}
			else
			{
				$this->session->data['cart'][$new] += (int)$quantity;
			}
		}
	}

	public function clear() {
		$this->data = array();

		$this->session->data['cart'] = array();
	}

	public function getWeight() {
		$weight = 0;

		foreach ($this->getProducts() as $product) {
			if ($product['shipping']) {
				$weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
			}
			
			if(count($product['add_products']) > 0)
			{
				foreach($product['add_products'] as $add)
				{
					if ($add['shipping'])
					{
						$weight += $this->weight->convert($add['weight'], $add['weight_class_id'], $this->config->get('config_weight_class_id'));
					}
				}
			}
			
		}

		return $weight;
	}

	public function getSubTotal() {
		$total = 0;

		foreach($this->getProducts() as $product)
		{
			$total += $product['total'];
			
			if(count($product['add_products']) > 0)
			{
				foreach($product['add_products'] as $add)
				{
					$total += $add['total'];
				}
			}
			
		}

		return $total;
	}

	public function getTaxes() {
		$tax_data = array();

		foreach ($this->getProducts() as $product) {
			if ($product['tax_class_id']) {
				$tax_rates = $this->tax->getRates($product['price'], $product['tax_class_id']);

				foreach ($tax_rates as $tax_rate) {
					if (!isset($tax_data[$tax_rate['tax_rate_id']])) {
						$tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $product['quantity']);
					} else {
						$tax_data[$tax_rate['tax_rate_id']] += ($tax_rate['amount'] * $product['quantity']);
					}
				}
			}
			
			if(count($product['add_products']) > 0)
			{
				foreach($product['add_products'] as $add)
				{
					if ($add['tax_class_id']) {
						$tax_rates = $this->tax->getRates($add['price'], $add['tax_class_id']);
		
						foreach ($tax_rates as $tax_rate) {
							if (!isset($tax_data[$tax_rate['tax_rate_id']])) {
								$tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $add['quantity']);
							} else {
								$tax_data[$tax_rate['tax_rate_id']] += ($tax_rate['amount'] * $add['quantity']);
							}
						}
					}
				}
			}
		}

		return $tax_data;
	}

	public function getTotal() {
		$total = 0;

		foreach ($this->getProducts() as $product) 
		{
			$total += $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'];
			if(count($product['add_products']) > 0)
			{
				foreach($product['add_products'] as $add)
				{
					$total += $this->tax->calculate($add['price'], $add['tax_class_id'], $this->config->get('config_tax')) * $add['quantity'];
				}
			}
		}

		return $total;
	}

	public function countProducts() {
		$product_total = 0;

		$products = $this->getProducts();

		foreach ($products as $product) {
			$product_total += $product['quantity'];
			if(count($product['add_products']) > 0)
			{
				foreach($product['add_products'] as $add)
				{
					$product_total += $add['quantity'];
				}
			}			
		}

		return $product_total;
	}

	public function hasProducts() {
		return count($this->session->data['cart']);
	}

	public function hasRecurringProducts() {
		return count($this->getRecurringProducts());
	}

	public function hasStock() {
		$stock = true;

		foreach ($this->getProducts() as $product) {
			if (!$product['stock']) {
				$stock = false;
			}
			if(count($product['add_products']) > 0)
			{
				foreach($product['add_products'] as $add)
				{
					if(!$add['stock'])
					{
						$stock = false;
		
						break;
					}
				}
			}
		}

		return $stock;
	}

	public function hasShipping() {
		$shipping = false;

		foreach ($this->getProducts() as $product) {
			if ($product['shipping']) {
				$shipping = true;

				break;
			}
			if(count($product['add_products']) > 0)
			{
				foreach($product['add_products'] as $add)
				{
					if($add['shipping'])
					{
						$shipping = true;
		
						break;
					}
				}
			}
		}

		return $shipping;
	}

	public function hasDownload() {
		$download = false;

		foreach ($this->getProducts() as $product) {
			if ($product['download']) {
				$download = true;

				break;
			}
		}

		return $download;
	}
}