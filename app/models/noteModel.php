<?php
require_once dirname(__DIR__). "/core/database.php";


function getMoyenne( int $idclasse,int $idMatiere,int $idPeriode,int $actif=1){
    $pdo=connexionDB();
     
            $sql="SELECT COALESCE(ROUND(AVG(moyenne_general),2),0) as moyenne
            FROM (
            SELECT n.idMatiere, n.idPeriode, i.idAnnee,i.idClasse,
                AVG((COALESCE(n.devoir1,0)+COALESCE(n.devoir2,0)+2*COALESCE(n.composition,0))/4) AS moyenne_general
            FROM notes n
            INNER JOIN inscription i ON n.idEleve = i.idEleve
            GROUP BY n.idMatiere, n.idPeriode, i.idAnnee,i.idClasse
            ) t INNER JOIN anneeAcademiques a ON t.idAnnee=a.id INNER JOIN classes c ON  t.idClasse= c.id
            WHERE t.idMatiere=:idMatiere AND t.idPeriode=:idPeriode AND a.actif=:actif AND t.idClasse=:idclasse;
            ";
        $result=executeQuery($pdo,$sql,['idMatiere'=>$idMatiere,'idPeriode'=>$idPeriode,'actif'=>$actif,'idclasse'=>$idclasse]);
            // var_dump($result);
            // die;
    $pdo=null;
    return $result;
}