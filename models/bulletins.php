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
		'cost' => 0		
	];
	public function getBulletin($id=null) {
		$query = "SELECT " . self::BULLETIN_QUERY_BASE_SUBJECT . " FROM " .  self::BULLETIN_QUERY_BASE_OBJECT . " WHERE b.`id`=?";
		$bulletin = $this->Database->getRow($query, [$id]);
		
		if (!$bulletin) { $bulletin = $this->default_bulletin; }
		
		return $bulletin;
	}
	
	public function getBulletins($user_id) {
		$query = "SELECT " . self::BULLETIN_QUERY_BASE_SUBJECT . " FROM " .  self::BULLETIN_QUERY_BASE_OBJECT . " WHERE b.`user_id`=?";
		$bulletins = $this->Database->getObject($query, [$user_id]);
		
		return $bulletins;	
	}
	
	public function setBulletin($bulletin) {
		$bulletin = $this->nullValues($bulletin, ["id"]);
		if (!$bulletin->id) { $bulletin->creation_date = date('Y-m-d H:i:s'); }
		
		$query = "INSERT INTO `bulletins` VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `title`=?, `description`=?, `cost`=?";
		$vars = [
			$bulletin->id,
			$bulletin->user_id,
			$bulletin->creation_date,
			$bulletin->title,
			$bulletin->description,
			$bulletin->cost,
			$bulletin->title,
			$bulletin->description,
			$bulletin->cost
		];
		
		$this->Database->executeQuery($query, $vars);
	}
}
