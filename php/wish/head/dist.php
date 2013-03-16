<title>Make a Wish</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style/style.css"/>

<?php
    $styleSheet = "black";
    if(isset($_SESSION['user_id'])) {
        $my_id=$_SESSION['user_id'];
        $queryString="SELECT colors.name FROM users
            INNER JOIN colors ON colors.id = users.idcolor
            WHERE users.id = :my_id";
        $query = $bdd->prepare($queryString);
        $query->bindParam(':my_id', $my_id);
        $query->execute();
        if($resultat = $query->fetch(PDO::FETCH_OBJ)) {
            $styleSheet = $resultat->name;
        }
    }
?>
<link rel="stylesheet" href="style/<?php echo $styleSheet ?>.css"/>

<script type="text/javascript" src="script/jquery-1.7.2.min.js" ></script><!-- your jQuery version -->
<script type="text/javascript" src="script/boutons_cadeau.js" ></script>
<script type="text/javascript" src="script/sha512.js" ></script>
<script type="text/javascript" src="script/forms.js" ></script>
<script type="text/javascript" src="script/modal.js" ></script>