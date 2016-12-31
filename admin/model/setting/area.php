<?php
class ModelSettingArea extends Model
{
	public function getArea()
	{
		$sql = 'SELECT * FROM '.DB_PREFIX.'geo_zone WHERE geo_zone_id ORDER BY geo_zone_id ASC ';

		$query = $this->db->query($sql);
		$ret = array();
		if($query->num_rows >0)
		{
			foreach($query->rows as $row)
			{
				$ret['geo'.$row['geo_zone_id']] = array(
					'id' => $row['geo_zone_id'],
					'name' => $row['name'],
					'fee' => $row['fee']
				);
			}
		}
		$ret['etc'] = array(
			'id' => 'etc',
			'name' => '其他地區',
			'fee' => $this->config->get('area_etc_fee')
		);
		
		return $ret;
	}

	public function editArea($data)
	{
		if(is_array($data))
		{
			foreach($data as $key => $value)
			{
				if($key == 'etc')
				{
					$this->db->query('UPDATE '.DB_PREFIX.'setting SET value = '.(int)$data['etc'].' WHERE `key` = "area_etc_fee"');	
				}
				else
				{
					$exp = explode('geo',$key);
					$this->db->query('UPDATE '.DB_PREFIX.'geo_zone SET fee = '.(int)$value.' WHERE geo_zone_id = '.(int)$exp[1]);
				}
			}
		}
	}
}