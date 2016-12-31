<?php
class ControllerInformationTeacher extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('information/teacher');
		
		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/teacher')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_back'] = $this->language->get('text_back');

		$this->load->model('information/teacher');
		$this->load->model('tool/image');

		$teachers = $this->model_information_teacher->getTeachers();
		$data['teachers'] = array();
		if($teachers)
		{
			foreach($teachers as $teacher)
			{
				if($teacher['image_list'])
				{
					$image = $this->model_tool_image->resize($teacher['image_list'], 300, 420);
				}
				else
				{
					$image = $this->model_tool_image->resize('placeholder.png', 300, 420);
				}

				$data['teachers'][] = array(
					'id' => $teacher['id'],
					'name' => $teacher['name'],
					'thumb' => $image,
					'href' => $this->url->link('information/teacher/info','id='.(int)$teacher['id'],'SSL')
				);
			}
		}
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/teacher_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/teacher_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('belleza/template/information/teacher_list.tpl', $data));
		}
	}
	

	public function info() {
		$this->load->language('information/teacher');
		
		$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
	
		$this->load->model('information/teacher');
		$this->load->model('tool/image');

		if(isset($this->request->get['id']) && $this->request->get['id'] != '')
		{
			$id = (int)$this->request->get['id'];	
		}
		else
		{
			$id = 0;	
		}
		$teacher = $this->model_information_teacher->getTeacher(array('id'=>$id));

		if($teacher)
		{
			$this->document->setTitle($teacher['name']);
	
			$data['breadcrumbs'] = array();
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/index')
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('information/teacher')
			);
			
			$data['breadcrumbs'][] = array(
				'text' => $teacher['name'],
				'href' => $this->url->link('information/teacher/info','id='.(int)$id)
			);
			
			$data['heading_title'] = $teacher['name'];
	
			$data['text_back'] = $this->language->get('text_back');
		
			
			if($teacher['image_circle'])
			{
				$image = $this->model_tool_image->resize($teacher['image_circle'], 300, 300);
			}
			else
			{
				$image = $this->model_tool_image->resize('placeholder.png', 300, 300);
			}
			
			$data['thumb'] = array();
			if(count($teacher['thumb']) > 0)
			{
				foreach($teacher['thumb'] as $thumb)
				{
					if($thumb['thumb'])
					{
						$data['thumb'][] = array(
							'popup' => $this->model_tool_image->resize($thumb['thumb'],$this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
							'thumb' => $this->model_tool_image->resize($thumb['thumb'], 400,300),
							'info' => $thumb['info']
						);
						
					}
					else
					{
						$data['thumb'][] = array(
							'popup' => '',
							'thumb' => $this->model_tool_image->resize('placeholder.png', 400,300),
							'info' => ''
						);
					}
				}
			}
			
			
			$data['teacher'] = array(
				'id' => $teacher['id'],
				'name' => $teacher['name'],
				'info' => html_entity_decode($teacher['info'], ENT_QUOTES, 'UTF-8'),
				'image' => $image,
			);
			
			
			$data['back'] = $this->url->link('information/teacher');
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
	
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/teacher_info.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/teacher_info.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('belleza/template/information/teacher_info.tpl', $data));
			}	
		}
		else
		{
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
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