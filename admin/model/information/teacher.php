<?php
class ModelInformationTeacher extends Model 
{
	public function addTeacher($data)
	{
		$sql = 'INSERT INTO '.DB_PREFIX.'teacher SET name = "'.$this->db->escape($data['name']).'", info = "'.$this->db->escape($data['info']).'", image_list = "'.$this->db->escape($data['image_list']).'", image_circle = "'.$this->db->escape($data['image_circle']).'", thumb = "'.$this->db->escape(serialize($data['thumb'])).'", sort = '.(int)$data['sort'].' ';

		$query = $this->db->query($sql);
		
		$id = $this->db->getLastId();
		
		return $id;
	}

	public function editTeacher($id,$data)
	{
		$sql = 'UPDATE '.DB_PREFIX.'teacher SET name = "'.$this->db->escape($data['name']).'", info = "'.$this->db->escape($data['info']).'", image_list = "'.$this->db->escape($data['image_list']).'", image_circle = "'.$this->db->escape($data['image_circle']).'", thumb = "'.$this->db->escape(serialize($data['thumb'])).'", sort = '.(int)$data['sort'].' WHERE id = '.(int)$id.' ';

		$query = $this->db->query($sql);
	}

	public function deleteTeacher($id)
	{
		$sql = 'DELETE FROM '.DB_PREFIX.'teacher WHERE id = '.(int)$id.' LIMIT 1 ';
		$this->db->query($sql);
	}

	public function getTeachers($data) 
	{
		$sql = 'SELECT id,name,image_list,sort FROM '.DB_PREFIX.'teacher ORDER BY sort ASC, id ASC ';
		
		if(!$data['limit'])
		{
			$limit = 15;	
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
	
	public function getTeacher($data) 
	{
		$sql = 'SELECT * FROM '.DB_PREFIX.'teacher WHERE id = '.(int)$data['id'].' ';
		
		$query = $this->db->query($sql);

		if($query->num_rows > 0)
		{
			$res = $query->row;
			$res['thumb'] = unserialize($query->row['thumb']);	
			return $res;
		}
		else
		{
			return false;	
		}
	}
	
	public function getTeacherCnt() 
	{
		$sql = 'SELECT COUNT(*) as cnt FROM '.DB_PREFIX.'teacher ';
		
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