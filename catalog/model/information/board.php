<?php
class ModelInformationBoard extends Model 
{
	public function getBoards($data) 
	{
		$sql = 'SELECT * FROM '.DB_PREFIX.'board WHERE del = 0 AND `show` = 1 ORDER BY id DESC';
		
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
	
	public function addBoard($data)
	{
		$sql = 'INSERT INTO '.DB_PREFIX.'board SET name = "'.$this->db->escape($data['name']).'", title = "'.$this->db->escape($data['title']).'", email = "'.$this->db->escape($data['email']).'", content = "'.$this->db->escape($data['content']).'", time = "'.$this->db->escape(date('Y-m-d H:i:s')).'" ';
		
		$query = $this->db->query($sql);
		
		$id = $this->db->getLastId();
		
		return $id;
	}
	
	public function getBoardCnt() 
	{
		$sql = 'SELECT COUNT(*) as cnt FROM '.DB_PREFIX.'board WHERE del = 0 AND `show` = 1 ';
		
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
}