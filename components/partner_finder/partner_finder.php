<?php
namespace Components;

class PartnerFinder extends Components {	
	public function prepare() {
		$this->loadModels(['Profiles', 'Geo']);		
	}
	
	public function load() {
		$action = $this->get->action;
		
		switch ($action) {
			case 'myprofile':
				$this->showCoef();
				break;
			case 'set':
				$this->post->user_id = $this->user_id;
				$this->Profiles->setProfile($this->post);
				$this->redirect($this->post->return_url);
				break;
			case 'getcities':
				$cities = $this->Geo->getCities($this->get->region_id);
				$cities_html = $this->getCitiesHtml($cities);
				echo $cities_html;
				break;
			case 'upload':
				$this->uploadImage();
				$this->redirect($this->post->return_url);
				break;
		}
	}
	
	private function showCoef() {
		// Use stored data if it is exist, otherwise just get profile
		if (isset($_COOKIE['profile_stored_data'])) {
			$profile = [];
			parse_str($_COOKIE['profile_stored_data'], $profile);
			setcookie('profile_stored_data', '', time()-1000000000000);
		}
		else {		
			$profile = $this->Profiles->getProfile($this->user_id);
		}
		
		$this->loadModels(['Users']);
		$this->Users->removeUnattachedImages($this->user_id);		
		$unattached_images = $this->Users->getUnattachedImages($this->user_id);
		
		$vars = [
			'dance_types' => $this->Profiles->getDanceTypes(),
			'dancers_classes' => $this->Profiles->getDancersClasses(),
			'countries' => $this->Geo->getCountries(),
			'regions' => $this->Geo->getRegions(),
			'unattached_image' => ($unattached_images ? $unattached_images[0] : false),
			'profile' => (object)$profile
		];
	
		// Set View
		$this->setView('components/partner_finder/views/coef.php', $vars);
		$this->renderViewContent();
		$this->content['top'] = $this->View->content;		
		
		// Set Bradcrumbs
		$this->loadHelpers(['Breadcrumbs']);
		$breadcrumbs = [
			'Поиск партнера' => '',
			'Моя анкета' => ''
		];
		$this->content['breadcrumbs'] = $this->Breadcrumbs->getHtml($breadcrumbs);
	}
	
	private function getCitiesHtml($cities) {
		$html = '<select name="city_id">';
		foreach ($cities as $city) {
			$html .= '<option value="' . $city->id . '">' . $city->title . '</option>';
		}
		$html .= '</select>';
		
		return $html;	
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
}
