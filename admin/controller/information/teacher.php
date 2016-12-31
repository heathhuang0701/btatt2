<?php
class ControllerInformationTeacher extends Controller 
{
	private $error = array();

	public function index() {
		$this->load->language('information/teacher');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('information/teacher');

		$this->getList();
	}

	public function add() {
		$this->load->language('information/teacher');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('information/teacher');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_information_teacher->addTeacher($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('information/teacher', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('information/teacher');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('information/teacher');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_information_teacher->editTeacher($this->request->get['id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('information/teacher', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('information/teacher');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('information/teacher');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_information_teacher->deleteTeacher($id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('information/teacher', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/teacher', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('information/teacher/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('information/teacher/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		
		
		$data['teachers'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'page' => $page,
			'limit' => $this->config->get('config_limit_admin')
		);

		$teacher_total = $this->model_information_teacher->getTeacherCnt();

		$results = $this->model_information_teacher->getTeachers($filter_data);

		foreach ($results as $result) {
			$data['teachers'][] = array(
				'id'          => $result['id'],
				'name'        => $result['name'],
				'sort'        => $result['sort'],
				'edit'        => $this->url->link('information/teacher/edit', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, 'SSL'),
				'delete'      => $this->url->link('information/teacher/delete', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('information/teacher', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('information/teacher', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $teacher_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('information/teacher', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($teacher_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($teacher_total - $this->config->get('config_limit_admin'))) ? $teacher_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $teacher_total, ceil($teacher_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('information/teacher_list.tpl', $data));
	}

	protected function getForm() 
	{
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['category_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_info'] = $this->language->get('entry_info');
		$data['entry_image_list'] = $this->language->get('entry_image_list');
		$data['entry_image_circle'] = $this->language->get('entry_image_circle');
		$data['entry_sort'] = $this->language->get('entry_sort');
		$data['entry_thumb'] = $this->language->get('entry_thumb');
		$data['entry_thumb_info'] = $this->language->get('entry_thumb_info');
		
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/teacher', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['id'])) {
			$data['action'] = $this->url->link('information/teacher/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('information/teacher/edit', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('information/teacher', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$teacher_info = $this->model_information_teacher->getTeacher(array('id' => $this->request->get['id']));
		}

		$data['token'] = $this->session->data['token'];


		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($teacher_info)) {
			$data['name'] = $teacher_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['info'])) {
			$data['info'] = $this->request->post['info'];
		} elseif (!empty($teacher_info)) {
			$data['info'] = $teacher_info['info'];
		} else {
			$data['info'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($this->request->post['image_list'])) {
			$data['image_list'] = $this->request->post['image_list'];
		} elseif (!empty($teacher_info)) {
			$data['image_list'] = $teacher_info['image_list'];
		} else {
			$data['image_list'] = '';
		}
		
		if (isset($this->request->post['image_list']) && is_file(DIR_IMAGE . $this->request->post['image_list'])) {
			$data['thumb_list'] = $this->model_tool_image->resize($this->request->post['image_list'], 100, 100);
		} elseif (!empty($teacher_info) && is_file(DIR_IMAGE . $teacher_info['image_list'])) {
			$data['thumb_list'] = $this->model_tool_image->resize($teacher_info['image_list'], 100, 100);
		} else {
			$data['thumb_list'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		if (isset($this->request->post['image_circle'])) {
			$data['image_circle'] = $this->request->post['image_circle'];
		} elseif (!empty($teacher_info)) {
			$data['image_circle'] = $teacher_info['image_circle'];
		} else {
			$data['image_circle'] = '';
		}
		
		if (isset($this->request->post['image_circle']) && is_file(DIR_IMAGE . $this->request->post['image_circle'])) {
			$data['thumb_circle'] = $this->model_tool_image->resize($this->request->post['image_circle'], 100, 100);
		} elseif (!empty($teacher_info) && is_file(DIR_IMAGE . $teacher_info['image_circle'])) {
			$data['thumb_circle'] = $this->model_tool_image->resize($teacher_info['image_circle'], 100, 100);
		} else {
			$data['thumb_circle'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		if (isset($this->request->post['sort'])) {
			$data['sort'] = $this->request->post['sort'];
		} elseif (!empty($teacher_info)) {
			$data['sort'] = $teacher_info['sort'];
		} else {
			$data['sort'] = '';
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['thumb'])) {
			$data['thumb'] = $this->request->post['thumb'];
		} elseif (!empty($teacher_info)) {
			$data['thumb'] = $teacher_info['thumb'];
		} else {
			$data['thumb'] = array();
		}

		if(isset($this->request->post['thumb']) && count($this->request->post['thumb']) > 0)
		{
			foreach($this->request->post['thumb'] as $thumb)
			{
				if(isset($thumb['thumb']) && is_file(DIR_IMAGE . $thumb['thumb']))
				{
					$data['thumb_thumb'][] = array(
						'thumb' => $this->model_tool_image->resize($thumb['thumb'], 100, 100),
						'info' => $thumb['info']
					);	
				}
				else
				{
					$data['thumb_thumb'][] = array(
						'thumb' => $this->model_tool_image->resize('no_image.png', 100, 100),
						'info' => $thumb['info']
					);	
				}
			}
		}
		elseif(!empty($teacher_info))
		{
			foreach($teacher_info['thumb'] as $thumb)
			{
				if(isset($thumb['thumb']) && is_file(DIR_IMAGE . $thumb['thumb']))
				{
					$data['thumb_thumb'][] = array(
						'thumb' => $this->model_tool_image->resize($thumb['thumb'], 100, 100),
						'info' => $thumb['info']
					);
				}
				else
				{
					$data['thumb_thumb'][] = array(
						'thumb' => $this->model_tool_image->resize('no_image.png', 100, 100),
						'info' => $thumb['info']
					);	
				}
			}
		}
		else
		{
			$data['thumb_thumb'] = array();
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('information/teacher_form.tpl', $data));
	}

	protected function validateForm()
	{
		if(!$this->user->hasPermission('modify', 'information/teacher'))
		{
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if((utf8_strlen($this->request->post['name']) <= 0))
		{
			$this->error['warning'] = $this->language->get('error_name');
		}

		return !$this->error;
	}

	protected function validateDelete() 
	{
		if (!$this->user->hasPermission('modify', 'information/teacher')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}