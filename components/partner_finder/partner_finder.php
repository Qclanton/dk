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
			case 'profile':
				$this->showProfile($this->get->id);
				break;
			case 'rendersearchform':
				$seacrh = ($this->post->search ? array_merge($this->Profiles->default_search, $this->post->search) : $this->Profiles->default_search);
				$this->renderSearchPartnerForm($search);
				break;
			case 'search':
				$seacrh = (isset($this->post->search) ? array_merge($this->Profiles->default_search, $this->post->search) : $this->Profiles->default_search);
				$this->showSearchResults($seacrh);
				break;
			case 'getcities':
				$cities = $this->Geo->getCities($this->get->region_id);
				$listname = (isset($this->get->listname) ? $this->get->listname : 'city_id');
				$cities_html = $this->getCitiesHtml($cities, $listname);
				echo $cities_html;
				break;
			case 'getregions':
				$regions = $this->Geo->getRegions($this->get->country_id);
				$listname = (isset($this->get->listname) ? $this->get->listname : 'region_id');
				$regions_html = $this->getRegionsHtml($regions, $listname);
				echo $regions_html;
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
			$profile = $this->Profiles->getProfile(null, $this->user_id);
		}
		
		// Attach image
		$this->loadModels(['Users']);
		$this->Users->removeExpiredUnattachedImages($this->user_id);		
		$unattached_images = $this->Users->getUnattachedImages($this->user_id);

	
		$vars = [
			'dance_types' => $this->Profiles->getDanceTypes(),
			'dancers_classes' => $this->Profiles->getDancersClasses(),
			'countries' => $this->Geo->getCountries(),
			'regions' => $this->Geo->getRegions($profile['country_id']),
			'cities' => $this->Geo->getCities($profile['region_id']),
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
			'Поиск партнера' => $this->site_url . 'index.php/?component=partner_finder&action=search',
			'Моя анкета' => ''
		];
		$this->content['breadcrumbs'] = $this->Breadcrumbs->getHtml($breadcrumbs);
	}
	
	private function showProfile($user_id) {
		$profile = $this->Profiles->getProfile(null, $user_id);
		
		// Set View
		$this->setView('components/partner_finder/views/profile.php', ['profile'=>(object)$profile]);
		$this->renderViewContent();
		$this->content['top'] = $this->View->content;		
		
		// Set Bradcrumbs
		$this->loadHelpers(['Breadcrumbs']);
		$breadcrumbs = [
			'Поиск партнера' => $this->site_url . 'index.php/?component=partner_finder&action=search',
			'Анкета ' . $profile['id'] => ''
		];
		$this->content['breadcrumbs'] = $this->Breadcrumbs->getHtml($breadcrumbs);
	}
	
	private function showSearchResults($search) {
		$results = $this->Profiles->search($search);

		// Set View
		$this->setView('components/partner_finder/views/searchresults.php', ['results'=>$results, 'order'=>(object)$search['confines']['order'][0]]);
		$this->renderViewContent();
		$this->content['left'] = $this->View->content;
					
		$this->renderSearchForm($search);
		$this->content['right'] = $this->View->content;
		
		// Set Bradcrumbs
		$this->loadHelpers(['Breadcrumbs']);
		$breadcrumbs = [
			'Поиск партнера' => $this->site_url . 'index.php/?component=partner_finder&action=search',
			'Результаты поиска' => ''
		];
		$this->content['breadcrumbs'] = $this->Breadcrumbs->getHtml($breadcrumbs);
	}
	
	
	private function renderSearchForm($search) {
		$vars = [
			'dance_types' => $this->Profiles->getDanceTypes(),
			'dancers_classes' => $this->Profiles->getDancersClasses(),
			'countries' => $this->Geo->getCountries(),
			'search' => (object)$search
		];
		
		if ($search['region_id'] && $search['country_id']) {
			$vars['regions'] = $this->Geo->getRegions($search['country_id']);
		}
		if ($search['city_id'] && $search['region_id'] ) {
			$vars['cities'] = $this->Geo->getCities($search['region_id']);
		}
					
		$this->setView('components/partner_finder/views/searchform.php', $vars);
		$this->renderViewContent();
	}
	
	private function getCitiesHtml($cities, $listname) {
		$html = '<select name="' . $listname . '">';
		foreach ($cities as $city) {
			$html .= '<option value="' . $city->id . '">' . $city->title . '</option>';
		}
		$html .= '</select>';
		
		return $html;	
	}
	private function getRegionsHtml($regions, $listname) {
		$html = '<select name="' . $listname . '">';
		foreach ($regions as $region) {
			$html .= '<option value="' . $region->id . '">' . $region->title . '</option>';
		}
		$html .= '</select>';
		
		return $html;	
	}
}
