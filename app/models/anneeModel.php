

<?php
require_once dirname(__DIR__). "/core/database.php";


function getAnnee( ){
    $pdo=connexionDB();
     
            $sql="SELECT * FROM anneeAcademiques WHERE actif=1";
        $result=query($pdo,$sql);
            // var_dump($result);
            // die;
    $pdo=null;
    return $result;
}