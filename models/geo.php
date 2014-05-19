<?php 
namespace Models;
 
class Geo extends Models {
	public function getCountries() {
		$query = "SELECT * FROM `countries` ORDER BY `title`";
		$countries = $this->Database->getObject($query);
		
		return $countries;
	}
	
	public function getRegions($country_id) {
		$query = "SELECT * FROM `regions` WHERE `country_id`=? ORDER BY `title`" ;
		$regions = $this->Database->getObject($query, [$country_id]);
		
		return $regions;
	}
	
	public function getCities($region_id) {
		$query = "SELECT * FROM `cities` WHERE `region_id`=? ORDER BY `title`";
		$cities = $this->Database->getObject($query, [$region_id]);
		
		return $cities;
	}
	
	public function getCityId($region_id, $title) {
		$query = "SELECT `id` FROM `cities` WHERE `region_id`=? AND `title`=? ORDER BY `region_id` LIMIT 1";
		$city_id = $this->Database->getValue($query, [$region_id, $title]);
		
		return $city_id;
	}
	
	public function addCity($region_id, $title) {
		$query = "INSERT INTO `cities` VALUES (NULL, ?, ?)";
		$vars = [$region_id, $title];
		$result = $this->Database->executeQuery($query, $vars);
		
		if ($result) {
			$query = "SELECT LAST_INSERT_ID() AS 'last_id'";
			$result = $this->Database->getValue($query);
		}
		
		return $result;
	}
}
