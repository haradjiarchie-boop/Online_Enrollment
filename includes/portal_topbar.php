<?php
$portalRole = isset($_SESSION['type']) && $_SESSION['type'] === 'admin' ? 'Administrator' : 'Student';
$portalProfileHref = $portalRole === 'Administrator' ? 'adminedit.php' : 'studentprofile.php';
$portalUsername = isset($_SESSION['username']) && is_string($_SESSION['username']) ? $_SESSION['username'] : 'Account';
$portalInitial = strtoupper(substr($portalUsername, 0, 1));
?>
<header class="portal-topbar">
	<div class="portal-topbar-title">
		<span>JOHN PAUL COLLEGE</span>
		<strong>Online Enrollment Portal</strong>
	</div>
	<div class="portal-topbar-actions">
		<a class="topbar-notifications" href="notifications.php">
			<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg>
			<span>Notifications</span>
		</a>
		<a class="topbar-profile" href="<?php echo app_h($portalProfileHref); ?>">
			<span class="topbar-avatar" aria-hidden="true"><?php echo app_h($portalInitial); ?></span>
			<span class="topbar-user-copy">
				<strong><?php echo app_h($portalUsername); ?></strong>
				<small><?php echo app_h($portalRole); ?></small>
			</span>
		</a>
	</div>
</header>
<script>
(function () {
	var activeLink = document.querySelector('.container .nav-link.active');
	var navList = activeLink && activeLink.closest('.container > ul');
	if (!activeLink || !navList || window.innerWidth > 760) {
		return;
	}
	window.requestAnimationFrame(function () {
		var listRect = navList.getBoundingClientRect();
		var linkRect = activeLink.getBoundingClientRect();
		navList.scrollLeft += linkRect.left - listRect.left - (navList.clientWidth - linkRect.width) / 2;
	});
})();
</script>
