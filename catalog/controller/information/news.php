<?php
class ControllerInformationNews extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('information/news');
		
		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/index')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/news')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$this->load->model('information/news');
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
		$total = $this->model_information_news->getNewsCnt();
		$limit = 4; 
		$all_page = (ceil($total/$limit)); 
		$data['pgcnt'] = 5;
		if($page > $all_page) $page = $all_page;
		
		if($page>1) $data['pagination']['last'] = $this->url->link('information/news','page='.(int)($page-1));
		for($i=($page-2);$i<=($page+2);$i++)
		{
			if($i > 0 && $i <= $all_page) 
			{
				$data['pagination']['num'][$i] = $this->url->link('information/news','page='.(int)$i);
				$data['pgcnt']--;
			}
		}
		if($page < $all_page) $data['pagination']['next'] = $this->url->link('information/news','page='.(int)($page+1));
		
		$filter = array(
			'page' => $page,
			'limit' => $limit
		);
				
		$data['newses'] = array();
		$newses = $this->model_information_news->getNewses($filter);

		if($newses)
		{
			foreach($newses as $news)
			{
				if($news['image'])
				{
					$image = $this->model_tool_image->resize($news['image'], 400,300);
				}
				else
				{
					$image = $this->model_tool_image->resize('placeholder.png', 400,300);
				}
				
				$data['newses'][] = array(
					'id' => $news['id'],
					'title' => $news['title'],
					'content' => $news['content'],
					'time' => $news['time'],
					'image' => $image,
					'href' => $this->url->link('information/news/info','id='.(int)$news['id'],'SSL')
				);
			}
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/news_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/news_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('belleza/template/information/news_list.tpl', $data));
		}
	}
	

	public function info()
	{
		$this->load->language('information/news');
		
		$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
	
		$this->load->model('information/news');
		$this->load->model('tool/image');

		if(isset($this->request->get['id']) && $this->request->get['id'] != '')
		{
			$id = (int)$this->request->get['id'];	
		}
		else
		{
			$id = 0;	
		}
		$news = $this->model_information_news->getNews(array('id'=>$id));

		if($news)
		{
			$this->document->setTitle($news['title']);
	
			$data['breadcrumbs'] = array();
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/index')
			);
	
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('information/news')
			);
			
			$data['breadcrumbs'][] = array(
				'text' => $news['title'],
				'href' => $this->url->link('information/news/info','id='.(int)$id)
			);
			
			$data['heading_title'] = $news['title'];
	
			$data['text_back'] = $this->language->get('text_back');
		
			
			if($news['image'])
			{
				$image = $this->model_tool_image->resize($news['image'], 300, 300);
			}
			else
			{
				$image = $this->model_tool_image->resize('placeholder.png', 300, 300);
			}
			
			
			$data['news'] = array(
				'id' => $news['id'],
				'title' => $news['title'],
				'time' => $news['time'],
				'image' => $image,
				'content' => html_entity_decode($news['content'], ENT_QUOTES, 'UTF-8')
			);
			
			$data['back'] = $this->url->link('information/news');
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
	
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/news_info.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/news_info.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('belleza/template/information/news_info.tpl', $data));
			}	
		}
		else
		{
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('information/news', $url . '&id=' . $product_id)
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