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
				$this->setBulletin($this->post);
				$this->redirect($this->post->return_url);
				break;
			case 'showmylist':
				$this->showList($this->user_id);
				break;
			case 'showlist':
				$this->showList($this->user_id);
				break;
			case 'upload':
				$this->uploadImage();
				$this->redirect($this->post->return_url);
				break;
		}
	}
	
	public function showCoef($bulletin_id=null, $files=null) {
		// Use stored data if it is exist, otherwise just get bulletin
		if (
			(empty($bulletin_id) && isset($_COOKIE['bulletin_stored_data--new'])) ||
			(!empty($bulletin_id) && isset($_COOKIE['bulletin_stored_data--' . $bulletin_id]))			
		) {
			$bulletin = [];
			$id = (empty($bulletin_id) ? 'new' : $bulletin_id);
			parse_str($_COOKIE['bulletin_stored_data--' . $id], $bulletin);
			setcookie('bulletin_stored_data--' . $id, '', time()-1000000000000);
		}
		else {		
			$bulletin = $this->Bulletins->getBulletin($bulletin_id);
		}

		// Get attached images
		$bulletin['images'] = $this->Bulletins->getImages($bulletin_id);
		
		// Get unattached images
		$this->loadModels(['Users']);
		// $this->Users->removeExpiredUnattachedImages($this->user_id);	
		$unattached_images = $this ->Users->getUnattachedImages($this->user_id);
		$this->Users->removeUnattachedImages($this->user_id);
		
		// Set vars
		$vars = [
			'bulletin' => (object)$bulletin,
			'unattached_images' => $unattached_images
		];		
	
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
	
	public $pagination = [
		'page' => 1,
		'rows' => 0,
		'total_pages' => 1,
		'rows_per_page' => 2
	];
	
	public function showList($user_id=null) {
		// Get Bulletins
		$bulletins = $this->Bulletins->getBulletins($user_id);
		$pagination = $this->pagination;
		if ($bulletins) { 
			$pagination['rows'] = $this->Bulletins->getFoundRows();
			$pagination['total_pages'] = ceil($pagination['rows'] / $pagination['rows_per_page']);
		}

		$vars = [
			'bulletins' => $bulletins,
			'pagination' => (object)$pagination
		];
		
		// Set View
		$this->setView('components/bulletin_board/views/list.php', $vars);
		$this->renderViewContent();
		$this->content['top'] = $this->View->content;		
		
		// Set Bradcrumbs
		$this->loadHelpers(['Breadcrumbs']);
		$breadcrumbs = [
			'Объявления' => '',
			'Мои' => ''
		];
		$this->content['breadcrumbs'] = $this->Breadcrumbs->getHtml($breadcrumbs);
	}	

	public function setBulletin($bulletin) {
		$bulletin->user_id = $this->user_id; 
		$bulletin_id = $this->Bulletins->setBulletin($bulletin);
		
		if (isset($bulletin->images)) {
			$this->Bulletins->attachImages($bulletin_id, $bulletin->images);
			$this->Bulletins->setDefaultImage($bulletin_id, $bulletin->images[0]);
			$this->loadModels(['Users']);
			$this->Users->removeUnattachedImages($this->user_id);
		}
	}
}
