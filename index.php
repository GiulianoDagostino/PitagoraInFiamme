<?php
    require_once "connection.php";
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Inserisci Barca</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #0077b6, #00b4d8);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.1);
      padding: 30px 40px;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      width: 400px;
      backdrop-filter: blur(10px);
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      font-size: 26px;
      color: #fff;
    }

    label {
      display: block;
      margin-top: 12px;
      font-weight: bold;
      color: #fff;
    }

    input[type="text"],
    textarea,
    input[type="file"] {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: none;
      margin-top: 5px;
      font-size: 14px;
    }

    textarea {
      height: 80px;
      resize: none;
    }

    .buttons {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      margin-top: 20px;
    }

    input[type="submit"],
    a.button {
      flex: 1;
      background-color: #023e8a;
      color: white;
      text-align: center;
      border: none;
      padding: 12px;
      font-size: 16px;
      border-radius: 10px;
      text-decoration: none;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    input[type="submit"]:hover,
    a.button:hover {
      background-color: #0077b6;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Inserisci una nuova barca</h2>
    <form action="form.php" method="post" enctype="multipart/form-data">
      
      <label>Marca:</label>
      <input type="text" name="marca" required>

      <label>Modello:</label>
      <input type="text" name="modello" required>

      <label>Lunghezza:</label>
      <input type="text" name="lunghezza" required>

      <label>Omologazione:</label>
      <input type="text" name="omologazione">

      <label>Motore:</label>
      <input type="text" name="motore">

      <label>Carburante:</label>
<label><input type="radio" name="carburante" value="Benzina" required> Benzina</label>
<label><input type="radio" name="carburante" value="Diesel"> Diesel</label>
<label><input type="radio" name="carburante" value="Elettrico"> Elettrico</label>


      <label>Propulsione:</label>
      <input type="text" name="propulsione">

      <label>Descrizione:</label>
      <textarea name="descrizione"></textarea>

    <label>Anno:</label>
      <input type="number" name="anno"></input>

      <label>Foto:</label>
      <input type="file" name="foto" accept="image/*" required>

      <label>Video:</label>
      <input type="file" name="video" accept="video/*" required>

      <div class="buttons">
        <input type="submit" value="Salva Barca">
        <a href="lista.php" class="button">Mostra Tabella</a>
      </div>
    </form>
  </div>
</body>
</html>
