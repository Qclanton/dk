<?php 
namespace Models;
 
class Bulletins extends Models {
	const BULLETIN_QUERY_BASE_SUBJECT="
		b.*,
		bi.`link` AS 'default_image',
		u.`name` AS 'name'
	";
	const BULLETIN_QUERY_BASE_OBJECT = "
		`bulletins` b LEFT JOIN
		`bulletins_images` bi ON (`bi`.bulletin_id=b.`id` AND bi.`default_fl`='YES') JOIN
		`users` u ON (u.`id`=b.`user_id`)
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
	public function getBulletin($id) {
		$query = "SELECT " . self::BULLETIN_QUERY_BASE_SUBJECT . " FROM " .  self::BULLETIN_QUERY_BASE_OBJECT . " WHERE b.`id`=?";
		$bulletin = $this->Database->getRow($query, [$id]);
		
		if (!$bulletin) { $bulletin = $this->default_bulletin; }
		
		return $bulletin;
	}
	
	public function getBulletins($user_id=null, $params=null) {
		$query = "SELECT SQL_CALC_FOUND_ROWS " . self::BULLETIN_QUERY_BASE_SUBJECT . " FROM " .  self::BULLETIN_QUERY_BASE_OBJECT . " WHERE ?";
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
			$query .= "(?,?, 'NO')";
			$vars[] = $bulletin_id;
			$vars[] = $image;
			
			$i++; 
			if ($i < count($images)) { $query .= ","; }			
		}
		
		$result = $this->Database->executeQuery($query, $vars);

		return $result;
	}
	
	public function setDefaultImage($bulletin_id, $link) {		
		$query = "UPDATE `bulletins_images` SET `default_fl`='NO' WHERE `bulletin_id`=?";
		$this->Database->executeQuery($query, [$bulletin_id]);
		
		$query = "UPDATE `bulletins_images` SET `default_fl`='YES' WHERE `bulletin_id`=? AND `link`=?";
		$this->Database->executeQuery($query, [$bulletin_id, $link]);
	}
	
	public function getImages($bulletin_id) {
		$query = "SELECT * FROM `bulletins_images` WHERE `bulletin_id`=?";
		$images = $this->Database->getObject($query, [$bulletin_id]);
		
		return $images;			
	}
}	
