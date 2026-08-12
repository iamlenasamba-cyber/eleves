<?php

function connexionDB(): PDO {
    try {
        $pdo = new PDO(
            "pgsql:host=127.0.0.1;dbname=gestioneleves;port=5432",
            "lena",
            "Sokhnadiouf6"
        );

        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $pdo;
    } catch (Exception $ex) {
        die('Erreur de connexion : ' . $ex->getMessage());
    }
}


function deconnecteDB():PDO{

static $pdo = null;

if($pdo == null){

$pdo = new PDO(
        "pgsql:host=localhost;dbname=gestionDetteVente;port=5432",
        "lena",
        "Sokhnadiouf6"
    );

    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
   

}

     return $pdo;
}


function query(PDO $pdo,string $sql, bool $single = true):array{
     $query = $pdo->query($sql);
    return $single ? $query->fetch():$query->fetchAll();
    

}

function prepare(PDO $pdo,string $sql, array $datas) {
    $prepare = $pdo->prepare($sql);
    $prepare->execute($datas);
    return $prepare;
}

function executeQuery(PDO $pdo,string $sql, array $datas, bool $single = true) : array {
    $statement= prepare($pdo, $sql,  $datas);
   
    $result= $single ? $statement->fetch():$statement->fetchAll();
    return $result ?: [];
}

function executeUpdate(PDO $pdo, string $sql, array $datas) : int {
    $stmt = prepare($pdo, $sql, $datas); // Stocker dans une variable $stmt
    
    return (str_starts_with(strtoupper($sql), 'INSERT')) ? (int)$pdo->lastInsertId() : $stmt->rowCount();
}


function getAllTables (string $tableName): array{
    $pdo=connexionDB();
    $sql="SELECT * FROM $tableName";
    $result= query( $pdo,$sql,false);
    $pdo=null;
    return $result;
}