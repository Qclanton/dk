<?php
namespace Components;

class Main extends Components {	
	public function load() {
		// Set View
		$this->setView('components/main/views/content.php');
		$this->renderViewContent();
		$this->content['main'] = $this->View->content;
	}
}
?>
