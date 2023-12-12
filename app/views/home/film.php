<?php $now = new DateTime() ?>

<div class="container">
    <div class="movie-info">
        <div class="movie-poster">
            <img src="<?= $movie['poster_url'] ?>" alt="Постер фильма">
        </div>
        <div class="movie-details">
            <h1 class="movie-title"><?= $movie['title'] ?></h1>
            <div class="movie-properties">
                <div class="movie-details-item">
                    <span class="property">Жанр:</span><?= $movie['genre'] ?>
                </div>
                <div class="movie-details-item">
                    <span class="property">Год выпуска:</span><?= $movie['release_year'] ?>
                </div>
                <div class="movie-details-item">
                    <span class="property">Страна:</span><?= $movie['genre'] ?>
                </div>
                <div class="movie-details-item">
                    <span class="property">Режиссёр:</span><?= $movie['director'] ?>
                </div>
                <div class="movie-details-item">
                    <span class="property">Продолжительность:</span><?= $movie['duration'] ?> мин.
                </div>
                <div class="movie-details-item">
                    <span class="property">Ограничение:</span><?= $movie['age_rating'] ?>
                </div>
                <div class="movie-details-item">
                    <span class="property">Рейтинг:</span><?= $movie['rating'] ?>
                </div>
                <div class="movie-details-item">
                    <span class="property">Трейлер:</span><a class="movie-trailer-link" href="<?= $movie['trailer_url'] ?>">смотреть</a>
                </div>
            </div>
            <h4 class="movie-about">О фильме</h4>
            <p class="movie-description">
                <?= $movie['description'] ?>
            </p>
        </div>
        </div>
        <div id="date-selector">
            <h3>Выберите сеанс</h3>
            <h4><?= $date ?></h4>
            <input id="session-date" type="date" id="date" name="date" onchange="updateSessions()">
        </div>

        <div id="hall-cantainer">

            <?php if (empty($sessions)) echo "<p>Нет доступных сеансов</p>"; ?>

            <?php foreach($sessions as $hallNumber => $hallData): ?>

            <div class="hall">
                <div class="hall-info">
                    <span class="hall-name">Зал <?= $hallNumber ?></span>
                    <span class="hall-type"><?= $hallData['type'] ?></span>
                </div>
                <div class="session-container">

                    <?php foreach($hallData['sessions'] as $session): ?>

                    <? 
                        $sessionDate = $date . ' ' . $session['time'];
                        if (new DateTime($sessionDate) < $now):    
                    ?>
                    <a class="disabled"><button class="session-picker"><?= $session['time'] ?></button></a>
                    <? else: ?>
                    <a href="/booking/<?= $session['id'] ?>"><button class="session-picker"><?= $session['time'] ?></button></a>
                    <? endif ?>

                    <?php endforeach ?>

                </div>
            </div>

            <?php endforeach ?>

        </div>
    </div>
</div>