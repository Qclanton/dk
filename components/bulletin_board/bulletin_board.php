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
			// setcookie('bulletin_stored_data--' . $id, '', time()-1000000000000);
		}
		else {		
			$bulletin = $this->Bulletins->getBulletin($bulletin_id);
		}

		// Set attached images
		$bulletin['images'] = $this->Bulletins->getImages($bulletin_id);
		
		// Set unattached iimages
		$this->loadModels(['Users']);		
		$unattached_images = $this ->Users->getUnattachedImages($this->user_id);
		
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
	
	public function showList($user_id=null) {
		// Get Bulletins
		$bulletins = $this->Bulletins->getBulletins($this->user_id);
		$vars = ['bulletins' => $bulletins];
		
		// Set View
		$this->setView('components/bulletin_board/views/mylist.php', $vars);
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
	
	public function uploadImage() {
		$this->loadHelpers(['Uploader']);
		$this->Uploader->allowed_extensions = ['png', 'jpg', 'gif'];		
		if(!file_exists('uploads/user_' . $this->user_id)) { mkdir('uploads/user_' . $this->user_id); }
		$this->Uploader->path = 'uploads/user_' . $this->user_id;
		
		$result = $this->Uploader->upload();
		
		if ($result) {
			$this->loadModels(['Users']);
			$this->Users->saveUnattachedImages($this->user_id, $this->Uploader->uploaded_files);
		}
		
		return $result;  
	}
	
	public function setBulletin($bulletin) {
		$bulletin->user_id = $this->user_id; 
		$bulletin_id = $this->Bulletins->setBulletin($bulletin);
		
		if ($bulletin->images) {
			$this->Bulletins->attachImages($bulletin_id, $bulletin->images);
			$this->loadModels(['Users']);
			$this->Users->removeUnattachedImages($this->user_id);
		}
	}
}
