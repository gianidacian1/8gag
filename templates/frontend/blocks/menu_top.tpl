<div id="top_menu_button" class="menu_button" onclick="ShowTopMenu()">
	<span></span>
	<span></span>
	<span></span>
</div>
<ul id="top_menu" class="menu_top">
	
	<li class="{SEL_PAGE_LIST}">
		<a href="{SITE_URL}/post/list">List</a>
	</li>
	<li class="{SEL_PAGE_UPLOAD}">
		<a href="{SITE_URL}/post/upload">Upload</a>
	</li>
	<li class="{SEL_PAGE_USER}">
		<a href="{SITE_URL}/post/user">User</a>
	</li>
	<!-- BEGIN top_menu_not_logged -->
	<li class="{SEL_USER_LOGIN}">
		<a href="{SITE_URL}/user/login">Log In</a>
	</li>
	<li class="{SEL_USER_REGISTER}">
		<a href="{SITE_URL}/user/register">Register</a>
	</li>
	<!-- END top_menu_not_logged -->
	<!-- BEGIN top_menu_logged -->
	<li class="{SEL_USER_ACCOUNT}">
		<a href="{SITE_URL}/user/account">My Account</a>
	</li>
	<li>
		<a href="{SITE_URL}/user/logout">Log Out</a>
	</li>
	<!-- END top_menu_logged -->
</ul>