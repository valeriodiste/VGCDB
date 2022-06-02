<?php

	session_start();
	$uri = $_SERVER["REQUEST_URI"];
	if ( parse_url($uri, PHP_URL_PATH) != '/pages/Sign_Up/sign_up_page.php' && parse_url($uri, PHP_URL_PATH) != '/pages/Sign_In/sign_in_page.php' && parse_url($uri, PHP_URL_PATH) != '/pages/MessagePage/message_page.php') {
		$_SESSION['last_page_visited'] = $uri;
	}

	echo '<div id="menu-bar" class="soft-shadow">
		<div class="menu-icons">
			<div class="menu">
				<div class="menu-icon-lines">
					<div class="line"></div>
					<div class="line"></div>
					<div class="line"></div>
				</div>
			</div>
			
			<div class="vgcdb"><a href="javascript:transitionTo(\'/pages/HomePage/home_page.php\')">VGCDB</a></div>';
			
			if(isset($_SESSION['username']) && $_SESSION['username']!="") {
				
				$username = $_SESSION['username'];
				
				$dbconn = pg_connect("host = localhost port =5432 dbname = postgres 
				user = postgres password = vgcdb") 
				or database_error('Could not connect : ' . pg_last_error());

				$q1 = "SELECT * FROM users WHERE username=$1";
				$result = pg_query_params($dbconn, $q1, array($username)) or database_error('Query failed : '.pg_last_error());
				if ($line = pg_fetch_row($result)) {
					$icon = "$line[2]";
				} else {
					$icon = "profile_icon_01.png";
				}
				
				echo "<div class='login'>
				<div class='label'>$username</div>
				<div class='login-icon'>
					<img class='icon-dark-mode-responsive' src='/Icons/profile-icons/$icon'>
				</div>
				</div>";
			}   
			else {
				echo "<div class='login'>
				<div class='label'>login</div>
				<div class='login-icon'>
					<img class='icon-dark-mode-responsive' src='/Icons/profile-icons/profile_icon_01.png'>
				</div>
			</div>";
			}
			
		echo '</div>

		<div id="menu-expanded">
			<div class="menu-content">
				<div id="close-menu" class="menu-option">
					<div class="icon">
						<img class="icon-dark-mode-responsive" src="/icons/x-icon.png">
					</div>
					<span>close</span>
				</div>
				<div id="go-to-page" class="menu-option">
					<div class="icon">
						<img class="icon-dark-mode-responsive" src="/icons/home-icon.png">
					</div>
					<a href="javascript:transitionTo(\'/pages/HomePage/home_page.php\')">Home Page</a>
				</div>
				<div id="go-to-page" class="menu-option">
					<div class="icon">
						<img class="icon-dark-mode-responsive" src="/icons/search-icon.png">
					</div>
					<a href="javascript:transitionTo(\'/pages/AdvancedSearch/advanced_search_page.php\')">Advanced Search</a>
				</div>
				<div id="go-to-page" class="menu-option">
					<div class="icon">
						<img class="icon-dark-mode-responsive" src="/icons/suggest-icon.png">
					</div>
					<a href="javascript:transitionTo(\'/pages/SuggestionPage/suggestion_page.php\')">Suggest a character</a>
				</div>
				<div class="menu-option"></div>
				<div id="page-transitions-switch" class="menu-option">
					<div class="menu-switch">
						<label class="switch">
							<input type="checkbox" checked>
							<span class="slider round"></span>
							<span>Page Transitions</span>
						</label>
					</div>
				</div>
				<div id="dark-mode-switch" class="menu-option">
					<div class="menu-switch">
						<label class="switch">
							<input type="checkbox">
							<span class="slider round"></span>
							<span>Dark Mode</span>
						</label>
					</div>
				</div>
			</div>
		</div>';

		if(isset($_SESSION['username']) && $_SESSION['username']!="") {
		echo '<div id="login-expanded">
				<div class="login-content">
					<div id="close-login" class="login-option">
						<span>close</span>
						<div class="icon">
							<img class="icon-dark-mode-responsive" src="/icons/x-icon.png">
						</div>
					</div>
					<div id="go-to-page" class="login-option">
						<a href="javascript:transitionTo(\'/pages/ProfilePage/profile_page.php\')">Profile Page</a>
						<div class="icon">
							<img class="icon-dark-mode-responsive" src="/Icons/profile-icons/profile_icon_01.png">
						</div>
					</div>
					<div id="logout" class="login-option">
						<a href="javascript:transitionTo(\'/pages/Sign_Out/index.php\')">Logout</a>
						<div class="icon">
							<img class="icon-dark-mode-responsive" src="/icons/logout-icon.png">
						</div>
					</div>
				</div>
			</div>';
		}
		
		echo '<div id="click-area-outside"></div>

	</div>';
?>