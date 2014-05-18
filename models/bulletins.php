<?php 
namespace Models;
 
class Bulletins extends Models {
	const BULLETIN_QUERY_BASE_SUBJECT="
		b.*
	";
	const BULLETIN_QUERY_BASE_OBJECT = "
		`bulletins` b
	";
	
		
	public $default_bulletin = [
		'id' => null,
		'user_id' => null,
		'creation_date' => 'future',
		'title' => '',
		'description' => '',
		'cost' => 0,
		'size'=>''		
	];
	public function getBulletin($id=null) {
		$query = "SELECT " . self::BULLETIN_QUERY_BASE_SUBJECT . " FROM " .  self::BULLETIN_QUERY_BASE_OBJECT . " WHERE b.`id`=?";
		$bulletin = $this->Database->getRow($query, [$id]);
		
		if (!$bulletin) { $bulletin = $this->default_bulletin; }
		
		return $bulletin;
	}
	
	public function getBulletins($user_id=null, $params=null) {
		$query = "SELECT " . self::BULLETIN_QUERY_BASE_SUBJECT . " FROM " .  self::BULLETIN_QUERY_BASE_OBJECT . " WHERE ?";
		$vars = ['1'];
		
		if ($user_id) {
			$query .= " AND b.`user_id`=?";
			$vars[] = $user_id;
		}
		if ($params) {
			$confines = $this->getConfines($params);
			$query .= $confines['query'];
			$vars = array_merge($vars, $confines['vars']);
		}
		$bulletins = $this->Database->getObject($query, $vars);
		
		return $bulletins;	
	}
	
	public function setBulletin($bulletin) {
		$bulletin = $this->nullValues($bulletin, ["id"]);
		if (!$bulletin->id) { $bulletin->creation_date = date('Y-m-d H:i:s'); }
		
		$query = "INSERT INTO `bulletins` VALUES (?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `title`=?, `description`=?, `cost`=?, `size`=?";
		$vars = [
			$bulletin->id,
			$bulletin->user_id,
			$bulletin->creation_date,
			$bulletin->title,
			$bulletin->description,
			$bulletin->cost,
			$bulletin->size,
			$bulletin->title,
			$bulletin->description,
			$bulletin->cost,
			$bulletin->size
		];
		
		$result = $this->Database->executeQuery($query, $vars);
		if (!$result) { return false; }
		
		if (!$bulletin->id) {
			$query = "SELECT LAST_INSERT_ID() AS 'last_id'";
			$bulletin->id = $this->Database->getValue($query);
		}
		
		return $bulletin->id;
	}
	
	public function attachImages($bulletin_id, $images) {
		$query = "INSERT INTO `bulletins_images` VALUES ";
		$vars = [];
		$i=0;
		foreach ($images as $image) {
			$query .= "(?,?)";
			$vars[] = $bulletin_id;
			$vars[] = $image;
			
			$i++; 
			if ($i < count($images)) { $query .= ","; }			
		}
		
		$result = $this->Database->executeQuery($query, $vars);
	}
	
	public function getImages($bulletin_id) {
		$query = "SELECT * FROM `bulletins_images` WHERE `bulletin_id`=?";
		$images = $this->Database->getObject($query, [$bulletin_id]);
		
		return $images;			
	}
}	
