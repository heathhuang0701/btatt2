<?php
class ControllerArtickTest extends Controller {
	private $error = array();

	public function index() 
	{
		pre($this->cart->getProd());
		exit();	
	}
	
	public function clear() 
	{
		$this->cart->clear();
		exit();	
	}
	
	public function yooo() 
	{
		$sql = 'select product_id,description from product_description where description <> "" AND meta_keyword = "1" limit 500';

		$res = $this->db->query($sql);
		
		if($res->num_rows > 0)
		{
			$result = $res->rows;
			foreach($result as $row)
			{
				$des = str_replace('height=','backup=',$row['description']);

				$sql = 'update product_description set description = "'.$des.'", meta_keyword = "2" where language_id = 1 AND product_id = '.(int)$row['product_id'].' limit 1';
				pre($sql);
				$this->db->query($sql);
				
				echo $row['product_id'].'<br />';
			}
		}
		exit();	
	}
	
}