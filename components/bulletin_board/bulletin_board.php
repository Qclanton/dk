<?php
namespace Components;

class BulletinBoard extends Components {	
	public function prepare() {
		$this->loadModels(['Bulletins']);
		
	}
	
	public function load() {
		$action = $this->get->action;
		
		switch ($action) {
			case 'create':
				// COEF - Create Or Edit Form
				$this->showCoef();
				break;
			case 'edit':
				$this->showCoef($this->get->id);
				break;
			case 'set':
				$bulletin = $this->post;
				$bulletin->user_id = $this->user_id; 
				$this->Bulletins->setBulletin($bulletin);
				$this->redirect($this->post->return_url);
				break;
		}
	}
	
	public function showCoef($bulletin_id=null) {
		// Get Bulletin for edit or default data for create bulletin
		$bulletin = $this->Bulletins->getBulletin($bulletin_id);
		$vars = ['bulletin' => (object)$bulletin];
		
		// Set View
		$this->setView('components/bulletin_board/views/coef.php', $vars);
		$this->renderViewContent();
		$this->content['top'] = $this->View->content;
		
		// Set Bradcrumbs
		$this->loadHelpers(['Breadcrumbs']);
		$breadcrumbs = [
			'Объявления' => '',
			(($bulletin_id) ? 'Редактирование: ' . $bulletin['title'] : 'Создание') => ''
		];
		$this->content['breadcrumbs'] = $this->Breadcrumbs->getHtml($breadcrumbs);
	}
}
