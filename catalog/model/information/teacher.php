<?php
class ModelInformationTeacher extends Model 
{
	public function getTeachers() 
	{
		$sql = 'SELECT id,name,image_list FROM '.DB_PREFIX.'teacher ORDER BY sort ASC';
		
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
		
		$sql = 'SELECT * FROM '.DB_PREFIX.'teacher WHERE id = '.(int)$data['id'].'';
		
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
}