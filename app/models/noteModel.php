<?php
require_once dirname(__DIR__) . "/core/database.php";

class NoteModel {
    public Database $db;

    public function __construct() {
        $this->db = new Database();
    }

 
    public function getMoyenne(int $idclasse, int $idMatiere, int $idPeriode, int $actif = 1): array {
        $pdo = $this->db->connexionDB();

        $sql = "SELECT COALESCE(ROUND(AVG(moyenne_general),2),0) as moyenne
                FROM (
                    SELECT n.idMatiere, n.idPeriode, i.idAnnee, i.idClasse,
                           AVG((COALESCE(n.devoir1,0) + COALESCE(n.devoir2,0) + 2 * COALESCE(n.composition,0)) / 4) AS moyenne_general
                    FROM notes n
                     INNER JOIN inscription i ON n.idEleve = i.idEleve
                    GROUP BY n.idMatiere, n.idPeriode, i.idAnnee, i.idClasse
                ) t 
          INNER JOIN anneeAcademiques a ON t.idAnnee = a.id 
                   INNER JOIN classes c ON t.idClasse = c.id
              WHERE t.idMatiere = :idMatiere 
                  AND t.idPeriode = :idPeriode 
                AND a.actif = :actif 
                  AND t.idClasse = :idclasse;";

        $result = $this->db->executeQuery($pdo, $sql, [
              'idMatiere' => $idMatiere,
             'idPeriode' => $idPeriode,
              'actif'     => $actif,
             'idclasse'  => $idclasse
        ]);

        $pdo = null; 
        return $result;
    }

   
    public function getListe(int $idclasse, int $idMatiere, int $idPeriode): array {
        $pdo = $this->db->connexionDB();

        $sql = "SELECT  n.id, 
                 i.id AS inscription_id, 
                 e.id AS eleve_id, 
                   e.nom, 
                e.prenom,
                  e.matricule,
                     COALESCE(n.devoir1, 0) AS devoir1,
                      COALESCE(n.devoir2, 0) AS devoir2,
                     COALESCE(n.composition, 0) AS composition,
                     ROUND((COALESCE(n.devoir1, 0) + COALESCE(n.devoir2, 0) + 2 * COALESCE(n.composition, 0)) / 4.0, 2) AS moyenne_eleve,
                    CASE 
                        WHEN ROUND((COALESCE(n.devoir1, 0) + COALESCE(n.devoir2, 0) + 2 * COALESCE(n.composition, 0)) / 4.0, 2) < 10 THEN 'Insuffisant'
                         WHEN ROUND((COALESCE(n.devoir1, 0) + COALESCE(n.devoir2, 0) + 2 * COALESCE(n.composition, 0)) / 4.0, 2) <= 12 THEN 'Passable'
                        WHEN ROUND((COALESCE(n.devoir1, 0) + COALESCE(n.devoir2, 0) + 2 * COALESCE(n.composition, 0)) / 4.0, 2) <= 14 THEN 'Assez bien'
                         WHEN ROUND((COALESCE(n.devoir1, 0) + COALESCE(n.devoir2, 0) + 2 * COALESCE(n.composition, 0)) / 4.0, 2) <= 16 THEN 'Bien'
                        ELSE 'Très bien'
                    END AS appreciation
                FROM inscription i
                 INNER JOIN eleves e ON e.id = i.idEleve
                LEFT JOIN notes n ON n.idInscription = i.id AND n.idMatiere = :idMatiere AND n.idPeriode = :idPeriode
                 WHERE i.idClasse = :idclasse 
                  AND i.idAnnee = (SELECT id FROM anneeAcademiques WHERE actif = 1)
                  AND EXISTS (
                      SELECT 1 FROM matiereClasse 
                      WHERE idClasse = :idclasse AND idMatiere = :idMatiere
                  )
                ORDER BY e.nom, e.prenom;";

        $result = $this->db->executeQuery($pdo, $sql, [
              'idclasse'  => $idclasse,
             'idMatiere' => $idMatiere,
             'idPeriode' => $idPeriode
        ], false);

        $pdo = null; 
        return $result;
    }
}