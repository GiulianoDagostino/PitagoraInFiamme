<?php
require_once "connection.php";

// Recupera tutte le barche
$query = "SELECT * FROM barche ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Lista Barche</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #caf0f8;
      margin: 0;
      padding: 20px;
      color: #03045e;
    }

    h1 {
      text-align: center;
      margin-bottom: 15px;
      font-size: 22px;
    }

    .table-container {
      overflow-x: auto; /* scroll orizzontale su mobile */
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      font-size: 13px;
    }

    th, td {
      padding: 8px 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #00b4d8;
      color: white;
    }

    tr:hover {
      background-color: #e0f7fa;
    }

    img {
      width: 80px;
      border-radius: 8px;
    }

    a.video-link {
      color: #0077b6;
      text-decoration: none;
      font-weight: bold;
    }

    a.video-link:hover {
      text-decoration: underline;
    }

    /* Pulsante torna al modulo moderno e responsive */
    .back {
      display: inline-block;
      margin: 20px auto;
      text-align: center;
      background: linear-gradient(135deg, #023e8a, #0077b6);
      color: white;
      padding: 12px 20px;
      border-radius: 12px;
      text-decoration: none;
      font-size: 16px;
      font-weight: bold;
      transition: all 0.3s ease;
    }

    .back:hover {
      background: linear-gradient(135deg, #0077b6, #023e8a);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    /* Responsive per mobile */
    @media (max-width: 600px) {
      body {
        padding: 10px;
      }

      h1 {
        font-size: 20px;
      }

      th, td {
        padding: 6px 8px;
        font-size: 12px;
      }

      img {
        width: 60px;
      }

      .back {
        width: 100%;
        font-size: 14px;
        padding: 10px;
      }
    }
  </style>
</head>
<body>
  <h1>Elenco delle Barche</h1>

  <?php if ($result && $result->num_rows > 0): ?>
    <div class="table-container">
      <table>
        <tr>
          <th>ID</th>
          <th>Marca</th>
          <th>Modello</th>
          <th>Lunghezza</th>
          <th>Motore</th>
          <th>Carburante</th>
          <th>Descrizione</th>
          <th>Foto</th>
          <th>Video</th>
          <th>Elimina</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['marca']) ?></td>
          <td><?= htmlspecialchars($row['modello']) ?></td>
          <td><?= htmlspecialchars($row['lunghezza']) ?></td>
          <td><?= htmlspecialchars($row['motore']) ?></td>
          <td><?= htmlspecialchars($row['carburante']) ?></td>
          <td><?= htmlspecialchars($row['descrizione']) ?></td>
          <td>
            <?php if (!empty($row['foto'])): ?>
              <img src="<?= htmlspecialchars($row['foto']) ?>" alt="Foto Barca">
            <?php endif; ?>
          </td>
          <td>
            <?php if (!empty($row['video'])): ?>
              <a href="<?= htmlspecialchars($row['video']) ?>" target="_blank" class="video-link">Guarda video</a>
            <?php endif; ?>
          </td>
          <td>
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Sei sicuro di voler eliminare questa barca?');" style="color:red;">Elimina</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </table>
    </div>
  <?php else: ?>
    <p style="text-align:center;">Nessuna barca trovata nel database.</p>
  <?php endif; ?>

  <a href="index.php" class="back">← Torna al modulo</a>

</body>
</html>

<?php
$conn->close();
?>
