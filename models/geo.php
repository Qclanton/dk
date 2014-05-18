<?php 
namespace Models;
 
class Geo extends Models {
	public function getCountries() {
		$query = "SELECT * FROM `countries` ORDER BY `title`";
		$countries = $this->Database->getObject($query);
		
		return $countries;
	}
	
	public function getRegions() {
		$query = "SELECT * FROM `regions` ORDER BY `title`" ;
		$regions = $this->Database->getObject($query);
		
		return $regions;
	}
	
	public function getCities($region_id) {
		$query = "SELECT * FROM `cities` WHERE `region_id`=? ORDER BY `title`";
		$cities = $this->Database->getObject($query, [$region_id]);
		
		return $cities;
	}
}
