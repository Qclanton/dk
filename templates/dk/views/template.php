<head>
	<meta charset="utf-8"> 
	<link rel="stylesheet" type="text/css" href="<?= $this->site_url; ?>templates/dk/views/style.css" />
	<!-- <link href="<?= $this->site_url; ?>templates/basic/views/images/favicon.png" rel="shortcut icon" type="image/x-icon" /> -->
	%head%
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<body>
<div id="fixed-block">
	<div id="header">
		<div id="header-wrapper">
			<div id="logo">
				<!-- <a href="http://av14683.comex.ru/qtask">
					<img src="<?= $this->site_url; ?>templates/basic/views/images/logo.png"></img>		
				</a>-->
			</div>
			<div id="menu">
				<ul>
						<li><a href="<?= $this->site_url; ?>">Главная</a></li>
						<? if ($logged_fl == "yes") { ?><li><a href="<?= $this->site_url; ?>index.php/?component=bulletin_board&action=create">Создать объявление</a></li><? } ?>
						<? if ($logged_fl == "yes") { ?><li><a href="<?= $this->site_url; ?>index.php/?component=bulletin_board&action=showmylist">Мои объявления</a></li><? } ?>
			<!--			<li><a href="<?= $this->site_url; ?>index.php/?component=projects&action=list">Project List</a></li>
					<? if ($logged_fl == "yes") { ?>
						<li><a href="<?= $this->site_url; ?>index.php/?component=filters&action=mytasks">My Tasks</a></li>
					<? } ?>
			-->
				</ul>
			</div>			
			<div id="login-form--wrapper">
				<? if ($logged_fl == "no") { ?>
				<form action="<?= $this->site_url; ?>index.php?component=authorization" method="post" id="login-form">
					<input type="text" name="login"></input>
					<input type="password" name="password"></input>
					<input type="hidden" name="successfull_url" value=<?= $this->current_url; ?>></input>
					<button id="login-button">Login</button>
				</form>
				<? } ?>
				<? if ($logged_fl == "yes") { ?>
					<a href="<?= $this->site_url; ?>index.php?component=authorization&action=logout"><button id="logout-button">Logout</button></a>
				<? } ?>
			</div>
		</div>
	</div>
	
	<div class="title-block"><h2>%meta%</h2></div>
	<div id="breadcrumbs"> 
		<div id="breadcrumbs-wrapper">
			%breadcrumbs%
		</div>
	</div>
	<div id="error">
		%error%
	</div>
	<div id="main-container">
		<div class="content">
			<div id="top-content">
				%top%
			</div>
			<div id="right-content">
				%right%
			</div>
			<div id="bottom-content">
				%bottom%
			</div>
		</div>
	</div>
</div>
	<div id="footer">
		<div id="footer-wrapper">
			Powered by QclDev © 2014
		</div>
	</div>
</body>
