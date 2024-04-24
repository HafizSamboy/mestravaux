<?php
session_start(); // Démarrer la session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si toutes les données du formulaire sont présentes
    if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['telephone']) && isset($_POST['mot_de_passe'])) {
        // Connexion à la base de données et autres validations

            $conn = new mysqli("localhost", "root", "", "gestion_evenement");

            // Vérification de la connexion
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Récupérer les données du formulaire
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];
            $mot_de_passe = $_POST['mot_de_passe'];

            // Préparation de la requête SQL
            $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, email, telephone, mot_de_passe) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nom, $prenom, $email, $telephone, $mot_de_passe);

            // Exécution de la requête
            if ($stmt->execute()) {
                echo "Compte créé avec succès.";
            } else {
                echo "Erreur: " . $conn->error;
            }

            // Fermeture de la connexion
            $stmt->close();
            $conn->close();
    } else {
        echo "Tous les champs du formulaire doivent être remplis. Veuillez réessayer svp...";
    }
}
?>
