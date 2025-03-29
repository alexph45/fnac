
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="fnac.png" type="image/png">
    <title>Fnac front</title>
  </head>
  <body>
  <h1>Fnac: recherche dans le catalogue</h1>
<?php

require 'sqlconnect.php';

$str = $_REQUEST["carac"];
$selection =$_REQUEST["choix"];


if($_REQUEST["choix"] == "Titre"){
    $sql = "SELECT * FROM books WHERE title LIKE '%" . $str . "%'";
    $table = $connection->query($sql);
    $count = $table->rowCount();
    echo '<h4>Nombre d\'éléments trouvés : ' . $count . '</h4><br>';
while($ligne = $table->fetch()) {
    
    echo "<p class=gras>Titre = ".$ligne['title']."</p></br>";
    echo "<p>Auteur = ".$ligne['author']."</p></br>";
    echo "<p>ISBN = ".$ligne['isbn']."</p></br>";
    echo "<p>Prix = ".$ligne['price']."</p></br>";

}
}
elseif ($_REQUEST["choix"] == "ISBN") {
    $sql = "SELECT * FROM books WHERE ISBN LIKE '%". $str . "%'";
    $table = $connection->query($sql);
    $count = $table->rowCount();
    echo '<h4>Nombre d\'éléments trouvés : ' . $count . '</h4><br>';
while($ligne = $table->fetch()) {
   
    echo "<p>Titre = ".$ligne['title']."</p></br>";
    echo "<p>Auteur = ".$ligne['author']."</p></br>";
    echo "<p class=gras>ISBN = ".$ligne['isbn']."</p></br>";
    echo "<p>Prix = ".$ligne['price']."</p></br>";
}
}
elseif ($_REQUEST["choix"] == "Auteur") {
    $sql = "SELECT * FROM books WHERE author LIKE '%". $str . "%'";
    $table = $connection->query($sql);
    $count = $table->rowCount();
    echo '<h4>Nombre d\'éléments trouvés : ' . $count . '</h4><br>';
while($ligne = $table->fetch()) {
    
    echo "<p>Titre = ".$ligne['title']."</p></br>";
    echo "<p class=gras>Auteur = ".$ligne['author']."</p></br>";
    echo "<p>ISBN = ".$ligne['isbn']."</p></br>";
    echo "<p>Prix = ".$ligne['price']."</p></br>";
}
}
$table->closeCursor();

?>
</body>

