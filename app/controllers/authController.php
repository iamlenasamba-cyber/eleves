<?php

require_once dirname(__DIR__) . "/models/utilisateurModel.php";

class AuthController {

      public UtilisateurModel $utilisateurModel;

    public function __construct() {
       
        $this->utilisateurModel = new UtilisateurModel();
    }

 public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $mail = (string) $_POST['mail'];
                $password = (string) $_POST['password'];
                $connexion = $this->utilisateurModel->connexion($mail);

               if (!empty($connexion) && isset($connexion['password']) && $connexion['password'] === $password) {
                $_SESSION['user'] = [
                     'email'=> $connexion['email'],
                    'nomrole'=> $connexion['nomrole'],
                     'nomcomplet' => $connexion['nomcomplet']
                ];
                
                header('Location: http://localhost:8002/showMoyenne');
                   exit;
            } else {
                header('Location: http://localhost:8002/');
                 exit;
            }
        }
        require_once dirname(__DIR__) . "/views/accueil/connexionView.html.php";
    }
}