<?php
class ControllerInformationBoard extends Controller 
{
	private $error = array();

	public function index() 
	{
		$this->load->language('information/board');
		$this->load->model('information/board');
		
		$this->document->setTitle($this->language->get('heading_title'));


		if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) 
		{
			$this->model_information_board->addBoard($this->request->post);
			echo '<script>alert("我們將盡速回覆您的留言！");</script>';
			$this->response->redirect($this->url->link('information/board'));
		}

		if(isset($this->error['warning']))
		{
			$data['warning'] = $this->error['warning'][0];
		}
		
		if(isset($this->request->post['name']))
		{
			$data['name'] = $this->request->post['name']; 	
		}
		else
		{
			$data['name'] = '';
		}
		
		if(isset($this->request->post['title']))
		{
			$data['title'] = $this->request->post['title']; 	
		}
		else
		{
			$data['title'] = '';
		}
		
		if(isset($this->request->post['email']))
		{
			$data['email'] = $this->request->post['email']; 	
		}
		else
		{
			$data['email'] = '';
		}
		
		if(isset($this->request->post['content']))
		{
			$data['content'] = $this->request->post['content']; 	
		}
		else
		{
			$data['content'] = '';
		}
		
		
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/index')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/board')
		);

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_board']       = $this->language->get('text_board');
		$data['text_submit']      = $this->language->get('text_submit');
		$data['text_reply']      = $this->language->get('text_reply');
		$data['text_reset']      = $this->language->get('text_reset');


		
		$data['entry_email']    = $this->language->get('entry_email');;
		$data['entry_name']    = $this->language->get('entry_name');
		$data['entry_content']    = $this->language->get('entry_content');
		$data['entry_title']    = $this->language->get('entry_title');
		$data['entry_code']    = $this->language->get('entry_code');

		$data['check'] = $this->url->link('information/about');
		$data['cancel'] = $this->url->link('common/index');

		if(isset($this->request->get['page']) && (int)$this->request->get['page'] > 1)
		{
			$page = (int)$this->request->get['page'];
		}
		else
		{
			$page = 1;
		}
		
		// 計算總比數 顯示 前後二 上下一頁
		$total = $this->model_information_board->getBoardCnt();
		$limit = 8; 
		$all_page = (ceil($total/$limit)); 
		$data['pgcnt'] = 5;
		if($page > $all_page) $page = $all_page;
		
		if($page>1) $data['pagination']['last'] = $this->url->link('information/board','page='.(int)($page-1));
		for($i=($page-2);$i<=($page+2);$i++)
		{
			if($i > 0 && $i <= $all_page) 
			{
				$data['pagination']['num'][$i] = $this->url->link('information/board','page='.(int)$i);
				$data['pgcnt']--;
			}
		}
		if($page < $all_page) $data['pagination']['next'] = $this->url->link('information/board','page='.(int)($page+1));
		
		$filter = array(
			'page' => $page,
			'limit' => $limit
		);

		$data['boards'] = array();
		$boards = $this->model_information_board->getBoards($filter);
		if($boards)
		{
			foreach($boards as $board)
			{
				$board['content'] = nl2br($board['content']);
				$board['reply'] = nl2br($board['reply']);
				
				$data['boards'][] = $board;
			}
		}
		

		$data['submit'] = $this->url->link('information/board');
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/board.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/board.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('belleza/template/information/board.tpl', $data));
		}
	}
	
	
	protected function validate()
	{
		if (!isset($this->request->post['email']) || $this->request->post['email'] == '') {
			$this->error['warning'] = $this->language->get('error_error1');
		}

		if (!isset($this->request->post['name']) || $this->request->post['name'] == '') {
			$this->error['warning'] = $this->language->get('error_error2');
		}

		if (!isset($this->request->post['title']) || $this->request->post['title'] == '') {
			$this->error['warning'] = $this->language->get('error_error3');
		}
		
		if (!isset($this->request->post['content']) || $this->request->post['content'] == '') {
			$this->error['warning'] = $this->language->get('error_error4');
		}	
			
		if ($this->request->post['code'] == '' || $this->request->post['code'] != $_SESSION['check_word']) {
			$this->error['warning'] = $this->language->get('error_code');
		}
		
		return !$this->error;
	}
}