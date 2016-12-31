<?php
class ControllerShippingArea extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('shipping/area');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/area');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_area->editArea($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_shipping'),
			'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('shipping/area', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('shipping/area', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		$arr = $this->model_setting_area->getArea();

		if(count($arr) > 0)
		{
			foreach($arr as $geo)
			{
				if($geo['id']!='etc')
				{
					$named = 'geo'.$geo['id'];
					if (isset($this->request->post[$named])) {
						$data[$named] = $this->request->post[$named];
					} else {
						$data[$named] = $geo['fee'];
					}
				}
				else
				{
					if (isset($this->request->post['etc'])) {
						$data['etc'] = $this->request->post['fee'];
					} else {
						$data['etc'] = $geo['fee'];
					}
				}
			}
		}
		

		
		$data['info'] = $arr;
		
		if (isset($this->request->post['area_status'])) 
		{
			$data['area_status'] = $this->request->post['area_status'];
		} else {
			$data['area_status'] = $this->config->get('area_status');
		}

		if (isset($this->request->post['area_sort_order'])) {
			$data['area_sort_order'] = $this->request->post['area_sort_order'];
		} else {
			$data['area_sort_order'] = $this->config->get('area_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/area.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/area')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}