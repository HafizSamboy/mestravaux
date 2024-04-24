<?php
session_start(); // Démarrer la session

// Vérifie si toutes les données du formulaire sont présentes
if(isset($_POST['email'], $_POST['mot_de_passe'], $_POST['id_evenement'], $_POST['feedback'], $_POST['rating'])) {
    // Vérifie les identifiants de l'utilisateur (vous devez remplacer cette partie par votre logique de vérification)
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Connectez-vous à la base de données (à adapter selon votre environnement)
    $conn = new mysqli("localhost", "root", "", "gestion_evenement");

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Préparation de la requête SQL pour vérifier les identifiants de l'utilisateur
    $stmt = $conn->prepare("SELECT id_utilisateur FROM utilisateurs WHERE email = ? AND mot_de_passe = ?");
    $stmt->bind_param("ss", $email, $mot_de_passe);

    // Exécution de la requête
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérification si l'utilisateur existe dans la base de données
    if ($result->num_rows > 0) {
        // L'utilisateur est authentifié, on peut insérer le feedback dans la base de données

        // Récupérer les données du formulaire
        $id_evenement = $_POST['id_evenement'];
        $commentaire = $_POST['feedback'];
        $note = $_POST['rating'];

        // Préparation de la requête SQL pour insérer le feedback
        $stmt_insert = $conn->prepare("INSERT INTO evaluations (id_utilisateur, id_evenement, commentaire, note) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("iisi", $id_utilisateur, $id_evenement, $commentaire, $note);

        // Exécution de la requête d'insertion
        if ($stmt_insert->execute()) {
            echo "Évaluation enregistrée avec succès.";
        } else {
            echo "Erreur lors de l'insertion du feedback: " . $conn->error;
        }

        // Fermeture de la connexion
        $stmt_insert->close();
    } else {
        // L'utilisateur n'existe pas ou les identifiants sont incorrects
        echo "Identifiants incorrects.";
        // Redirection vers la page de connexion
        header("Location: login.html");
    }

    // Fermeture de la connexion
    $stmt->close();
    $conn->close();
} else {
    // Les données du formulaire sont incomplètes
    echo "Tous les champs du formulaire doivent être remplis. Veuillez réessayer svp...";
}
?>
