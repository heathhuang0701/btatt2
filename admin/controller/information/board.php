<?php
class ControllerInformationBoard extends Controller 
{
	private $error = array();

	public function index() {
		$this->load->language('information/board');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('information/board');

		$this->getList();
	}

	public function add() {
		$this->load->language('information/board');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('information/board');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_information_board->addBoard($this->request->post);

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

			$this->response->redirect($this->url->link('information/board', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
	
	public function show()
	{
		$this->load->language('information/board');
		$this->load->model('information/board');
		$json = array();
	
		if(isset($this->request->get['id']))
		{
			$id = (int)$this->request->get['id'];
		} 
		else
		{
			$id	= 0;
		}
		
		$board_info = $this->model_information_board->getBoard($id);
		if($board_info)
		{
			$this->model_information_board->showBoard($id);
			$this->session->data['success'] = $this->language->get('text_success');
		}
		
		$this->response->redirect($this->url->link('information/board', 'token='.$this->session->data['token'],''));

	}
	
	public function reply()
	{
		$this->load->language('information/board');
		$this->load->model('information/board');
		$json = array();
	
		if(isset($this->request->post['id']))
		{
			$id = (int)$this->request->post['id'];
		} 
		else
		{
			$id	= 0;
		}
	
		$board_info = $this->model_information_board->getBoard($id);
		
		if($board_info)
		{
			if(isset($this->request->post['reply']))
			{
				$content = $this->request->post['reply'];
			}
			else
			{
				$content = '';
			}
			
			if(isset($this->request->post['page']))
			{
				$page = (int)$this->request->post['page'];
			}
			else
			{
				$page = 1;
			}
			$input = array(
				'reply' => $content,
				'reply_time' => date('Y-m-d H:i:s')
			);
			
			$this->model_information_board->replyBoard($id,$input);
		}
		
		$json['redirect'] = str_replace('&amp;', '&', $this->url->link('information/board', 'page=' . (int)$page.'&token='.$this->session->data['token'].''));
	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function edit() {
		$this->load->language('information/board');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('information/board');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_information_board->editBoard($this->request->get['id'], $this->request->post);

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

			$this->response->redirect($this->url->link('information/board', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('information/board');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('information/board');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_information_board->deleteBoard($id);
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

			$this->response->redirect($this->url->link('information/board', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href' => $this->url->link('information/board', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('information/board/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('information/board/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$data['boards'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'page' => $page,
			'limit' => $this->config->get('config_limit_admin')
		);

		$board_total = $this->model_information_board->getBoardCnt();

		$results = $this->model_information_board->getBoards($filter_data);
		
		$data['reply_url'] = str_replace('&amp;', '&', $this->url->link('information/board/reply','token='.$this->session->data['token'],'SSL'));
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['text_hide'] = $this->language->get('text_hide');
		$data['text_show'] = $this->language->get('text_show');
		$data['text_not_reply'] = $this->language->get('text_not_reply');
		$data['text_replied'] = $this->language->get('text_replied');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_title'] = $this->language->get('column_title');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_content'] = $this->language->get('column_content');
		$data['column_time'] = $this->language->get('column_time');
		$data['column_email'] = $this->language->get('column_email');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_show'] = $this->language->get('button_show');
		$data['button_hide'] = $this->language->get('button_hide');
		
		
		foreach ($results as $result) {
			$data['boards'][] = array(
				'id'          => $result['id'],
				'name'        => $result['name'],
				'title'       => $result['title'],
				'email'       => $result['email'],
				'time'        => $result['time'],
				'reply'       => $result['reply'],
				'show'        => $result['show'],
				'status'      => ($result['show'] == 1)?$data['text_show']:$data['text_hide'],
				'change'      => $this->url->link('information/board/show', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, 'SSL'),
				'content'     => nl2br($result['content']),
				'edit'        => $this->url->link('information/board/edit', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, 'SSL'),
				'delete'      => $this->url->link('information/board/delete', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, 'SSL')
			);
		}
		
		
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

		$data['sort_name'] = $this->url->link('information/board', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('information/board', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $board_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('information/board', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();
		$data['page'] = $page;

		$data['results'] = sprintf($this->language->get('text_pagination'), ($board_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($board_total - $this->config->get('config_limit_admin'))) ? $board_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $board_total, ceil($board_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('information/board_list.tpl', $data));
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
			'href' => $this->url->link('information/board', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['id'])) {
			$data['action'] = $this->url->link('information/board/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('information/board/edit', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('information/board', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$board_info = $this->model_information_board->getBoard(array('id' => $this->request->get['id']));
		}

		$data['token'] = $this->session->data['token'];


		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($board_info)) {
			$data['name'] = $board_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['info'])) {
			$data['info'] = $this->request->post['name'];
		} elseif (!empty($board_info)) {
			$data['info'] = $board_info['info'];
		} else {
			$data['info'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($this->request->post['image_list'])) {
			$data['image_list'] = $this->request->post['image_list'];
		} elseif (!empty($board_info)) {
			$data['image_list'] = $board_info['image_list'];
		} else {
			$data['image_list'] = '';
		}
		
		if (isset($this->request->post['image_list']) && is_file(DIR_IMAGE . $this->request->post['image_list'])) {
			$data['thumb_list'] = $this->model_tool_image->resize($this->request->post['image_list'], 100, 100);
		} elseif (!empty($board_info) && is_file(DIR_IMAGE . $board_info['image_list'])) {
			$data['thumb_list'] = $this->model_tool_image->resize($board_info['image_list'], 100, 100);
		} else {
			$data['thumb_list'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		if (isset($this->request->post['image_circle'])) {
			$data['image_circle'] = $this->request->post['image_circle'];
		} elseif (!empty($board_info)) {
			$data['image_circle'] = $board_info['image_circle'];
		} else {
			$data['image_circle'] = '';
		}
		
		if (isset($this->request->post['image_circle']) && is_file(DIR_IMAGE . $this->request->post['image_circle'])) {
			$data['thumb_circle'] = $this->model_tool_image->resize($this->request->post['image_circle'], 100, 100);
		} elseif (!empty($board_info) && is_file(DIR_IMAGE . $board_info['image_circle'])) {
			$data['thumb_circle'] = $this->model_tool_image->resize($board_info['image_circle'], 100, 100);
		} else {
			$data['thumb_circle'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		if (isset($this->request->post['sort'])) {
			$data['sort'] = $this->request->post['sort'];
		} elseif (!empty($board_info)) {
			$data['sort'] = $board_info['sort'];
		} else {
			$data['sort'] = '';
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['thumb'])) {
			$data['thumb'] = $this->request->post['thumb'];
		} elseif (!empty($board_info)) {
			$data['thumb'] = $board_info['thumb'];
		} else {
			$data['thumb'] = array();
		}

		if(isset($this->request->post['thumb']) && count($this->request->post['thumb']) > 0)
		{
			foreach($this->request->post['thumb'] as $thumb)
			{
				if(isset($thumb) && is_file(DIR_IMAGE . $thumb))
				{
					$data['thumb_thumb'][] = $this->model_tool_image->resize($thumb, 100, 100);
				}
				else
				{
					$data['thumb_thumb'][] = $this->model_tool_image->resize('no_image.png', 100, 100);
				}
			}
		}
		elseif(!empty($board_info))
		{
			foreach($board_info['thumb'] as $thumb)
			{
				if(isset($thumb) && is_file(DIR_IMAGE . $thumb))
				{
					$data['thumb_thumb'][] = $this->model_tool_image->resize($thumb, 100, 100);
				}
				else
				{
					$data['thumb_thumb'][] = $this->model_tool_image->resize('no_image.png', 100, 100);
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

		$this->response->setOutput($this->load->view('information/board_form.tpl', $data));
	}

	protected function validateForm()
	{
		if(!$this->user->hasPermission('modify', 'information/board'))
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
		if (!$this->user->hasPermission('modify', 'information/board')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}