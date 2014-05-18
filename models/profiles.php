<?php 
namespace Models;
 
class Profiles extends Models {
	const PROFILE_QUERY_BASE_SUBJECT="
		p.*,
		dt.`title` AS 'dance_type',
		dc.`title` AS 'dance_class',
		country.`title` AS 'country',
		city.`title` AS 'city'
	";
	const PROFILE_QUERY_BASE_OBJECT = "
		`profiles` p JOIN 
		`dance_types` dt ON (dt.`id`=p.`dance_type_id`) JOIN
		`dancers_classes` dc ON (dc.`id`=p.`dancer_class_id`) JOIN
		`countries` country ON (country.`id`=p.`country_id`) JOIN
		`cities` city ON (city.`id`=p.`city_id`)		
	";

	public $default_profile = [
		'id' => null,
		'user_id' => null,
		'creation_date' => 'future',
		'sex' => 'MALE',
		'birth_date' => '1990-01-01',
		'height'=> '160',
		'heightshoes' => '170',
		'dance_type_id' => '1',
		'dancer_class_id' => '1',
		'country_id' => '1',
		'region_id' => '1053480',
		'city_id' => '5469360',
		'station_id' => null,
		'phone' => '79261234567'
	];
	
	public function getProfile($user_id) {
		$query = "SELECT " . self::PROFILE_QUERY_BASE_SUBJECT . " FROM " .  self::PROFILE_QUERY_BASE_OBJECT . " WHERE p.`user_id`=?";
		$profile = $this->Database->getRow($query, [$user_id]);
		
		if (!$profile) { $profile = $this->default_profile; }
		
		return $profile;
	}
	
	public function setProfile($profile) {
		$profile = $this->nullValues($profile, ['id', 'user_id', 'station_id']);
		if (!$profile->id) { $profile->creation_date = date('Y-m-d H:i:s'); }
				
		$query = "
			INSERT INTO `profiles` 
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			ON DUPLICATE KEY UPDATE
				`sex`=?,
				`birth_date`=?,
				`height`=?,
				`heightshoes`=?,
				`dance_type_id`=?,
				`dancer_class_id`=?,
				`country_id`=?,
				`region_id`=?,
				`city_id`=?,
				`station_id`=?,
				`phone`=?			
		";
	
		$vars = [
			$profile->id,
			$profile->user_id,
			$profile->creation_date,
			$profile->sex,
			$profile->birth_date,
			$profile->height,
			$profile->heightshoes,
			$profile->dance_type_id,
			$profile->dancer_class_id,
			$profile->country_id,
			$profile->region_id,
			$profile->city_id,
			$profile->station_id,
			$profile->phone,
			$profile->sex,
			$profile->birth_date,
			$profile->height,
			$profile->heightshoes,
			$profile->dance_type_id,
			$profile->dancer_class_id,
			$profile->country_id,
			$profile->region_id,
			$profile->city_id,
			$profile->station_id,
			$profile->phone
		];
		
		$result = $query = $this->Database->executeQuery($query, $vars);
		
		return $result;
	}
	
	public function getDanceTypes() {
		$query = "SELECT * FROM `dance_types`";
		$types = $this->Database->getObject($query);
		
		return $types;
	}
	
	public function getDancersClasses() {
		$query = "SELECT * FROM `dancers_classes`";
		$classes = $this->Database->getObject($query);
		
		return $classes;
	}
}
