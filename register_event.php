<?php
session_start(); // Démarrer la session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si toutes les données du formulaire sont présentes
    if(isset($_POST['email']) && isset($_POST['mot_de_passe']) && isset($_POST['id_evenement']) && isset($_POST['nombre_billets'])) {
        // Connexion à la base de données et autres validations
        $conn = new mysqli("localhost", "root", "", "gestion_evenement");

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Récupérer les données du formulaire
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];
        $id_evenement = $_POST['id_evenement'];
        $nombre_billets = $_POST['nombre_billets'];

        // Vérification des informations d'identification de l'utilisateur
        // (À remplacer par la logique de vérification appropriée)
        $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE email=? AND mot_de_passe=?");
        $stmt->bind_param("ss", $email, $mot_de_passe);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $id_utilisateur = $row['id'];

            // Préparation de la requête SQL
            $stmt = $conn->prepare("INSERT INTO inscriptions (id_utilisateur, id_evenement, nombre_billets) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $id_utilisateur, $id_evenement, $nombre_billets);

            // Exécution de la requête
            if ($stmt->execute()) {
                echo "Inscription réussie.";
            } else {
                echo "Erreur: " . $conn->error;
            }

            // Fermeture de la connexion
            $stmt->close();
        } else {
            echo "Adresse email ou mot de passe incorrect.";
        }

        $conn->close();
    } else {
        echo "Tous les champs du formulaire doivent être remplis. Veuillez réessayer svp...";
    }
} else {
    echo "Vous devez soumettre le formulaire.";
}
?>
