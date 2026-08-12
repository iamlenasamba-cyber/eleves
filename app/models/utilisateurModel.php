<?php

require_once dirname(__DIR__) . "/core/database.php";

function connexion(string $mail): array {
    $pdo = connexionDB();

    $sql = "SELECT u.id, u.nomComplet, u.email, u.password, r.nomrole 
            FROM utilisateurs u 
            INNER JOIN roles r ON u.idRole = r.id 
            WHERE LOWER(u.email) = LOWER(:mail)";

    $result = executeQuery($pdo, $sql, ['mail' => $mail], true);
    $pdo = null;

    return $result;
}