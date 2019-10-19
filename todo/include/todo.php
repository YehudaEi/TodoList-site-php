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
	<link rel="icon" href="assest/logo.png" type="image/png">

	<link rel="stylesheet" href="assest/css/uikit-rtl.min.css" />
	<script src="assest/js/uikit.min.js"></script>
	<script src="assest/js/uikit-icons.min.js"></script>
	<style>
		.uk-notification-message {
		            background: #80d296 !important;
		        }
	</style>
</head>

<body class="uk-background-muted uk-height-viewport" dir="rtl">
	<div class="uk-container uk-text-center">
		<img data-src="assest/logo.png" width="" alt="logo" uk-img style="height: 150px !important;">
		<h1 class="uk-heading-small uk-margin-top">רשימת מטלות</h1>
		<hr class="uk-divider-icon">
		<a class="uk-button uk-button-danger" href="?logout">התנתק</a>
		<button id="addButton" class="uk-button uk-button-primary" style="background-color: #4CAF50 !important;" href="#add-matala-modal" onclick="init(false)" uk-toggle>הוסף מטלה</button>
		<!--<button class="uk-button uk-button-primary" onclick="SaveMatalot()">שמור</button>-->
		<div class="uk-child-width-1-3@s uk-padding" uk-grid id="matalot">
			<div>
				<h4>לעשות</h4>
				<hr class="uk-divider-icon">
				<div uk-sortable="group: sortable-group" class="uk-box-shadow-small uk-padding-small" id="todo"></div>
			</div>
			<div>
				<h4>בעשיה</h4>
				<hr class="uk-divider-icon">
				<div uk-sortable="group: sortable-group" class="uk-box-shadow-small uk-padding-small" id="doing"></div>
			</div>
			<div>
				<h4>בוצע</h4>
				<hr class="uk-divider-icon">
				<div uk-sortable="group: sortable-group" class="uk-box-shadow-small uk-padding-small" id="done"></div>
			</div>
		</div>
		<div id="add-matala-modal" uk-modal>
			<div class="uk-modal-dialog">
				<button class="uk-modal-close-default" type="button" uk-close></button>
				<div class="uk-modal-header">
					<h2 class="uk-modal-title" id="addMatalaTitle">הוספת מטלה</h2>
				</div>
				<div class="uk-modal-body">
					<form>
						<fieldset class="uk-fieldset">
							<div class="uk-margin">
								<legend class="uk-legend">כותרת</legend>
								<input class="uk-input" type="text" placeholder="כותרת" id="matalaTitle">
							</div>
							<div class="uk-margin">
								<legend class="uk-legend">פירוט</legend>
								<textarea class="uk-textarea" rows="3" placeholder="פירוט" id="matalaDescription"></textarea>
							</div>
							<div class="uk-marginuk-grid-small" uk-grid>
								<legend class="uk-legend">תגיות</legend>
								<div class="uk-width-1-2@s uk-margin-small">
									<input class="uk-input" type="text" id="tagit-1" placeholder="תגית 1">
								</div>
								<div class="uk-width-1-2@s uk-margin-small">
									<div uk-form-custom="target: > * > span:first-child">
										<select id="tagit-1-select">
											<option value="">בחר...</option>
											<option value="1" selected>ירוק</option>
											<option value="2">צהוב</option>
											<option value="3">אדום</option>
											<option value="4">כחול</option>
										</select>
										<button class="uk-button uk-button-default" type="button" tabindex="-1"> <span></span>
											<span uk-icon="icon: chevron-down"></span>
										</button>
									</div>
								</div>
								<div class="uk-width-1-2@s uk-margin-small">
									<input class="uk-input" type="text" id="tagit-2" placeholder="תגית 2">
								</div>
								<div class="uk-width-1-2@s uk-margin-small">
									<div uk-form-custom="target: > * > span:first-child">
										<select id="tagit-2-select">
											<option value="">בחר...</option>
											<option value="1" selected>ירוק</option>
											<option value="2">צהוב</option>
											<option value="3">אדום</option>
											<option value="4">כחול</option>
										</select>
										<button class="uk-button uk-button-default" type="button" tabindex="-1"> <span></span>
											<span uk-icon="icon: chevron-down"></span>
										</button>
									</div>
								</div>
								<div class="uk-width-1-2@s uk-margin-small">
									<input class="uk-input" type="text" id="tagit-3" placeholder="תגית 3">
								</div>
								<div class="uk-width-1-2@s uk-margin-small">
									<div uk-form-custom="target: > * > span:first-child">
										<select id="tagit-3-select">
											<option value="">בחר...</option>
											<option value="1" selected>ירוק</option>
											<option value="2">צהוב</option>
											<option value="3">אדום</option>
											<option value="4">כחול</option>
										</select>
										<button class="uk-button uk-button-default" type="button" tabindex="-1"> <span></span>
											<span uk-icon="icon: chevron-down"></span>
										</button>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<div class="uk-modal-footer uk-text-right">
					<button id="cancelAddMatalaButton" class="uk-button uk-button-default uk-modal-close" type="button">בטל</button>
					<button id="addMatalaButton" class="uk-button uk-button-primary uk-modal-close" type="button">הוסף</button>
				</div>
			</div>
		</div>
		<div>
            <h1 class="uk-align-center"><span class="uk-text-muted uk-text-small" dir="ltr">created by <a href="https://t.me/YehudaEisenberg">Yehuda Eisenberg</a>. design by <a href="https://t.me/Mugavri">Mugavri</a>.</span></h1>
        </div>
	</div>
	<script src="assest/js/jquery.min.js"></script>
	<script src="assest/js/todo.js"></script>
</body>

</html>