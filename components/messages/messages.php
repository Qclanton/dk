<?php
namespace Components;

class Messages extends Components {	
	public function prepare() {
		$this->loadModels(['Messages']);		
	}
	
	public function load() {
		$action = $this->get->action;
		
		switch ($action) {
			case 'showmylist':
				$this->showList();
				break;
			case 'showchain':
				$this->showChain($this->get->author_id);
				break;
			case 'add':
				$message = $this->post;
				$message->author_id = $this->user_id;
				
				$this->Messages->add($message);
				$this->redirect($this->post->return_url);
				break;			
		}
	}

	private function showList() {
		$confines = [
			'order'=>[
				['column'=>'creation_date', 'side'=>'DESC']
			],
			'limit_qty' => 10,
			'limit_start' => 0
		];
		$messages = $this->Messages->getMessages($this->user_id);
		
		// Set View
		$this->setView('components/messages/views/mylist.php', ['messages'=>$messages]);
		$this->renderViewContent();
		$this->content['top'] = $this->View->content;		
		
		// Set Bradcrumbs
		$this->loadHelpers(['Breadcrumbs']);
		$breadcrumbs = ['Мои сообщения' => ''];
		$this->content['breadcrumbs'] = $this->Breadcrumbs->getHtml($breadcrumbs);
	}
	
	private function showChain($author_id) {
		$messages = $this->Messages->getChain($this->user_id, $author_id);
			
		// Set Views
		$this->setView('components/messages/views/chain.php', ['messages'=>array_reverse($messages)]);
		$this->renderViewContent();
		$this->content['top'] = $this->View->content;
		
		$this->setView('components/messages/views/addform.php', ['recipient_id'=>$author_id]);
		$this->renderViewContent();
		$this->content['bottom'] = $this->View->content;
				
		
		// Set Bradcrumbs
		$this->loadHelpers(['Breadcrumbs']);
		$this->loadModels(['Users']);
		$user = $this->Users->getUser($author_id);
		$breadcrumbs = [
			'Мои сообщения' => $this->site_url . 'index.php/?component=messages&action=showmylist',
			'Переписка с ' . $user['name']
		];
		$this->content['breadcrumbs'] = $this->Breadcrumbs->getHtml($breadcrumbs);		
	}
}
