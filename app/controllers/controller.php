<?php

 require_once dirname(__DIR__) . "/models/noteModel.php";
require_once dirname(__DIR__) . "/models/anneeModel.php";

class Controller {
    public NoteModel $noteModel;
     public AnneeModel $anneeModel;

 public function __construct() {
         $this->noteModel = new NoteModel();
        $this->anneeModel = new AnneeModel();
  }

    public function saveNote(): void {
        $moyenne = ['moyenne' => 0];
        $notes = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idclasse  = (int) $_POST['idClasse'];
             $idMatiere = (int) $_POST['idMatiere'];
            $idPeriode = (int) $_POST['idPeriode'];

             $moyenne = $this->noteModel->getMoyenne($idclasse, $idMatiere, $idPeriode);
            $notes   = $this->noteModel->getListe($idclasse, $idMatiere, $idPeriode);
        }

 
         $classes  = $this->noteModel->db->getAllTables('classes');
        $matieres = $this->noteModel->db->getAllTables('matieres');
         $periodes = $this->noteModel->db->getAllTables('periodes');

        $actif = $this->anneeModel->getAnnee();

             require_once dirname(__DIR__) . "/views/accueil/view.html.php";
    }
}