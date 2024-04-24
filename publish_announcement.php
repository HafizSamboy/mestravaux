<?php
session_start(); // Démarrer la session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si toutes les données du formulaire sont présentes
    if(isset($_POST['email']) && isset($_POST['mot_de_passe']) && isset($_POST['titre']) && isset($_POST['contenu'])) {
        // Connexion à la base de données et autres validations
        $conn = new mysqli("localhost", "root", "", "gestion_evenement");

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Récupérer les données du formulaire
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];

        // Vérification des informations d'identification de l'utilisateur
        // (À remplacer par la logique de vérification appropriée)
        $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE email=? AND mot_de_passe=?");
        $stmt->bind_param("ss", $email, $mot_de_passe);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 1) {
            // Récupérer l'ID de l'utilisateur
            $row = $result->fetch_assoc();
            $id_utilisateur = $row['id'];

            // Préparation de la requête SQL
            $stmt = $conn->prepare("INSERT INTO annonces (id, titre, contenu) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $id, $titre, $contenu);

            // Exécution de la requête
            if ($stmt->execute()) {
                echo "Annonce publiée avec succès.";
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
