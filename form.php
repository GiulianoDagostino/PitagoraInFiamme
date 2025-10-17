<?php
require_once "connection.php"; // connessione al DB

// Controllo invio del form
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recupero dati testuali
    $marca = $_POST['marca'] ?? '';
    $modello = $_POST['modello'] ?? '';
    $lunghezza = $_POST['lunghezza'] ?? '';
    $omologazione = $_POST['omologazione'] ?? '';
    $motore = $_POST['motore'] ?? '';
    $carburante = $_POST['carburante'] ?? '';
    $propulsione = $_POST['propulsione'] ?? '';
    $descrizione = $_POST['descrizione'] ?? '';

    // Percorsi cartelle upload
    $fotoDir = "uploads/foto/";
    $videoDir = "uploads/video/";

    // Creazione cartelle se non esistono
    if (!is_dir($fotoDir)) mkdir($fotoDir, 0777, true);
    if (!is_dir($videoDir)) mkdir($videoDir, 0777, true);

    // Gestione FOTO
    $fotoPath = "";
    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
        $fotoNome = uniqid() . "_" . basename($_FILES["foto"]["name"]);
        $fotoPath = $fotoDir . $fotoNome;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $fotoPath);
    }

    // Gestione VIDEO
    $videoPath = "";
    if (isset($_FILES["video"]) && $_FILES["video"]["error"] === UPLOAD_ERR_OK) {
        $videoNome = uniqid() . "_" . basename($_FILES["video"]["name"]);
        $videoPath = $videoDir . $videoNome;
        move_uploaded_file($_FILES["video"]["tmp_name"], $videoPath);
    }

    // Inserimento nel database
    $sql = "INSERT INTO barche 
        (marca, modello, lunghezza, omologazione, motore, carburante, propulsione, descrizione, foto, video)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssssssssss", 
            $marca, $modello, $lunghezza, $omologazione, $motore, 
            $carburante, $propulsione, $descrizione, $fotoPath, $videoPath
        );

        if ($stmt->execute()) {
            // Messaggio di successo con tasto bello e responsive
            echo "
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background:#caf0f8; text-align:center; padding:20px; }
                .btn-back {
                    display:inline-block;
                    margin-top:20px;
                    padding:12px 25px;
                    font-size:16px;
                    font-weight:bold;
                    color:white;
                    text-decoration:none;
                    border-radius:12px;
                    background: linear-gradient(135deg, #023e8a, #0077b6);
                    transition: all 0.3s ease;
                }
                .btn-back:hover {
                    background: linear-gradient(135deg, #0077b6, #023e8a);
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                }
                @media (max-width:600px){
                    .btn-back { width:100%; font-size:14px; padding:10px; }
                }
            </style>
            <h2 style='color: green;'>✅ Barca inserita con successo!</h2>
            <a href='index.php' class='btn-back'>← Torna al modulo</a>
            ";
        } else {
            echo "<h2 style='color: red; text-align:center;'>❌ Errore durante l'inserimento.</h2>";
        }

        $stmt->close();
    } else {
        echo "<h2 style='color: red; text-align:center;'>Errore nella preparazione della query.</h2>";
    }

    $conn->close();
}
?>
