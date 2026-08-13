<?php

require_once dirname(__DIR__) . "/models/noteModel.php";
require_once dirname(__DIR__) . "/models/anneeModel.php";

function saveNote(): void {


   
  
    if($_SERVER['REQUEST_METHOD']=='POST'){
       
         $idclasse= (int) $_POST['idClasse'];
          
         $idMatiere= (int)$_POST['idMatiere'];
         $idPeriode=(int) $_POST['idPeriode'];
        
       
       $moyenne = getMoyenne($idclasse, $idMatiere, $idPeriode);
        $notes   = getListe($idclasse, $idMatiere, $idPeriode);
        
    }
   
    $classes=getAllTables('classes');
    $matieres=getAllTables('matieres');
    $periodes=getAllTables('periodes');
    $actif=getAnnee();
    require_once dirname(__DIR__) . "/views/accueil/view.html.php";
}