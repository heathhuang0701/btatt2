<?php
class ControllerInformationNews extends Controller 
{
	private $error = array();

	public function index() {
		$this->load->language('information/news');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('information/news');

		$this->getList();
	}

	public function add() {
		$this->load->language('information/news');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('information/news');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_information_news->addNews($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('information/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('information/news');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('information/news');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_information_news->editNews($this->request->get['id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('information/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('information/news');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('information/news');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_information_news->deleteNews($id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('information/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

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
			'href' => $this->url->link('information/news', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('information/news/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('information/news/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['newses'] = array();

		$filter_data = array(
			'page' => $page,
			'limit' => $this->config->get('config_limit_admin')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_title'] = $this->language->get('column_title');
		$data['column_time'] = $this->language->get('column_time');
		$data['column_show'] = $this->language->get('column_show');
		$data['column_action'] = $this->language->get('column_action');
		
		$data['option_show'] = $this->language->get('option_show');
		$data['option_hide'] = $this->language->get('option_hide');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		
		$news_total = $this->model_information_news->getNewsCnt();

		$results = $this->model_information_news->getNewses($filter_data);

		foreach ($results as $result) {
			$data['newses'][] = array(
				'id'          => $result['id'],
				'title'       => $result['title'],
				'time'        => $result['time'],
				'show'        => ($result['show'] == 1)?$data['option_show']:$data['option_hide'],
				'edit'        => $this->url->link('information/news/edit', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, 'SSL'),
				'delete'      => $this->url->link('information/news/delete', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, 'SSL')
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
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url = '';

		$pagination = new Pagination();
		$pagination->total = $news_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('information/news', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($news_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($news_total - $this->config->get('config_limit_admin'))) ? $news_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $news_total, ceil($news_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('information/news_list.tpl', $data));
	}

	protected function getForm() 
	{
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');

		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_content'] = $this->language->get('entry_content');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_time'] = $this->language->get('entry_time');
		$data['entry_show'] = $this->language->get('entry_show');

		$data['option_show'] = $this->language->get('option_show');
		$data['option_hide'] = $this->language->get('option_hide');
		
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
			'href' => $this->url->link('information/news', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['id'])) {
			$data['action'] = $this->url->link('information/news/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('information/news/edit', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('information/news', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$news_info = $this->model_information_news->getNews(array('id' => $this->request->get['id']));
		}

		$data['token'] = $this->session->data['token'];


		if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		} elseif (!empty($news_info)) {
			$data['title'] = $news_info['title'];
		} else {
			$data['title'] = '';
		}

		if (isset($this->request->post['content'])) {
			$data['content'] = $this->request->post['content'];
		} elseif (!empty($news_info)) {
			$data['content'] = $news_info['content'];
		} else {
			$data['content'] = '';
		}
		
		if (isset($this->request->post['time'])) {
			$data['time'] = $this->request->post['time'];
		} elseif (!empty($news_info)) {
			$data['time'] = $news_info['time'];
		} else {
			$data['time'] = '';
		}
		
		if (isset($this->request->post['show'])) {
			$data['show'] = $this->request->post['show'];
		} elseif (!empty($news_info)) {
			$data['show'] = $news_info['show'];
		} else {
			$data['show'] = 0;
		}
		
		$this->load->model('tool/image');

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($news_info)) {
			$data['image'] = $news_info['image'];
		} else {
			$data['image'] = '';
		}
		
		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($news_info) && is_file(DIR_IMAGE . $news_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($news_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('information/news_form.tpl', $data));
	}

	protected function validateForm()
	{
		if(!$this->user->hasPermission('modify', 'information/news'))
		{
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if((utf8_strlen($this->request->post['title']) <= 0))
		{
			$this->error['warning'] = $this->language->get('error_title');
		}

		return !$this->error;
	}

	protected function validateDelete() 
	{
		if (!$this->user->hasPermission('modify', 'information/news')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}