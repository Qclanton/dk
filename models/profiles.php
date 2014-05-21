<?php 
namespace Models;
 
class Profiles extends Models {
	const PROFILE_QUERY_BASE_SUBJECT="
		p.*,
		u.`name` as 'name',
		dt.`title` AS 'dance_type',
		dc.`title` AS 'dancer_class',
		country.`title` AS 'country',
		re.`title` AS 'region',
		city.`title` AS 'city'
	";
	const PROFILE_QUERY_BASE_OBJECT = "
		`profiles` p JOIN
		`users` u ON (u.`id`=p.`user_id`)JOIN  
		`dance_types` dt ON (dt.`id`=p.`dance_type_id`) JOIN
		`dancers_classes` dc ON (dc.`id`=p.`dancer_class_id`) JOIN
		`countries` country ON (country.`id`=p.`country_id`) JOIN
		`regions` re ON (re.`id`=p.`region_id`) JOIN
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
		'phone' => '79261234567',
		'image' => null
	];
	
	public function getProfile($id=null, $user_id=null) {
		if (!$id && !$user_id) { return false; }
		
		$query = "SELECT " . self::PROFILE_QUERY_BASE_SUBJECT . " FROM " .  self::PROFILE_QUERY_BASE_OBJECT . " WHERE ?";
		$vars = ['1'];
		if ($id) {
			$query .= " AND p.`id`=?";
			$vars[] = $id;
		}
		elseif ($user_id) {
			$query .= " AND p.`user_id`=?";
			$vars[] = $user_id;
		}
		
		$profile = $this->Database->getRow($query, $vars);
		
		if (!$profile) { $profile = $this->default_profile; }
		
		return $profile;
	}	

	public function setProfile($profile) {
		$profile = $this->nullValues($profile, ['id', 'user_id', 'station_id', 'phone', 'image']);
		if (!$profile->id) { $profile->creation_date = date('Y-m-d H:i:s'); }
		if (!$profile->city_id && $profile->city) {
			$this->loadModels(['Geo']);
			$city_id = $this->Geo->getCityId($profile->region_id, $profile->city);
			if (!$city_id) {
				$city_id = $this->Geo->addCity($profile->region_id, $profile->city);
			}
			$profile->city_id = $city_id;
		}
				
		$query = "
			INSERT INTO `profiles` 
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
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
				`phone`=?,
				`image`=?			
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
			$profile->image,
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
			$profile->image
		];
		
		$result = $query = $this->Database->executeQuery($query, $vars);
		
		return $result;
	}
	
	// Search
	public $default_search = [
		'sex' => null,
		
		'birth_year_after' => null,
		'birth_year_before' => null,
		
		'height_before'=> null,
		'height_after'=> null,

		'dance_type_id' => null,
		'dancer_class_id' => null,
		
		'country_id' => null,
		'city_id' => null,
		'region_id' => null,
		
		'name' => null,
		
		'confines' => [
			'order'=>[
				['column'=>"creation_date", 'side'=>"DESC"]
			]
		]
	];
	public function search($params) {
		$params = array_merge($this->default_search, $params);
		$query = "SELECT SQL_CALC_FOUND_ROWS " . self::PROFILE_QUERY_BASE_SUBJECT . " FROM " .  self::PROFILE_QUERY_BASE_OBJECT . " WHERE ?";
		$vars = ['1'];
		
	
		if ($params['sex']) {
			$query .= " AND p.`sex`=?";
			$vars[] = $params['sex'];
		}

		if ($params['birth_year_after']) {
			$query .= " AND p.`birth_date`>CONCAT(?, '-01-01')";
			$vars[] = $params['birth_year_after'];
		}		
		if ($params['birth_year_before']) {
			$query .= " AND p.`birth_date`<=CONCAT(?, '-01-01')";
			$vars[] = $params['birth_year_before'];
		}


		if ($params['height_after']) {
			$query .= " AND p.`height`>?";
			$vars[] = $params['height_after'];
		}		
		if ($params['height_before']) {
			$query .= " AND p.`height`<=?";
			$vars[] = $params['height_before'];
		}

		
		if ($params['dance_type_id']) {
			$query .= " AND p.`dance_type_id`=?";
			$vars[] = $params['dance_type_id'];
		}
		if ($params['dancer_class_id']) {
			$query .= " AND p.`dancer_class_id`=?";
			$vars[] = $params['dancer_class_id'];
		}
		
		if ($params['country_id']) {
			$query .= " AND p.`country_id`=?";
			$vars[] = $params['country_id'];
		}
		if ($params['region_id']) {
			$query .= " AND p.`region_id`=?";
			$vars[] = $params['region_id'];
		}
		if ($params['city_id']) {
			$query .= " AND p.`city_id`=?";
			$vars[] = $params['city_id'];
		}		
		
		if ($params['name']) {
			$query .= " AND u.`name` LIKE CONCAT('%', ?, '%')";
			$vars[] = $params['name'];
		}
		
		
		if ($params['confines']) {
			$confines = $this->getConfines($params['confines']);
			$query .= $confines['query'];
			$vars = array_merge($vars, $confines['vars']);
		}
		
		$result = $this->Database->getObject($query, $vars);
		
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
