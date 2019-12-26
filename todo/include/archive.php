<?php
if(!defined('TODO')) die('access denied');
?>

<!DOCTYPE html>
<html>

<head>
	<title>רשימת מטלות | דף הבית</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="רשימת מטלות - אתר יפה לרשימת מטלות!">
	<meta name="author" content="Yehuda Eisenberg">
	<meta name="robots" content="noindex, nofollow">
	<meta name="googlebot" content="noindex">
	<link rel="icon" href="assets/logo.png" type="image/png">

	<link rel="stylesheet" href="assets/css/uikit-rtl.min.css" />
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/main.js?version=<?php echo JS_VERSION ?>"></script>
	<script src="assets/js/uikit.min.js"></script>
	<script src="assets/js/uikit-icons.min.js"></script>
	<style>
		.uk-notification-message {
		            background: #80d296 !important;
		        }
	</style>
</head>

<body class="uk-background-muted uk-height-viewport" dir="rtl">
	<div class="uk-container uk-text-center">
		<img data-src="assets/logo.png" width="" alt="logo" uk-img style="height: 150px !important;">
		<h1 class="uk-heading-small uk-margin-top">רשימת מטלות</h1>
		<hr class="uk-divider-icon">
		<a class="uk-button uk-button-danger" onclick="logout(); return false;">התנתק</a>
		<a class="uk-button uk-button-primary" onclick="archiveToTodo(); return false;" >רשימת מטלות</a>
		<h4>ארכיון</h4>
		<hr class="uk-divider-icon">
		<ul class="uk-child-width-1-3@s uk-padding" uk-grid id="matalot">
		    <li>
				<div uk-sortable="group: sortable-group" class="uk-box-shadow-small uk-padding-small" id="archive1"></div>
			</li>
			<li>
				<div uk-sortable="group: sortable-group" class="uk-box-shadow-small uk-padding-small" id="archive2"></div>
			</li>
			<li>
				<div uk-sortable="group: sortable-group" class="uk-box-shadow-small uk-padding-small" id="archive3"></div>
			</li>
		</ul>
		<div>
            <h1 class="uk-align-center"><span class="uk-text-muted uk-text-small" dir="ltr">created by <a href="https://t.me/YehudaEisenberg">Yehuda Eisenberg</a>. design by <a href="https://t.me/Mugavri">Mugavri</a>.</span></h1>
        </div>
	</div>
	<script src="assets/js/archive.js?version=<?php echo JS_VERSION ?>"></script>
</body>

</html>