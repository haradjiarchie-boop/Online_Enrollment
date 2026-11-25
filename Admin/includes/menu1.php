<?php $appCurrentPage = basename($_SERVER['SCRIPT_NAME'] ?? ''); ?>
<div class="sidebar-brand">
	<img src="../assets/logo.jpg" alt="">
	<span><strong>John Paul College</strong><small>ONLINE ENROLLMENT</small></span>
</div>
<p class="sidebar-role">Administrator workspace</p>
<ul>
	<li class="nav-section">Overview</li>
	<li class="nav-item"><a href="adminindex.php" class="nav-link<?php echo $appCurrentPage === 'adminindex.php' ? ' active' : ''; ?>"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-home"/></svg>Dashboard</a></li>
	<li class="nav-item"><a href="report.php" class="nav-link<?php echo $appCurrentPage === 'report.php' ? ' active' : ''; ?>"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-report"/></svg>Enrollment Report</a></li>
	<li class="nav-section">Student Services</li>
	<li class="nav-item"><a href="userreg.php" class="nav-link<?php echo $appCurrentPage === 'userreg.php' ? ' active' : ''; ?>"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-users"/></svg>Manage Students</a></li>
	<li class="nav-item"><a href="payments.php" class="nav-link<?php echo $appCurrentPage === 'payments.php' ? ' active' : ''; ?>"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-money"/></svg>Payments</a></li>
	<li class="nav-item"><a href="documents.php" class="nav-link<?php echo $appCurrentPage === 'documents.php' ? ' active' : ''; ?>"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-document"/></svg>Documents</a></li>
	<li class="nav-section">Academic Setup</li>
	<li class="nav-item"><a href="subjectreg.php" class="nav-link<?php echo $appCurrentPage === 'subjectreg.php' ? ' active' : ''; ?>"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-book"/></svg>Subjects</a></li>
	<li class="nav-item"><a href="sectionreg.php" class="nav-link<?php echo $appCurrentPage === 'sectionreg.php' ? ' active' : ''; ?>"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-grid"/></svg>Sections</a></li>
	<li class="nav-item"><a href="schedreg.php" class="nav-link<?php echo $appCurrentPage === 'schedreg.php' ? ' active' : ''; ?>"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-calendar"/></svg>Schedules</a></li>
	<li class="nav-section">Administration</li>
	<li class="nav-item"><a href="enrollment_settings.php" class="nav-link<?php echo $appCurrentPage === 'enrollment_settings.php' ? ' active' : ''; ?>"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-settings"/></svg>Enrollment Settings</a></li>
	<li class="nav-item"><a href="notifications.php" class="nav-link<?php echo $appCurrentPage === 'notifications.php' ? ' active' : ''; ?>"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-bell"/></svg>Notifications<?php $appUnread = app_unread_notifications($conn, (int)$_SESSION['userID']); if ($appUnread > 0) { echo ' <span class="badge badge-blue">' . $appUnread . '</span>'; } ?></a></li>
	<li class="nav-item"><a href="audit.php" class="nav-link<?php echo $appCurrentPage === 'audit.php' ? ' active' : ''; ?>"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-activity"/></svg>Audit Log</a></li>
	<li class="nav-item nav-logout"><form method="post" action="../logout.php" class="logout-form"><input type="hidden" name="csrf_token" value="<?php echo app_h(app_csrf_token()); ?>"><button type="submit" class="nav-link"><svg class="nav-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-logout"/></svg>Log Out</button></form></li>
</ul>
<div class="sidebar-footer"><span class="sidebar-footer-mark"></span><span>Secure campus access</span></div>
