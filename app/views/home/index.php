<div id="carouselExample" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://png.pngtree.com/back_origin_pic/05/09/26/4ee0f773890484bce47880c9589014b1.jpg"
                class="d-block w-100" alt="Баннер 1">
            <div class="carousel-caption">
                <h5 class="banner-title">Название фильма</h5>
                <button class="cinema-btn">Купить билет</button>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://static.karofilm.ru/v3k/uploads/banner/resize/ba/7c/b1/574db1481b8e073afcd6b5a510.jpg"
                class="d-block w-100" alt="Баннер 2">
            <div class="carousel-caption">
                <h5 class="banner-title">Название фильма</h5>
                <button class="cinema-btn">Купить билет</button>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://images.kinomax.ru/2970/b/30/554787_3083.webp" class="d-block w-100" alt="Баннер 3">
            <div class="carousel-caption">
                <h5 class="banner-title">Название фильма</h5>
                <button class="cinema-btn">Купить билет</button>
            </div>
        </div>
    </div>
</div>

<div class="container mt-3">
    <h2 class="page-title">Сейчас в кино</h2>
    <div class="row">

        <?php foreach($movies as $movie): ?>

        <div class="col-md-2">
            <div class="card" onclick="window.location.href='/film/<?= $movie['id'] ?>'">
                <img src="<?= $movie['poster_url'] ?>" alt="Обложка фильма">
                <div class="card-info">
                    <h5 class="movie-title"><?= $movie['title'] ?></h5>
                    <p class="movie-genre"><?= $movie['genre'] ?></p>
                </div>
            </div>
        </div>
        
        <?php endforeach; ?>

    </div>
</div>