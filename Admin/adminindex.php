<?php
include('logcheck.php');
$flash = isset($_SESSION['flash_success']) ? $_SESSION['flash_success'] : '';
unset($_SESSION['flash_success']);

function admin_stat($conn, $query, $fallbackQuery = '')
{
	try {
		$result = $conn->query($query);
		$row = $result->fetch_assoc();
		return $row ? (float)array_values($row)[0] : 0;
	} catch (mysqli_sql_exception $exception) {
		if ($fallbackQuery !== '') {
			try {
				$result = $conn->query($fallbackQuery);
				$row = $result->fetch_assoc();
				return $row ? (float)array_values($row)[0] : 0;
			} catch (mysqli_sql_exception $inner) {
				return 0;
			}
		}
		return 0;
	}
}

$studentCount = (int)admin_stat($conn, 'SELECT COUNT(*) FROM studenttbl');
$pendingCount = (int)admin_stat($conn, "SELECT COUNT(*) FROM student_subject WHERE status = 'pending'", 'SELECT COUNT(*) FROM student_subject WHERE approved = 0');
$approvedCount = (int)admin_stat($conn, "SELECT COUNT(*) FROM student_subject WHERE status = 'approved'", 'SELECT COUNT(*) FROM student_subject WHERE approved = 1');
$rejectedCount = (int)admin_stat($conn, "SELECT COUNT(*) FROM student_subject WHERE status = 'rejected'");
$paymentsPending = (int)admin_stat($conn, "SELECT COUNT(*) FROM enrollment_payments WHERE status = 'pending'");
$documentsPending = (int)admin_stat($conn, "SELECT COUNT(*) FROM student_documents WHERE status = 'pending'");
$verifiedTotal = admin_stat($conn, "SELECT COALESCE(SUM(amount), 0) FROM enrollment_payments WHERE status = 'verified'");
$enrollmentState = app_enrollment_open($conn);
$announcements = app_published_announcements($conn);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Administrator Dashboard | John Paul College</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php include __DIR__ . '/../includes/portal_topbar.php'; ?>

<nav class='container'>
<?php
include('includes/menu1.php');
?>
</nav>

<div id="main">
	<div class="shell">
		<?php if ($flash !== '') { ?><p class="form-success" role="status"><?php echo app_h($flash); ?></p><?php } ?>
		<section class="dashboard-hero">
			<div class="dashboard-hero-copy">
				<p class="eyebrow">John Paul College · Administration</p>
				<h1>Enrollment overview</h1>
				<p>Manage student records, review submissions, and keep campus enrollment moving.</p>
				<div class="hero-actions">
					<a class="button" href="report.php">Review enrollments</a>
					<a class="button button-secondary" href="userreg.php">Manage students</a>
				</div>
			</div>
			<div class="hero-summary">
				<span>Enrollment status</span>
				<strong><?php echo $enrollmentState['open'] ? 'Open' : 'Closed'; ?></strong>
				<small>Academic year <?php echo date('Y'); ?>-<?php echo date('Y') + 1; ?></small>
			</div>
		</section>
		<?php if ($enrollmentState['open']) { ?><p class="form-success" role="status">Enrollment is open.</p><?php } else { ?><p class="enrollment-closed" role="alert"><?php echo app_h($enrollmentState['reason']); ?> Change this in <a href="enrollment_settings.php">Enrollment Settings</a>.</p><?php } ?>
		<section class="enrollment-stats" aria-label="Enrollment summary">
			<div class="stat-card"><span>Students</span><svg class="stat-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-users"/></svg><strong><?php echo $studentCount; ?></strong></div>
			<div class="stat-card"><span>Pending enrollments</span><svg class="stat-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-history"/></svg><strong><?php echo $pendingCount; ?></strong></div>
			<div class="stat-card"><span>Approved enrollments</span><svg class="stat-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-enroll"/></svg><strong><?php echo $approvedCount; ?></strong></div>
			<div class="stat-card"><span>Rejected enrollments</span><svg class="stat-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-document"/></svg><strong><?php echo $rejectedCount; ?></strong></div>
			<div class="stat-card"><span>Payments awaiting verification</span><svg class="stat-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-money"/></svg><strong><?php echo $paymentsPending; ?></strong></div>
			<div class="stat-card"><span>Documents awaiting verification</span><svg class="stat-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-document"/></svg><strong><?php echo $documentsPending; ?></strong></div>
			<div class="stat-card"><span>Verified collections</span><svg class="stat-icon" aria-hidden="true"><use href="../assets/icons.svg#nav-money"/></svg><strong>&#8369;<?php echo number_format($verifiedTotal, 2); ?></strong></div>
		</section>
		<div class="dashboard-shortcuts" aria-label="Administrator shortcuts">
			<a class="button button-secondary" href="payments.php">Review payments</a>
			<a class="button button-secondary" href="documents.php">Review documents</a>
			<a class="button button-secondary" href="enrollment_settings.php">Enrollment settings</a>
		</div>
		<?php if ($announcements) { ?>
		<h2>Published announcements</h2>
		<ul class="announcement-list">
			<?php foreach ($announcements as $row) { ?>
			<li><strong><?php echo app_h($row['title']); ?></strong><small><?php echo app_h($row['created_at'] ? date('M j, Y', strtotime($row['created_at'])) : ''); ?></small><p><?php echo app_h($row['body']); ?></p></li>
			<?php } ?>
		</ul>
		<?php } ?>
		<section class="dashboard-card-grid" aria-label="College information and updates">
		<!-- Box -->
		<div class="box">
			<h2>Welcome to Admin</h2>
			<div class="entry">
				<p><strong>John Paul College</strong></p>
				<p><strong>Mission:</strong> A center of learning and academic excellence in the Province of Oriental Mindoro.</p>
				<p><strong>Vision:</strong> John Paul College is committed to improving education and the lives of people by preparing students to think critically, create, lead, compete, and contribute to their communities.</p>
			</div>
		</div>
		<!-- /Box -->
		<!-- Box -->
		<div class="box">
			<h2>Latest Events</h2>
			<div class="entry">
				<!-- News -->
				<div class="news">
					<ul>
						<li>
							<div class="post-image">
								<img src="../assets/news1.jpg" width="90" height="70" alt="College campus event">
							</div>
							<div class="post-data">
								<h5>Academic Year 2026-2027</h5>
								<p>Check with the registrar for current academic announcements and enrollment dates.</p>
							</div>
							<div class="cl">&nbsp;</div>
						</li>
						<li class="last">
							<div class="post-image">
								<img src="../assets/news2.jpg" width="90" height="70" alt="Student activities">
							</div>
							<div class="post-data">
								<h5>Enrollment Updates | 2026</h5>
								<p>Use the administrator tools to review student accounts, schedules, and submitted enrollment forms.</p>
							</div>
							<div class="cl">&nbsp;</div>
						</li>
					</ul>
				</div>
				<!-- /News -->
			</div>
			<div class="buttons">
				<a href="report.php" class="button"><span>View enrollment report</span></a>
			</div>
		</div>
		<!-- /Box -->
		<!-- Box -->
		<div class="box last-box">
			<h2>Programs</h2>
			<div class="entry bullet-list">
				<ul>
					  <li>CHED programs</li>
	                    <li>TESDA programs</li>
				</ul>
				<div class="post-image">
								<img src="../assets/news3.jpg" width="100" height="100" alt="Academic program information">
								<img src="../assets/news4.jpg" width="100" height="100" alt="College campus">
							</div>
			</div>
		</div>
		<!-- /Box -->
		<div class="cl">&nbsp;</div>
		</section>
	</div>
	<div><br></div>
</div>
<!-- /Main -->

<footer id="footer">
	<div class="footer-inner">
		<div class="footer-brand">
			<strong>John Paul College</strong>
			<span>Online Enrollment System</span>
		</div>
		<nav class="footer-navigation" aria-label="Footer navigation"><?php include('includes/menu2.php'); ?></nav>
		<p class="right">&copy; <?php echo date('Y'); ?> John Paul College. All rights reserved.</p>
	</div>
</footer>

</body>
</html>
