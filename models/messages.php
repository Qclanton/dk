<?php 
namespace Models;
 
class Messages extends Models {
	const MESSAGE_QUERY_BASE_SUBJECT="
		m.*,
		LEFT (m.`text`, 50) AS 'shorttext',
		u.`name` AS 'author',
		p.`image` AS 'image'
	";
	const MESSAGE_QUERY_BASE_OBJECT = "
		`messages` m JOIN 
		`users` u ON (u.`id`=m.`author_id`) JOIN
		`profiles` p ON (p.`user_id`=m.`author_id`)
	";
	
	public function getMessage($id) {
		$query = "SELECT " . self::MESSAGE_QUERY_BASE_SUBJECT . " FROM " .  self::MESSAGE_QUERY_BASE_OBJECT . " WHERE m.`id`=?";
		$message = $this->Database->getRow($query, [$id]);		
	
		return $message;
	}
	
	public function getMessages($recipient_id, $params=null) {		
		$query = "SELECT " . self::MESSAGE_QUERY_BASE_SUBJECT . " FROM " .  self::MESSAGE_QUERY_BASE_OBJECT . " WHERE m.`recipient_id`=?";
		$vars = [$recipient_id];
		
		if ($params) {
			$confines = $this->getConfines($params);
			$query .= $confines['query'];
			$vars = array_merge($vars, $confines['vars']);
		}
		$messages = $this->Database->getObject($query, $vars);
		
		return $messages;	
	}
	
	public function getChain($recipient_id, $author_id) {
		$query = "SELECT " . self::MESSAGE_QUERY_BASE_SUBJECT . " FROM " .  self::MESSAGE_QUERY_BASE_OBJECT . " WHERE";
		$query .= " (m.`recipient_id`=? AND m.`author_id`=?) OR ";
		$query .= " (m.`author_id`=? AND m.`recipient_id`=?)";
		$vars = [$recipient_id, $author_id, $recipient_id, $author_id];
		
		$params = [
			'order'=>[
				['column'=>'creation_date', 'side'=>'DESC']
			],
			'limit_qty' => 10
		];
		$confines = $this->getConfines($params);
		$query .= $confines['query'];
		$vars = array_merge($vars, $confines['vars']);
		
		$messages = $this->Database->getObject($query, $vars);
		
		return $messages;	
	}
	
	public function add($message) {		
		$query = "INSERT INTO `messages` VALUES (NULL, ?, ?, NOW(), ?)";
		$vars = [$message->author_id, $message->recipient_id, $message->text];
		
		$result = $this->Database->executeQuery($query, $vars);
		if (!$result) { return false; }
		
		$query = "SELECT LAST_INSERT_ID() AS 'last_id'";
		$id = $this->Database->getValue($query);
		
		return $id;
	}
}
