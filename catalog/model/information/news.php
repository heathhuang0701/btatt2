<?php
class ModelInformationNews extends Model 
{
	public function getNewses($data) 
	{
		$sql = 'SELECT * FROM '.DB_PREFIX.'news WHERE `show` = 1 ORDER BY time DESC';
		
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
		
		$sql .= ' LIMIT '.(int)(($page-1)*$limit).' , '.$limit.' ';

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
		$sql = 'SELECT COUNT(*) as cnt FROM '.DB_PREFIX.'news WHERE `show` = 1 ORDER BY time DESC';
		
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
		$sql = 'SELECT * FROM '.DB_PREFIX.'news WHERE `show` = 1 AND id = '.(int)$data['id'].'';
		
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