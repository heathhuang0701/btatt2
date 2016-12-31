<?php
class ModelCatalogAddPrice extends Model
{
	public function addItem($data)
	{
		$this->db->query("INSERT INTO " . DB_PREFIX . "add_price SET product_id = '" . (int)$data['product_id'] . "',add_product_id = '" . (int)$data['add_product_id'] . "',add_price = '" . (int)$data['add_price'] . "' ");

		$add = $this->db->getLastId();
		return $add;
	}

	public function eraseItem($product_id) 
	{
		$this->db->query("DELETE FROM " . DB_PREFIX . "add_price WHERE product_id = '" . (int)$product_id . "'");
	}

	public function getItem($product_id) 
	{
		$sql = "SELECT * FROM " . DB_PREFIX . "add_price a 
				LEFT JOIN " . DB_PREFIX . "product p ON (a.add_product_id = p.product_id) 
				LEFT JOIN " . DB_PREFIX . "product_description pd ON (a.add_product_id = pd.product_id) 
				WHERE a.product_id = '" . (int)$product_id . "' AND p.status = 1
				AND pd.language_id = ".(int)$this->config->get('config_language_id')." ";
		
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getCnt()
	{
		$sql = "SELECT COUNT(add_product_id) AS cnt FROM " . DB_PREFIX . "add_price a 
				WHERE a.product_id = '" . (int)$product_id . "' AND p.status = 1";
		
		$query = $this->db->query($sql);

		return $query->row['cnt'];	
	}
}