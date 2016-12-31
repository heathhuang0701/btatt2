<?php

function pre($val) 
{
	echo '<pre>';
	print_r($val);
	echo '</pre>';
}

function cut_string($str,$len=10)
{
	return ((mb_strlen($str, "UTF8")>$len) ? mb_substr($str,0,$len, "UTF8") : $str).' '.((mb_strlen($str, "UTF8")>$len) ? nl2br('...') : nl2br(''));
}

function url_direct($txt,$url)
{
	if($url == NULL)
	{
		$url = 'index.php';	
	}
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
	echo '<script>';
	if($txt != '')
	{
		echo "alert('".$txt."');";
	}
	echo 'window.location.href="'.$url.'";';
	echo '</script>';
}

# 判斷時間
function isTime($t)
{
	$time = strtotime($t);
	if($time === false)
	{
		return false;
	}
	else
	{
		return date('Y-m-d H:i:s',$time);
	}
}


#main
function execSQL($db,$sql,$params,$type,$where=NULL,$clause=NULL)
{
	if(defined('DB_DEBUG'))
	{
		echo 'SQL語法: '.$sql.'<br />';
		echo '輸入參數:<br />';
		pre($params);

	}
	#detect the params and replace the symbol in the sql		
	$sql = fetch_sql($db,$sql,$params,$type,$where,$clause);

//exit();
	if(defined('DB_DEBUG'))
	{
		echo '完整SQL: '.$sql.'<br />';
		echo '<hr />';
	}
	$raw_result = $db->db->query($sql);

	if(mysql_error())
	{
		if(defined('DB_DEBUG'))
		{
			echo mysql_error().'<br />';
		}
		die(mysql_error());
	}

	#deal different works according to type
	#select: gen result array
	#update: gen affected rows 
	#insert: gen insert row id

	if($type == 'upd')
	{
		return $db->db->countAffected();
	}
	elseif($type == 'ins')
	{
		return $db->db->getLastId();
	}
	elseif($type == 'sel')
	{
		return trans_array($raw_result);
	}
	elseif($type == 'del')
	{
		return $db->db->countAffected();
	}
}



#fuse param array into sql phrase
function fetch_sql($db,$sql,$params,$type,$where=NULL,$clause=NULL)
{
	if($sql != '')
	{
		switch($type)
		{
			case 'sel':
			case 'del':
				#check symbol length in the sql 
				$arr_sql = explode('?',$sql);
				
				if(count($params) != (count($arr_sql)-1))
				{
					die('params count not matched the symbol');
					exit();
				}
				else
				{
					$sql = $arr_sql[0];
					if(count($params) > 0)
					{
						foreach($params as $key => $param)
						{
							#may have some detect function to prevent SQL injection
							$sql .= data_check($db,$param);
							$sql .= $arr_sql[$key+1];
						}
					}
				}
			break;
			
			case 'upd';
				#check symbol length in the sql 
				if(count($params) == 0 || $where == '')
				{
					die('params / conditions missing');
					exit();
				}
				else
				{
					$txt = ' SET ';
					$cnt = 1;
					foreach($params as $key => $param)
					{
						#may have some detect function to prevent SQL injection
						$txt .= ' '.$key.' = ';
						$txt .= data_check($db,$param);
						
						if($cnt < count($params))
						{
							$txt .= ',';
						}
						$cnt = $cnt + 1;
					}

					$txt .= ' WHERE ';
					
					#check symbol length in the where phrase
					$arr_sql = explode('?',$where);

					if(count($clause) != (count($arr_sql)-1))
					{
						die('params count not matched the where symbol');
						exit();
					}
					else
					{
						$txt .= $arr_sql[0];
						if(count($clause) > 0)
						{
							foreach($clause as $ky => $clau)
							{
								#may have some detect function to prevent SQL injection
								$txt .= data_check($db,$clau);
								$txt .= $arr_sql[$ky+1];
							}
						}
					}
					$sql .= $txt;
				}
			break;
			
			case 'ins':
				//INSERT INTO `資料表`(`欄位1`,`欄位2`) VALUES ( '資料1' , '資料2' )
				if(count($params) > 0)
				{
					$cnt = 1;
					$front = '';
					$end = '';
					foreach($params as $key => $param)
					{
						$front .= '`'.$key.'`';
						$end .= data_check($db,$param);
						
						if($cnt < count($params))
						{
							$front .= ',';
							$end .= ',';
						}
						$cnt = $cnt + 1;

					}
				}
				$sql .= ' ('.$front.') VALUES ('.$end.') ';
			break;
		}
	}
	return $sql;
}

# transform select result into array type
function trans_array($result)
{
	if($result == '')
	{
		return false;
	}
	else
	{
		return $result->rows;
	}
}

# check the data type and return with appropriate value
function data_check($db,$value)
{
	if(empty($value) && $value !== 0)
	{
		return '""';
	}
	elseif(is_null($value))
	{
		return '""';
	}
	elseif(is_numeric($value))
	{
		# 多判斷是否為手機格式
		if($value[0] == '0' && $value[1] == '9')
		{
			return '"'.$value.'"';	
		}
		# 小數點
		elseif(strpos($value,'.') !== false)
		{
			return '"'.$value.'"';	
		}
		# 首位為0
		elseif($value[0] == '0')
		{
			return '"'.($value).'"';
		}
		# 最大最小值		
		elseif($value > 2147483647 || $value < -2147483647 )
		{
			return $value;
		}
		else
		{
			return intval($value);
		}
	}

	# expection: seem as string 
	else
	{
		return '"'.$db->db->escape($value).'"';
	}
}

function dbSelectPrepare($db,$sql,$arr)
{		
	return execSQL($db,$sql,$arr,'sel');
}

function dbInsertPrepare($db,$sql,$arr)
{		
	return execSQL($db,$sql,$arr,'ins');
}

function dbUpdatePrepare($db,$sql,$arr,$where,$clause)
{
	return execSQL($db,$sql,$arr,'upd',$where,$clause);
}

function dbDeletePrepare($db,$sql,$arr)
{
	return execSQL($db,$sql,$arr,'del');
}

function ft($input, $class = 1)
{
  	if(isset($input) && !empty($input))
	{
		switch($class)
		{
			//數字
			case 0:
			  	$is_num = 0;
				if(!is_numeric($input))
				{
					echo "數字格式有問題!";
					exit();  
				}
				return $input;
			break;
			
			//字串
			case 1:
				return filter_var($input, FILTER_SANITIZE_STRING);
			break;
			
		}
	}
   	return $input; 
}

function check_date_time($date_time)
{
    $check = false;
    if(strtotime($date_time))
	{
    	//不管檢查時間或日期格式，都只取第一個陣列值
        list($first) = explode(" ", $date_time);
		
        //如果包含「:」符號，表示只檢查時間
        if(strpos($first, ":"))
		{
            //strtotime函數已經檢查過，直接給true
            $check = date('Y-m-d H:i:s',strtotime($date_time));
        }
		else
		{
            //將日期分年、月、日，區隔符用「-/」都適用
            list($y, $m, $d) = preg_split("/[-\/]/", $first);
			
            //檢查是否為4碼的西元年及日期邏輯(潤年、潤月、潤日）
            if((substr($date_time, 0, 4) == $y) && checkdate($m, $d, $y))
			{
                $check = date('Y-m-d H:i:s',strtotime($date_time));
            }
        }
    }
 	return $check;
}

function db_debug()
{
	define('DB_DEBUG',1);	
}

# 陣列搜尋(遞迴)
# mod: 1(關鍵字保留) 2(不等於關鍵字保留)
# type: 1(原索引Key保留) 2(原索引Key不保留)

function str_arr($arr=NULL,$txt=NULL,$mod=1,$type=1)
{
	if($arr)
	{
		foreach($arr as $key => $row)
		{
			if(is_array($row))
			{
				if($type==1)
				{
					$a[$key] = str_arr($row,$txt,$mod);
				}
				else
				{
					$a[] = str_arr($row,$txt,$mod);	
				}
			}
			else
			{
				if($mode==1)
				{
					if(strstr($row,$txt))
					{
						if($type==1)
						{
							$a[$key] = $row;
						}
						else
						{
							$a[] = $row;
						}				
					}
				}
				else
				{
					if(!strstr($row,$txt))
					{
						if($type==1)
						{
							$a[$key] = $row;
						}
						else
						{
							$a[] = $row;
						}				
					}
				}
			}
		}
	}
	return $a;
}


function set_token($origin, $field = TK)
{
	return md5($origin.$field);
}

function is_token($origin, $token, $field = TK)
{
	$tk = md5($origin.$field);
	if($token != $tk)
	{
		return false;
	}
	else
	{
		return true;
	}
}

# CURL
function curl_data($url)
{
	$res = array();
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$temp = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($temp);
	
	return std_to_array($data);
}

# 處理std class
function std_to_array($std) 
{
    if(is_object($std))
	{
        $std = get_object_vars($std);
    }

    if(is_array($std))
	{
        return array_map(__FUNCTION__, $std);
    } 
	else 
	{
        return $std;
    }
}

function catesort($a, $b)
{
    if($a['sort'] >= $b['sort']) 
	{
        return 1;
    }
    else
	{
		return -1;	
	}
}
?>