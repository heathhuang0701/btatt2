<?php
class ModelInformationClass extends Model 
{
	public function getClasses($data) 
	{
		$sql = 'SELECT id,title,image,info FROM '.DB_PREFIX.'class ORDER BY id DESC';
		
		if(!$data['limit'])
		{
			$limit = 8;	
		}
		else
		{
			 $limit = (int)$data['limit'];
		}
		
		if(!$data['page'])
		{
			$page = 1;	
		}
		else
		{
			 $page = (int)$data['page'];
		}
		
		$sql .= ' LIMIT '.(int)($page-1).' , '.$limit.' ';

		$query = $this->db->query($sql);

		if($query->num_rows > 0)
		{
			return $query->rows;
		}
		else
		{
			return false;	
		}
	}
	
	public function getClassCnt() 
	{
		$sql = 'SELECT COUNT(*) as cnt FROM '.DB_PREFIX.'class ORDER BY id DESC';
		
		$query = $this->db->query($sql);

		if($query->num_rows > 0)
		{
			return $query->row['cnt'];
		}
		else
		{
			return 0;	
		}
	}	
	
	
	public function getClass($data) 
	{
		$sql = 'SELECT * FROM '.DB_PREFIX.'class WHERE id = '.(int)$data['id'].'';
		
		$query = $this->db->query($sql);

		if($query->num_rows > 0)
		{
			return $query->row;
		}
		else
		{
			return false;	
		}
	}
}