<?php
require_once "connection.php";

// Recupero tutte le barche dal DB
$query = "SELECT * FROM barche ORDER BY id DESC";
$result = $conn->query($query);
$boats = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $boats[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamDay - Catalogo Barche</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .navbar { background: rgba(23,37,84,0.9); backdrop-filter: blur(10px); }
        .card { transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; }
        .card:hover { transform: translateY(-8px); box-shadow: 0 10px 25px rgba(0,0,0,0.25); }
        .boat-details { display: none; }
        .boat-details.active { display: block; }
        .dropdown-anim { transform: translateY(-10px); opacity: 0; transition: all 0.3s ease; }
        .dropdown-anim.show { transform: translateY(0); opacity: 1; }
    </style>
</head>
<body class="text-gray-800">

<!-- Navbar -->
<nav class="navbar fixed w-full py-4 px-4 sm:px-6 flex justify-between items-center z-50">
    <div class="text-xl sm:text-2xl font-bold text-white">DreamDay</div>
    <div class="relative">
        <button id="dropdown-toggle" class="flex items-center text-white hover:text-blue-300 focus:outline-none">
            <span class="mr-2">Menu</span>
            <svg class="w-5 h-5 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div id="dropdown-menu" class="absolute right-0 mt-2 w-40 bg-blue-900 text-white rounded-lg shadow-lg hidden flex-col dropdown-anim">
            <a href="pagina principale finale.html" class="block px-4 py-2 hover:bg-blue-700 rounded-t-lg">Home</a>
            <a href="pagina barca.html" class="block px-4 py-2 hover:bg-blue-700">Barche</a>
            <a href="messaggistica.html" class="block px-4 py-2 hover:bg-blue-700">Contattaci</a>
            <a href="pagina principale finale.html#about" class="block px-4 py-2 hover:bg-blue-700 rounded-b-lg">Chi Siamo</a>
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero-bg relative flex flex-col items-center justify-center h-64 sm:h-72 bg-gradient-to-b from-blue-900 to-blue-700 text-white">
    <h1 class="text-3xl sm:text-5xl font-extrabold">Catalogo Completo Barche</h1>
    <p class="mt-2 sm:mt-4 text-lg sm:text-xl">Sfoglia tutte le imbarcazioni disponibili</p>
</section>

<!-- Griglia catalogo -->
<section class="py-8 px-4 sm:px-6">
    <div id="catalog-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
        <?php foreach($boats as $i => $b): ?>
        <div class="card bg-white rounded-lg shadow-lg overflow-hidden" onclick="window.location.href='pagina-barca.php?id=<?= $b['id'] ?>'">
            <img src="<?= htmlspecialchars($b['foto']) ?>" alt="<?= htmlspecialchars($b['marca'] . ' ' . $b['modello']) ?>" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-xl font-semibold text-blue-900"><?= htmlspecialchars($b['marca'] . ' ' . $b['modello']) ?></h3>
                <p class="text-gray-600 mt-1 text-sm">Lunghezza: <?= htmlspecialchars($b['lunghezza']) ?> | Motore: <?= htmlspecialchars($b['motore']) ?></p>
                <p class="text-blue-600 font-bold mt-2 text-base">Carburante: <?= htmlspecialchars($b['carburante']) ?></p>
                <button onclick="event.stopPropagation(); toggleDetails(<?= $i ?>)" class="mt-2 bg-blue-600 text-white py-1 px-3 rounded hover:bg-blue-700 text-sm">Dettagli</button>
                <div id="details-<?= $i ?>" class="boat-details mt-2 bg-blue-50 p-2 rounded text-sm">
                    <ul class="list-disc pl-5 text-gray-700">
                        <li>Propulsione: <?= htmlspecialchars($b['propulsione']) ?></li>
                        <li>Anno: <?= htmlspecialchars($b['anno']) ?></li>
                        <li>Capacità stimata: <?= htmlspecialchars($b['lunghezza']) ?> persone</li>
                    </ul>
                    <button onclick="event.stopPropagation(); toggleDetails(<?= $i ?>)" class="mt-1 text-blue-600 underline text-sm">Chiudi</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Footer -->
<footer class="bg-blue-900 text-white py-6 px-4 text-center mt-12">
    <p class="text-base">&copy; 2025 DreamDay. Tutti i diritti riservati.</p>
</footer>

<script>
function toggleDetails(i) {
    document.getElementById(`details-${i}`).classList.toggle('active');
}

// Dropdown Navbar
const dropdownToggle = document.getElementById('dropdown-toggle');
const dropdownMenu = document.getElementById('dropdown-menu');
const dropdownIcon = dropdownToggle.querySelector('svg');

dropdownToggle.addEventListener('click', () => {
    const hidden = dropdownMenu.classList.contains('hidden');
    dropdownMenu.classList.toggle('hidden');
    dropdownIcon.classList.toggle('rotate-180');
    if(hidden) setTimeout(()=>dropdownMenu.classList.add('show'), 10);
    else dropdownMenu.classList.remove('show');
});

document.addEventListener('click', e => {
    if(!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)){
        dropdownMenu.classList.add('hidden');
        dropdownMenu.classList.remove('show');
        dropdownIcon.classList.remove('rotate-180');
    }
});
</script>

</body>
</html>
<?php $conn->close(); ?>
