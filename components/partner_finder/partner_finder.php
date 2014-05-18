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
		}
	}
	
	private function showCoef() {
		// Get the Profile
		$profile = $this->Profiles->getProfile($this->user_id);
		
		$vars = [
			'dance_types' => $this->Profiles->getDanceTypes(),
			'dancers_classes' => $this->Profiles->getDancersClasses(),
			'countries' => $this->Geo->getCountries(),
			'regions' => $this->Geo->getRegions(),
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
}
