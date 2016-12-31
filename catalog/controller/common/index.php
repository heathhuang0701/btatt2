<?php
class ControllerCommonIndex extends Controller {
	public function index() 
	{
		$this->load->model('design/banner');
		$this->load->model('tool/image');
		$this->load->model('extension/module');
		
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));
		$this->document->setRoute('index');

		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}
		
		// (固定) 首頁輪播 - WEB
		$data['indexes'] = array();		

		$results = $this->model_design_banner->getBanner(9);
		$results_app = $this->model_design_banner->getBanner(12);
		$setting_info = $this->model_extension_module->getModule(27);
		foreach($results as $keys => $result)
		{
			if(is_file(DIR_IMAGE.$result['image'])) 
			{
				if(isset($results_app[$keys]['image']) && is_file(DIR_IMAGE.$results_app[$keys]['image']))
				{
					$show = $this->model_tool_image->resize($results_app[$keys]['image'], 640, 760);
				}
				else
				{
					$show = $this->model_tool_image->resize('placeholder.png', 640, 760);
				}
				
				$data['indexes'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], 1600,750),
					'image_app' => $show
				);
			}
		}	

		$results = $this->model_design_banner->getBanner(12);
		$setting_info = $this->model_extension_module->getModule(27);
		foreach ($results as $result) {
			if(is_file(DIR_IMAGE . $result['image'])) {
				$data['apps'][] = array(
					'image' => $this->model_tool_image->resize($result['image'], 640,760)
				);
			}
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/index.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/index.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/index.tpl', $data));
		}
	}
}