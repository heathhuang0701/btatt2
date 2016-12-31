<?php
class ControllerInformationAbout extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('information/about');
		
		$this->document->setTitle($this->language->get('heading_title'));

		if(($this->request->server['REQUEST_METHOD'] == 'POST')) 
		{
			$subject = '美麗紋經銷商諮詢 - '.date('m-d');
			$message = '公司行號: '.$this->request->post['company']."\r\n";
			$message .= '聯絡窗口: '.$this->request->post['name']."\r\n";
			$message .= '電話: '.$this->request->post['phone']."\r\n";
			$message .= '內容: '.$this->request->post['content']."\r\n";
			
			$headers = "此信件為線上商城自動轉寄\r\n";

			mail($this->config->get('config_email'),$subject,$message,$headers);
			$this->response->redirect($this->url->link('information/about'));
			
			/*
			
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($this->config->get('config_email'));
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender('美麗紋自動轉寄');
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setText($message);
			$mail->send();
			*/
			
			
			
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/index')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/about')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_about'] = $this->language->get('text_about');
		$data['text_seek'] = $this->language->get('text_seek');
		$data['text_team'] = $this->language->get('text_team');
		$data['text_prod'] = $this->language->get('text_prod');
		$data['text_reset'] = $this->language->get('text_reset');
		
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_content'] = $this->language->get('entry_content');
		$data['entry_phone'] = $this->language->get('entry_phone');
		$data['entry_code'] = $this->language->get('entry_code');
		$data['button_check'] = $this->language->get('button_check');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['check'] = $this->url->link('information/about');
		$data['cancel'] = $this->url->link('common/index');
		
		$data['team_info'] = html_entity_decode($this->config->get('config_team_description'), ENT_QUOTES, 'UTF-8');
		$data['prod_info'] = html_entity_decode($this->config->get('config_product_description'), ENT_QUOTES, 'UTF-8');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/about.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/about.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('belleza/template/information/about.tpl', $data));
		}
	}
}