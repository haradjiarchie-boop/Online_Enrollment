<?php
require_once __DIR__ . '/includes/conn.php';
require_once __DIR__ . '/logcheck.php';

$users = $conn->query('SELECT ID, studnum, fname, minitial, lname, yearlvl, course FROM studenttbl ORDER BY lname, fname');
$notice = isset($_SESSION['flash_success']) ? $_SESSION['flash_success'] : '';
$error = isset($_SESSION['flash_error']) ? $_SESSION['flash_error'] : '';
unset($_SESSION['flash_success'], $_SESSION['flash_error']);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Manage Users | John Paul College</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include __DIR__ . '/../includes/portal_topbar.php'; ?>
<nav class="container" aria-label="Administrator navigation"><?php include __DIR__ . '/includes/menu1.php'; ?></nav>
<main id="main">
	<div class="shell">
		<div class="page-heading">
			<div>
				<p class="eyebrow">Student Records</p>
				<h1>Manage Students</h1>
				<p class="page-subtitle">Search, filter, and manage registered student accounts.</p>
			</div>
			<div class="actions">
				<a class="button" href="adminedit.php" title="Edit administrator account">Administrator account</a>
				<a class="button" href="addnewuser.php"><svg aria-hidden="true" viewBox="0 0 24 24" width="18" height="18"><path d="M12 5v14M5 12h14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg> Add student</a>
			</div>
		</div>
		<?php if ($notice !== '') { ?><p class="form-success" role="status"><?php echo app_h($notice); ?></p><?php } ?>
		<?php if ($error !== '') { ?><p class="form-error" role="alert"><?php echo app_h($error); ?></p><?php } ?>
		<div class="catalog-filters student-filters" aria-label="Student filters">
			<label for="studentSearch">Search students
				<input id="studentSearch" type="search" placeholder="Name or student ID" autocomplete="off">
			</label>
			<label for="courseFilter">Course
				<select id="courseFilter"><option value="">All courses</option></select>
			</label>
			<label for="yearFilter">Year level
				<select id="yearFilter"><option value="">All year levels</option></select>
			</label>
			<button id="clearStudentFilters" class="button button-secondary" type="button">Clear filters</button>
		</div>
		<p id="studentResultCount" class="catalog-result-count" role="status"></p>
		<div class="table-wrap">
			<table>
				<thead><tr><th scope="col">Student ID</th><th scope="col">Student Name</th><th scope="col">Course</th><th scope="col">Year Level</th><th scope="col">Actions</th></tr></thead>
				<tbody>
				<?php if ($users->num_rows === 0) { ?><tr><td colspan="5">No students are registered yet.</td></tr><?php } ?>
				<?php while ($user = $users->fetch_assoc()) { ?>
					<tr class="student-row"
						data-search="<?php echo app_h(strtolower(trim($user['studnum'] . ' ' . $user['fname'] . ' ' . $user['minitial'] . ' ' . $user['lname']))); ?>"
						data-course="<?php echo app_h(strtolower($user['course'])); ?>"
						data-year="<?php echo app_h(strtolower($user['yearlvl'])); ?>">
						<td><?php echo app_h($user['studnum']); ?></td>
						<td><?php echo app_h(trim($user['fname'] . ' ' . $user['minitial'] . ' ' . $user['lname'])); ?></td>
						<td><?php echo app_h(strtoupper($user['course'])); ?></td>
						<td><?php echo app_h($user['yearlvl']); ?></td>
						<td>
							<form method="post" action="deletecurruser.php" class="inline-form" onsubmit="return confirm('Delete this student account? All of their enrollment forms, payments and documents are deleted with it (the database cascade). This cannot be undone.');">
								<input type="hidden" name="csrf_token" value="<?php echo app_h(app_csrf_token()); ?>">
								<input type="hidden" name="student_id" value="<?php echo (int)$user['ID']; ?>">
								<button class="button button-danger" type="submit">Delete</button>
							</form>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</main>
<footer id="footer">
	<div class="footer-inner">
		<div class="footer-brand">
			<strong>John Paul College</strong>
			<span>Online Enrollment System</span>
		</div>
		<nav class="footer-navigation" aria-label="Footer navigation"><?php include __DIR__ . '/includes/menu2.php'; ?></nav>
		<p class="right">&copy; <?php echo date('Y'); ?> John Paul College. All rights reserved.</p>
	</div>
</footer>
<script>
(function () {
	const search = document.getElementById('studentSearch');
	const course = document.getElementById('courseFilter');
	const year = document.getElementById('yearFilter');
	const clear = document.getElementById('clearStudentFilters');
	const count = document.getElementById('studentResultCount');
	const rows = Array.from(document.querySelectorAll('.student-row'));

	function addOptions(select, values) {
		Array.from(values).sort((a, b) => a.localeCompare(b)).forEach(value => {
			const option = document.createElement('option');
			option.value = value;
			option.textContent = value.toUpperCase();
			select.appendChild(option);
		});
	}

	addOptions(course, new Set(rows.map(row => row.dataset.course).filter(Boolean)));
	addOptions(year, new Set(rows.map(row => row.dataset.year).filter(Boolean)));

	function filterStudents() {
		const query = search.value.trim().toLowerCase();
		let visible = 0;
		rows.forEach(row => {
			const matchesSearch = !query || row.dataset.search.includes(query);
			const matchesCourse = !course.value || row.dataset.course === course.value;
			const matchesYear = !year.value || row.dataset.year === year.value;
			const show = matchesSearch && matchesCourse && matchesYear;
			row.hidden = !show;
			if (show) visible++;
		});
		count.textContent = visible === 1 ? '1 student found' : visible + ' students found';
	}

	search.addEventListener('input', filterStudents);
	course.addEventListener('change', filterStudents);
	year.addEventListener('change', filterStudents);
	clear.addEventListener('click', () => {
		search.value = '';
		course.value = '';
		year.value = '';
		filterStudents();
		search.focus();
	});
	filterStudents();
})();
</script>
</body>
</html>
