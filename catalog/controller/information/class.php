<?php
class ControllerInformationClass extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('information/class');
		
		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/index')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/class')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$this->load->model('information/class');
		$this->load->model('tool/image');

		if(isset($this->request->get['page']) && (int)$this->request->get['page'] > 1)
		{
			$page = (int)$this->request->get['page'];
		}
		else
		{
			$page = 1;
		}

		// 計算總比數 顯示 前後二 上下一頁
		$total = $this->model_information_class->getClassCnt();
		$limit = 8; 
		$all_page = (ceil($total/$limit)); 
		$data['pgcnt'] = 5;
		if($page > $all_page) $page = $all_page;
		
		if($page>1) $data['pagination']['last'] = $this->url->link('information/class','page='.(int)($page-1));
		for($i=($page-2);$i<=($page+2);$i++)
		{
			if($i > 0 && $i <= $all_page) 
			{
				$data['pagination']['num'][$i] = $this->url->link('information/class','page='.(int)$i);
				$data['pgcnt']--;
			}
		}
		if($page < $all_page) $data['pagination']['next'] = $this->url->link('information/class','page='.(int)($page+1));

		$filter = array(
			'page' => $page,
			'limit' => $limit
		);

		$data['classes'] = array();
		$classes = $this->model_information_class->getClasses($filter);
		
		
		
		if($classes)
		{
			foreach($classes as $class)
			{
				if($class['image'])
				{
					$image = $this->model_tool_image->resize($class['image'], 400,300);
				}
				else
				{
					$image = $this->model_tool_image->resize('placeholder.png', 400,300);
				}

				$data['classes'][] = array(
					'id' => $class['id'],
					'title' => $class['title'],
					'info' => $class['info'],
					'thumb' => $image,
					'href' => $this->url->link('information/class/info','id='.(int)$class['id'],'SSL')
				);
			}
		}
		
		

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/class_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/class_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('belleza/template/information/class_list.tpl', $data));
		}
	}
	

	public function info()
	{
		$this->load->language('information/class');
		
		$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
	
		$this->load->model('information/class');
		$this->load->model('tool/image');

		if(isset($this->request->get['id']) && $this->request->get['id'] != '')
		{
			$id = (int)$this->request->get['id'];	
		}
		else
		{
			$id = 0;	
		}
		$class = $this->model_information_class->getClass(array('id'=>$id));

		if($class)
		{
			$this->document->setTitle($class['name']);
	
			$data['breadcrumbs'] = array();
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/index')
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('information/class')
			);
			
			$data['breadcrumbs'][] = array(
				'text' => $class['name'],
				'href' => $this->url->link('information/class/info','id='.(int)$id)
			);
			
			$data['heading_title'] = $class['title'];
	
			$data['text_back'] = $this->language->get('text_back');
		
			
			if($class['image'])
			{
				$image = $this->model_tool_image->resize($class['image'], 300, 300);
			}
			else
			{
				$image = $this->model_tool_image->resize('placeholder.png', 300, 300);
			}
			
			
			$data['class'] = array(
				'id' => $class['id'],
				'title' => $class['title'],
				'info' => html_entity_decode($class['info'], ENT_QUOTES, 'UTF-8'),
				'image' => $image,
				'description' => html_entity_decode($class['description'], ENT_QUOTES, 'UTF-8')
			);
			
			$data['back'] = $this->url->link('information/class');
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
	
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/class_info.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/class_info.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('belleza/template/information/class_info.tpl', $data));
			}	
		}
		else
		{
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('information/class', $url . '&product_id=' . $product_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['belleza_left'] = $this->load->controller('common/belleza_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}			
		}
	}
}