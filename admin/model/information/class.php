<?php
class ModelInformationClass extends Model 
{
	
	public function addClass($data)
	{
		$sql = 'INSERT INTO '.DB_PREFIX.'class SET title = "'.$this->db->escape($data['title']).'", info = "'.$this->db->escape($data['info']).'", description = "'.$this->db->escape($data['description']).'",image = "'.$this->db->escape($data['image']).'",sort = '.(int)$data['sort'].' ';

		$query = $this->db->query($sql);
		
		$id = $this->db->getLastId();
		
		return $id;
	}

	public function editClass($id, $data)
	{
		$sql = 'UPDATE '.DB_PREFIX.'class SET title = "'.$this->db->escape($data['title']).'", info = "'.$this->db->escape($data['info']).'", description = "'.$this->db->escape($data['description']).'",image = "'.$this->db->escape($data['image']).'", sort='.(int)$data['sort'].' WHERE id = '.(int)$id.' LIMIT 1 ';
		
		$query = $this->db->query($sql);
	}

	public function deleteClass($id)
	{
		$sql = 'DELETE FROM '.DB_PREFIX.'class WHERE id = '.(int)$id.' LIMIT 1 ';
		$this->db->query($sql);
	}
	public function getClasses($data) 
	{
		$sql = 'SELECT id,title,image,info,sort FROM '.DB_PREFIX.'class ORDER BY sort ASC, id DESC';
		
		if(!$data['limit'])
		{
			$limit = 20;	
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