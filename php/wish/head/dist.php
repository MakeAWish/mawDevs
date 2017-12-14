<title>Make a Wish</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="style/style.css"/>

<?php
$styleSheet = "black";
if (isset($_SESSION['user_id'])) {
    $current_user = maw_currentUser();
    $styleSheet = $current_user->color->name;
}
?>
<link rel="stylesheet" href="style/<?php echo $styleSheet ?>.css"/>
<link href="style/introjs.css" rel="stylesheet">
<!--[if lte IE 8]>
<link href="style/introjs-ie.css" rel="stylesheet">
<!-- <![endif]-->

<script src="script/jquery-1.7.2.min.js"></script>
<script src="script/maw.js"></script>
<script src="script/sha512.js"></script>
<script src="script/forms.js"></script>
<script src="script/modal.js"></script>
<script src="script/intro.js"></script>
<script src="script/tinymce/tinymce.min.js"></script>