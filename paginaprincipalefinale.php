<?php
require_once "connection.php";

// Recupero le barche dal DB
$query = "SELECT * FROM barche ORDER BY id DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamDay - Esplora le tue barche</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .hero-bg { position: relative; height: 80vh; overflow: hidden; color: white; text-align: center; }
        .hero-bg video { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; filter: brightness(0.6); z-index: -1; }
        .hero-bg .content { position: relative; z-index: 2; }
        .card { transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; }
        .card:hover { transform: translateY(-10px); box-shadow: 0 10px 25px rgba(0,0,0,0.25); }
        .boat-details { display: none; }
        .boat-details.active { display: block; }
        .carousel { display: flex; overflow-x: auto; scroll-behavior: smooth; scrollbar-width: none; gap: 1rem; padding-bottom: 1rem; }
        .carousel::-webkit-scrollbar { display: none; }
        .carousel-button { background: rgba(23,37,84,0.9); color:white; padding:0.75rem; border-radius:50%; transition: background 0.3s ease; position:absolute; top:50%; transform:translateY(-50%); z-index:10; }
        .carousel-button:hover { background: rgba(37,99,235,0.9); }
        .section-divider { height: 6px; background: linear-gradient(to right,#1e3a8a,#3b82f6); border-radius:9999px; margin:4rem auto; width:80%; }
    </style>
</head>
<body class="text-gray-800">

    <!-- Hero -->
    <section id="home" class="hero-bg flex flex-col items-center justify-center">
        <video autoplay muted loop>
            <source src="test.mp4" type="video/mp4">
        </video>
        <div class="content px-4">
            <h1 class="text-4xl sm:text-6xl font-extrabold mb-4">Scopri la tua barca dei tuoi sogni</h1>
            <p class="text-lg sm:text-xl mb-6">Naviga nel lusso e trova l'imbarcazione perfetta per te.</p>
            <a href="#boats" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-full text-lg">Vedi le barche</a>
        </div>
    </section>

    <!-- Sezione barche -->
    <section id="boats" class="py-16 px-4 sm:px-6 bg-white">
        <h2 class="text-3xl font-bold text-center text-blue-900 mb-12">Le nostre barche</h2>

        <div class="relative max-w-7xl mx-auto">
            <button onclick="scrollCarousel('left')" class="carousel-button left-0 hidden sm:block">&larr;</button>
            <div id="carousel" class="carousel">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="card bg-white rounded-lg shadow-lg overflow-hidden flex-shrink-0 w-72"
                             onclick="window.location.href='pagina-barca.php?id=<?= $row['id'] ?>'">
                            <img src="<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['marca'] . ' ' . $row['modello']) ?>" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-blue-900"><?= htmlspecialchars($row['marca'] . ' ' . $row['modello']) ?></h3>
                                <p class="text-gray-600 mt-2 text-base"><?= htmlspecialchars($row['descrizione']) ?></p>
                                <button onclick="event.stopPropagation(); toggleDetails(<?= $row['id'] ?>)" 
                                        class="mt-4 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                                        Dettagli
                                </button>
                                <div id="details-<?= $row['id'] ?>" class="boat-details mt-4 bg-blue-50 p-4 rounded">
                                    <h4 class="font-semibold text-blue-900 mb-2">Dettagli Tecnici</h4>
                                    <ul class="list-disc pl-5 text-gray-700 text-sm">
                                        <li>Lunghezza: <?= htmlspecialchars($row['lunghezza']) ?></li>
                                        <li>Motore: <?= htmlspecialchars($row['motore']) ?></li>
                                        <li>Carburante: <?= htmlspecialchars($row['carburante']) ?></li>
                                        <li>Propulsione: <?= htmlspecialchars($row['propulsione']) ?></li>
                                        <li>Anno: <?= htmlspecialchars($row['anno']) ?></li>
                                    </ul>
                                    <button onclick="event.stopPropagation(); toggleDetails(<?= $row['id'] ?>)" class="mt-3 text-blue-600 underline">Chiudi</button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center text-gray-500 col-span-full">Nessuna barca disponibile al momento.</p>
                <?php endif; ?>
            </div>
            <button onclick="scrollCarousel('right')" class="carousel-button right-0 hidden sm:block">&rarr;</button>
        </div>

        <div class="text-center mt-12">
            <a href="catalogo.php" class="bg-blue-700 hover:bg-blue-800 text-white py-3 px-6 rounded-full text-lg shadow-md">Vai al catalogo completo</a>
        </div>
    </section>

    <!-- Divider -->
    <div class="section-divider"></div>

    <!-- Chi siamo -->
    <section id="about" class="about-section py-16 px-4 sm:px-6 bg-white">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="section-title text-3xl font-bold text-blue-900 mb-8">Chi Siamo</h2>
            <p class="about-text text-lg text-gray-700 max-w-2xl mx-auto leading-relaxed">
                DreamDay è una piattaforma professionale per la compravendita di barche.  
                La nostra missione è connettere i migliori costruttori e rivenditori con appassionati di mare da tutto il mondo.
            </p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white py-6 px-4 text-center">
        © 2025 Daydream <br> Riproduzione, distribuzione e utilizzo dei contenuti vietati.
        <div class="footer-links mt-4">
            <a href="privacy.html" class="text-blue-200 hover:text-white">Privacy Policy</a> | 
            <a href="termini di servizio.html" class="text-blue-200 hover:text-white">Termini di Servizio</a>
        </div>
    </footer>

<script>
function toggleDetails(id) {
    const el = document.getElementById(`details-${id}`);
    el.classList.toggle('active');
}

function scrollCarousel(direction) {
    const carousel = document.getElementById('carousel');
    const scrollAmount = 340;
    carousel.scrollLeft += direction === 'left' ? -scrollAmount : scrollAmount;
}
</script>

</body>
</html>
<?php $conn->close(); ?>
