<div id="navBarContainer">
			<nav class="navBar">
				<span class="logo" role="link" tabindex="0" onclick="openPage('dashboard.php')">
					<img style="opacity: .5;" src="assets/img/bridge4.png">
					<span>Riverr</span>
				</span>

				<div class="group">
					<div class="navItem">
						<span class="navItemLink" role="link" tabindex="0" onclick="openPage('search.php')">Search...
						<img style="opacity: .45;" src="assets/img/icons8_search_50px.png" class="icon" alt="search">
						</span>
					</div>
				</div>

				<div class="group">
					<div class="navItem">
						<span class="navItemLink" role="link" tabindex="0" onclick="openPage('dashboard.php')">Home</span>
					</div>

					<div class="navItem">
						<span class="navItemLink" role="link" tabindex="0" onclick="openPage('yourMusic.php')">Your Music</span>
					</div>

					<div class="navItem">
						<span class="navItemLink" role="link" tabindex="0" onclick="openPage('explore.php')">Browse</span>
					</div>
				</div>

				<div class="group">
					<div class="navItem" >
						<button style="margin-bottom: 0;" class="button navItemLink accountButton" role="link" tabindex="0" onclick="openPage('settings.php')"><?php echo $userLoggedIn->getUsername(); ?></button>
					</div>
				</div>

			</nav>
		</div>