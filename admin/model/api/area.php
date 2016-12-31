<?php
class ModelApiArea extends Model {
	function getQuote($address) {
		$this->load->language('shipping/flat');

		$sql = "SELECT z.*,g.fee,g.name FROM " . DB_PREFIX . "zone_to_geo_zone z
				LEFT JOIN geo_zone g ON z.geo_zone_id = g.geo_zone_id
				WHERE z.country_id = '" . (int)$address['country_id'] . "' AND (z.zone_id = '" . (int)$address['zone_id'] . "' OR z.zone_id = '0') ORDER BY z.geo_zone_id ASC LIMIT 1";
				
		$query = $this->db->query($sql);

		if($query->num_rows) {
			$fee = (int)$query->rows[0]['fee'];
			$name = $query->rows[0]['name'];
		}else{
			$fee = (int)$this->config->get('area_etc_fee');
			$name = '其他地區';
		}

		$method_data = array();

		$quote_data = array();

		$quote_data['area'] = array(
			'code'         => 'area.area',
			'title'        => $name,
			'cost'         => $fee,
			'tax_class_id' => 0,
			'text'         => $this->currency->format($this->tax->calculate($fee, 0, $this->config->get('config_tax')))
		);

		$method_data = array(
			'code'       => 'area',
			'title'      => '運費',
			'quote'      => $quote_data,
			'sort_order' => $this->config->get('area_sort_order'),
			'error'      => false
		);


		return $method_data;
	}
}