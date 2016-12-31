<?php
class ModelInformationNews extends Model 
{
	
	public function addNews($data)
	{
		$sql = 'INSERT INTO '.DB_PREFIX.'news SET title = "'.$this->db->escape($data['title']).'", content = "'.$this->db->escape($data['content']).'", time = "'.$this->db->escape($data['time']).'", image = "'.$this->db->escape($data['image']).'", `show` = '.(int)$data['show'].' ';

		$query = $this->db->query($sql);
		
		$id = $this->db->getLastId();
		
		return $id;
	}

	public function editNews($id, $data)
	{
		$sql = 'UPDATE '.DB_PREFIX.'news SET title = "'.$this->db->escape($data['title']).'", content = "'.$this->db->escape($data['content']).'", time = "'.$this->db->escape($data['time']).'", image = "'.$this->db->escape($data['image']).'", `show` = '.(int)$data['show'].' WHERE id = '.(int)$id.' LIMIT 1 ';

		$query = $this->db->query($sql);
	}

	public function deleteNews($id)
	{
		$sql = 'DELETE FROM '.DB_PREFIX.'news WHERE id = '.(int)$id.' LIMIT 1 ';
		$this->db->query($sql);
	}
	public function getNewses($data) 
	{
		$sql = 'SELECT * FROM '.DB_PREFIX.'news ORDER BY id DESC';
		
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
	
	public function getNewsCnt() 
	{
		$sql = 'SELECT COUNT(*) as cnt FROM '.DB_PREFIX.'news ORDER BY id DESC';
		
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
	
	
	public function getNews($data) 
	{
		$sql = 'SELECT * FROM '.DB_PREFIX.'news WHERE id = '.(int)$data['id'].'';
		
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