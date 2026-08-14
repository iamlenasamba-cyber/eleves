<?php
class Database {
public function connexionDB(): PDO {
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


 public function deconnecteDB():PDO{

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


 public function query(PDO $pdo,string $sql, bool $single = true):array{
     $query = $pdo->query($sql);
   $result = $single ? $query->fetch() : $query->fetchAll();
return $result ?: [];
    

}

public function prepare(PDO $pdo,string $sql, array $datas) {
    $prepare = $pdo->prepare($sql);
    $prepare->execute($datas);
    return $prepare;
}

public function executeQuery(PDO $pdo,string $sql, array $datas, bool $single = true) : array {
   $statement = $this->prepare($pdo, $sql, $datas);
   
    $result= $single ? $statement->fetch():$statement->fetchAll();
    return $result ?: [];
}

public function executeUpdate(PDO $pdo, string $sql, array $datas) : int {
    $stmt = $this->prepare($pdo, $sql, $datas);
    
    return (str_starts_with(strtoupper($sql), 'INSERT')) ? (int)$pdo->lastInsertId() : $stmt->rowCount();
}


public function getAllTables(string $tableName): array {
    $pdo = $this->connexionDB();
    $sql = "SELECT * FROM $tableName";
    $result = $this->query($pdo, $sql, false); 
    $pdo = null;
    return $result;
}

}