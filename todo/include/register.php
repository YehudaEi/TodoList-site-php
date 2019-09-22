<!DOCTYPE html>
<html>
    <head>
    	<title>רשימת מטלות | הרשמה</title>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<meta name="description" content="רשימת מטלות - אתר יפה לרשימת מטלות!">
    	<meta name="author" content="Yehuda Eisenberg">
    	<meta name="robots" content="noindex, nofollow">
    	<meta name="googlebot" content="noindex">
    	<link rel="icon" href="assest/logo.png" type="image/png">
    
    	<link rel="stylesheet" href="assest/css/uikit-rtl.min.css" />
    	<link rel="stylesheet" href="assest/css/style.css" />
    	<script src="assest/js/uikit.min.js"></script>
    	<script src="assest/js/uikit-icons.min.js"></script>
    </head>
    <body dir="rtl">
        <div uk-sticky="media: 960" class="uk-navbar-container tm-navbar-container uk-sticky uk-active" style="position: fixed; top: 0px; width: 1903px;">
            <div class="uk-container uk-container-expand">
                <nav uk-navbar>
                    <div class="uk-navbar">
                        <a href="/" class="uk-navbar-item uk-logo">
                            רשימת מטלות
                        </a>
                    </div>
                </nav>
            </div>
        </div>
        <div class="content-background">
            <div class="uk-section-large">
                <div class="uk-container uk-container-large">
                    <div uk-grid class="uk-child-width-1-1@s uk-child-width-2-3@l">
                        <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
                        <div class="uk-width-1-1@s uk-width-3-5@l uk-width-1-3@xl">
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-body">
                                    <center>
                                        <h2>הרשמה</h2><br />
                                    </center>
                                    <form method="POST">
                                        <fieldset class="uk-fieldset">

                                            <div class="uk-margin">
                                                <div class="uk-position-relative">
                                                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                                                    <input name="username" class="uk-input" type="text" placeholder="שם משתמש">
                                                </div>
                                            </div>

                                            <div class="uk-margin">
                                                <div class="uk-position-relative">
                                                    <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                                    <input name="password" class="uk-input" type="password" placeholder="סיסמה">
                                                </div>
                                            </div>

                                            <div class="uk-margin">
                                                <div class="uk-position-relative">
                                                    <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                                    <input name="password2" class="uk-input" type="password" placeholder="אימות סיסמה">
                                                </div>
                                            </div>

                                            <div class="uk-margin">
                                                <button type="submit" class="uk-button uk-button-primary">
                                                    <span uk-icon="icon: user"></span>&nbsp; הרשם
                                                </button>
                                            </div>

                                            <hr />
            
                                            <center>
                                                <p>
                                                    כבר יש לך חשבון?
                                                </p>
                                                <a href="?login" class="uk-button uk-button-default">
                                                    <span uk-icon="icon: sign-in"></span>&nbsp; היכנס
                                                </a>
                                            </center>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(isset($usernameExist) && $usernameExist){
            echo '<script>UIkit.notification({message: "<span uk-icon=\"icon: close\"></span> שם המשתמש קיים במערכת...", status: "danger"});</script>';
        }
        elseif(isset($invalidPasswords) && $invalidPasswords){
            echo '<script>UIkit.notification({message: "<span uk-icon=\"icon: close\"></span> הסיסמאות אינן תואמות!", status: "danger"});</script>';
        }
        ?>
    </body>
</html>