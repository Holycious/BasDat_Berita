<?php
require '../config/db.php';

// Menghubungkan ke database MongoDB
$collection = connectMongoDB();

// Menangani filter kategori, jika ada
$category = isset($_GET['category']) ? $_GET['category'] : '';
$filter = [];
if (!empty($category)) {
    $filter['category'] = $category;
}

// Ambil berita terbaru
$newsList = $collection->find($filter, ['sort' => ['created_at' => -1]]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Berita</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css"> <!-- File CSS Eksternal -->
</head>
<body>
    <!-- Navbar -->
    <header>
        <nav class="navbar navbar-expand-lg bg-white">
            <div class="container">
                <a class="navbar-brand font-weight-bold" href="../config/index.php">BERITA NIH</a>
                <div class="d-flex align-items-center">
                    <form class="form-inline mr-3">
                        <input class="form-control" type="search" placeholder="Cari Berita" aria-label="Search">
                    </form>
                    <a class="btn btn-outline-dark" href="../admin/add.php">Login Admin</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container mt-4">
        <!-- Banner -->
        <section class="banner-welcome mb-4 text-center py-4 bg-light rounded">
            <h2>Selamat Datang di<i> BERITA NIH</i></h2>
            <p>Platform berita terpercaya untuk informasi terkini.</p>
        </section>

        <!-- Daftar Berita -->
        <section class="news-list row">
            <?php foreach ($newsList as $news): ?>
                <article class="col-md-4 mb-4">
                    <!-- Membuat kartu berita bisa diklik -->
                    <div 
                        class="card h-100 clickable-card" 
                        onclick="window.location.href='detail.php?id=<?php echo $news['_id']; ?>';"
                    >
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($news['title']); ?></h5>
                            <p class="card-text flex-grow-1">
                                <?php echo htmlspecialchars(substr($news['summary'], 0, 100)); ?>...
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <small class="text-muted"><?php echo htmlspecialchars($news['author']); ?></small>
                            <small class="text-muted"><?php echo $news['created_at']->toDateTime()->format('Y-m-d'); ?></small>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
