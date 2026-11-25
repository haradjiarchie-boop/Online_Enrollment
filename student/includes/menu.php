<?php $appCurrentPage = basename($_SERVER['SCRIPT_NAME'] ?? ''); ?>
<div class="sidebar-brand">
	<img src="../assets/logo.jpg" alt="">
	<span><strong>John Paul College</strong><small>ONLINE ENROLLMENT</small></span>
</div>
<p class="sidebar-role">Student workspace</p>
<ul>
	<li class="nav-section">My Campus</li>
	<li class="nav-item"><a class="nav-link<?php echo $appCurrentPage === 'studentindex.php' ? ' active' : ''; ?>" href="studentindex.php"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-home"/></svg>Dashboard</a></li>
	<li class="nav-item"><a class="nav-link<?php echo $appCurrentPage === 'studentprofile.php' ? ' active' : ''; ?>" href="studentprofile.php"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-user"/></svg>My Profile</a></li>
	<li class="nav-section">Enrollment</li>
	<li class="nav-item"><a class="nav-link<?php echo $appCurrentPage === 'enroll.php' || $appCurrentPage === 'showsubs.php' ? ' active' : ''; ?>" href="enroll.php"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-enroll"/></svg>Enroll Now</a></li>
	<li class="nav-item"><a class="nav-link<?php echo $appCurrentPage === 'enrollmenthistory.php' ? ' active' : ''; ?>" href="enrollmenthistory.php"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-history"/></svg>Enrollment History</a></li>
	<li class="nav-item"><a class="nav-link<?php echo $appCurrentPage === 'assessment.php' || $appCurrentPage === 'cor.php' ? ' active' : ''; ?>" href="assessment.php"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-money"/></svg>Assessment &amp; Payments</a></li>
	<li class="nav-section">My Account</li>
	<li class="nav-item"><a class="nav-link<?php echo $appCurrentPage === 'documents.php' ? ' active' : ''; ?>" href="documents.php"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-document"/></svg>My Documents</a></li>
	<li class="nav-item"><a class="nav-link<?php echo $appCurrentPage === 'notifications.php' ? ' active' : ''; ?>" href="notifications.php"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-bell"/></svg>Notifications<?php $appUnread = app_unread_notifications($conn, (int)$_SESSION['userID']); if ($appUnread > 0) { echo ' <span class="badge badge-blue">' . $appUnread . '</span>'; } ?></a></li>
	<li class="nav-item nav-logout"><form method="post" action="../logout.php" class="logout-form"><input type="hidden" name="csrf_token" value="<?php echo app_h(app_csrf_token()); ?>"><button type="submit" class="nav-link"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-logout"/></svg>Log Out</button></form></li>
</ul>
<div class="sidebar-footer"><span class="sidebar-footer-mark"></span><span>Secure campus access</span></div>
