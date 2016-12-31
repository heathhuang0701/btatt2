<?php
class ModelInformationBoard extends Model 
{
	public function addBoard($data)
	{
		$sql = 'INSERT INTO '.DB_PREFIX.'board SET name = "'.$this->db->escape($data['name']).'", title = "'.$this->db->escape($data['title']).'", email = "'.$this->db->escape($data['email']).'", content = "'.$this->db->escape($data['content']).'", time = "'.$this->db->escape(date('Y-m-d H:i:s')).'" ';

		$query = $this->db->query($sql);
		
		$id = $this->db->getLastId();
		
		return $id;
	}
	
	public function replyBoard($id,$data)
	{
		$sql = 'UPDATE '.DB_PREFIX.'board SET reply = "'.$this->db->escape($data['reply']).'", reply_user_id = "'.(int)$this->user->getId().'", reply_time = "'.$this->db->escape($data['reply_time']).'" WHERE id = '.(int)$id.' AND del = 0 LIMIT 1 ';
		$query = $this->db->query($sql);
	}
	
	public function showBoard($id)
	{
		$sql = 'UPDATE board SET `show` = (CASE `show` WHEN 1 THEN 0 ELSE 1 END) WHERE id = '.(int)$id;
		$query = $this->db->query($sql);
	}

	public function editBoard($id, $data)
	{
		$sql = 'UPDATE'.DB_PREFIX.'board SET name = "'.$this->db->escape($data['name']).'", title = "'.$this->db->escape($data['title']).'", email = "'.$this->db->escape($data['email']).'", content = "'.$this->db->escape($data['content']).'", time = "'.$this->db->escape($data['time']).'", type = 0, reply_id = 0, del = 0 WHERE id= ';
		
		$query = $this->db->query($sql);
	}

	public function deleteBoard($id)
	{
		$sql = 'UPDATE '.DB_PREFIX.'board SET del = 1 WHERE id = '.(int)$id.' LIMIT 1 ';
		$this->db->query($sql);
	}
	
	public function getBoards($data) 
	{
		$sql = 'SELECT * FROM '.DB_PREFIX.'board WHERE del = 0 ORDER BY id DESC';
		
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
	
	public function getBoardCnt() 
	{
		$sql = 'SELECT COUNT(*) as cnt FROM '.DB_PREFIX.'board WHERE del = 0';
		
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
	
	public function getBoard($id) 
	{
		$sql = 'SELECT * FROM '.DB_PREFIX.'board WHERE id = '.(int)$id.' AND del = 0 LIMIT 1';
		
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