<title>Make a Wish</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="style/style.css"/>

<?php
$styleSheet = "black";
if (isset($_SESSION['user_id'])) {
    $current_user = currentUser();
    $styleSheet = $current_user->color->name;
}
?>
<link rel="stylesheet" href="style/<?php echo $styleSheet ?>.css"/>
<!-- Add IntroJs styles -->
<link href="style/introjs.css" rel="stylesheet">
<!--[if lte IE 8]>
<link href="style/introjs-ie.css" rel="stylesheet">
<!-- <![endif]-->

<script type="text/javascript" src="script/jquery-1.7.2.min.js"></script><!-- your jQuery version -->
<script type="text/javascript" src="script/maw.js"></script>
<script type="text/javascript" src="script/sha512.js"></script>
<script type="text/javascript" src="script/forms.js"></script>
<script type="text/javascript" src="script/modal.js"></script>
<script type="text/javascript" src="script/intro.js"></script>