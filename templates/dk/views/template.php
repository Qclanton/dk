<head>
	<meta charset="utf-8"> 
	<link rel="stylesheet" type="text/css" href="<?= $this->site_url; ?>templates/dk/views/css/style.css" />
	<!-- <link href="<?= $this->site_url; ?>templates/basic/views/images/favicon.png" rel="shortcut icon" type="image/x-icon" /> -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	%head%
	<script src="<?= $this->site_url; ?>templates/dk/views/js/jquery.arcticmodal-0.3.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?= $this->site_url; ?>templates/dk/views/css/jquery.arcticmodal-0.3.css" />
	<link rel="stylesheet" type="text/css" href="<?= $this->site_url; ?>templates/dk/views/css/simple.css" />
	<script>
		$(function(){ 
			$('#show-login-form-button').on('click', function() {
				$('#exampleModal').arcticmodal();
			});
		});
	</script>
	<? if ($this->get->component == 'main') { ?>
		<style> 
			#fixed-block {
				height: 70% !important; 
			}
		</style>
	<? } ?>
</head>
<body>

	<!---<div id="header">
		<div id="header-wrapper">
			<div id="logo">
				<a href="http://av14683.comex.ru/qtask">
					<img src="<?= $this->site_url; ?>templates/basic/views/images/logo.png"></img>		
				</a>
			</div>
			<div id="menu">
				<ul>
						<li><a href="<?= $this->site_url; ?>">Главная</a></li>
						<? if ($logged_fl == "yes") { ?><li><a href="<?= $this->site_url; ?>index.php/?component=bulletin_board&action=create">Создать объявление</a></li><? } ?>
						<? if ($logged_fl == "yes") { ?><li><a href="<?= $this->site_url; ?>index.php/?component=bulletin_board&action=showmylist">Мои объявления</a></li><? } ?>
					<li><a href="<?= $this->site_url; ?>index.php/?component=projects&action=list">Project List</a></li>
					<? if ($logged_fl == "yes") { ?>
						<li><a href="<?= $this->site_url; ?>index.php/?component=filters&action=mytasks">My Tasks</a></li>
					<? } ?>

				</ul>
			</div>			

		</div>
	</div>--->
<section id="fixed-block"> 
	<div class="title-block">
		<div id="header">
			<div id="logo">
				<a href="http://av14683.comex.ru/dk">
					<img src="<?= $this->site_url; ?>templates/dk/views/images/logo.png"></img>
				</a>
			</div>
			<div id="menu">
				<ul>
					<li><a href="<?= $this->site_url; ?>">Главная</a></li>
					<li><a href="<?= $this->site_url; ?>index.php/?component=partner_finder&action=search">Поиск партнера</a></li>
					<? if ($logged_fl == "yes") { ?>
						<li><a href="<?= $this->site_url; ?>index.php/?component=bulletin_board&action=create">Создать объявление</a></li>
						<li><a href="<?= $this->site_url; ?>index.php/?component=bulletin_board&action=showmylist">Мои объявления</a></li>
						<li><a href="<?= $this->site_url; ?>index.php/?component=messages&action=showmylist">Мои сообщения</a></li>
						<li><a href="<?= $this->site_url; ?>index.php/?component=partner_finder&action=myprofile">Моя анкета</a></li>
					<? } ?>
				</ul>
				
			</div>
			<div id="login-form--wrapper">
				<? if ($logged_fl == "no") { ?>
					<button id="show-login-form-button">Login</button>
				<? } else { ?>
					<a href="<?= $this->site_url; ?>index.php?component=authorization&action=logout"><button id="logout-button">Logout</button></a>
				<? } ?>
				
				<div style="display: none;">
					<div class="box-modal" id="exampleModal">
						<div class="box-modal_close arcticmodal-close">закрыть</div>
						<form action="<?= $this->site_url; ?>index.php?component=authorization" method="post" id="login-form">
							<table class="login-form-modal">
								<tr>
									<td>
										<div class="login-email"><h3>Email:</h3> <input type="text" name="login"></input></div>
									</td>
									<td>
										<div class="login-pass"><h3>Password:</h3>  <input type="password" name="password"></input></div>
									</td>
								</tr>
							</table>
							<input type="hidden" name="successfull_url" value=<?= $this->current_url; ?>></input>
							<button id="login-button">Login</button>
						</form>						
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="error">
		%error%
	</div>
</section>
<? if ($this->get->component != 'main') { ?>
<section id="breadcrumbs"> 
	<div id="breadcrumbs-wrapper">
		%breadcrumbs%
	</div>
</section>
<? } ?>
<section id="main-container">
	%main%
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
</section>


<section id="footer">
	<div id="footer-wrapper">
		Powered by QclDev © 2014
	</div>

</section>
</body>
