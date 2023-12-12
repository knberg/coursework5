<h1>Сеансы</h1>
<div class="scrollable-table-container">
    <table id="main-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Фильм</th>
                <th>Номер зала</th>
                <th>Тип зала</th>
                <th>Дата</th>
                <th>Время</th>
                <th>Стоимость</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sessions as $key => $session): ?>
            <tr>
                <td><?= $session['id'] ?></td>
                <td><?= $session['movie']['title'] ?></td>
                <td><?= $session['hall']['number'] ?></td>
                <td><?= $session['hall']['type'] ?></td>
                <td><?= $session['date'] ?></td>
                <td><?= $session['time'] ?></td>
                <td><?= $session['price'] ?></td>
                <td>
                    <button class="btn change-btn" onclick="fillForm(<?= $key ?>)">Изменить</button>
                    <button class="btn delete-btn" onclick="deleteRow(<?= $movie['id'] ?>)">Удалить</button>
                </td>
            </tr>

            <?php endforeach ?>
        </tbody>
    </table>
</div>

<h2>Изменить</h2>

<form id="updateForm" action="/tickets/1/edit" method="post">

    <label class="form-label" class="form-label" for="title">Название:</label>
    <input class="form-input" type="text" id="title" name="title" required>
    
    <label class="form-label" for="release_year">Год выпуска:</label>
    <input class="form-input" type="number" id="release_year" name="release_year" required>

    <label class="form-label" for="genre">Жанр:</label>
    <input class="form-input" list="genre_list" type="text" id="genre" name="genre" required>
    <datalist class="form-input" id="genre_list">
        <option value="мультфильм">мультфильм</option>
        <option value="драма">
        <option value="ужасы">
        <option value="триллер">
        <option value="фантастика">
        <option value="боевик">
    </datalist>

    <label class="form-label" for="director">Режиссёр:</label>
    <input class="form-input" type="number" id="director" name="director" required>

    <label class="form-label" for="description">Описание:</label>
    <textarea class="form-input" id="description" name="description" required></textarea>

    <label class="form-label" for="age_rating">Возрастное ограничение:</label>
    <select class="form-input" id="age_rating" name="age_rating">
        <option value="0+">0+</option>
        <option value="6+">6+</option>
        <option value="12+">12+</option>
        <option value="16+">16+</option>
        <option value="18+">18+</option>
    </select>

    <label class="form-label" for="duration">Длительность (мин):</label>
    <input class="form-input" type="number" id="duration" name="duration" required>

    <label class="form-label" for="rating">Рейтинг:</label>
    <input class="form-input" type="number" id="rating" name="rating" max-value="10" step="0.1">

    <label class="form-label" for="poster_url">Постер (URL):</label>
    <input class="form-input" type="url" id="poster_url" name="poster_url">

    <label class="form-label" for="trailer_url">Трейлер (URL):</label>
    <input class="form-input" type="url" id="trailer_url" name="trailer_url">

    <button class="cinema-btn" type="submit">Сохранить</button>
</form>

<h2>Создать</h2>

<form id="createForm" action="/admin/movies" method="post">

    <label class="form-label" class="form-label" for="cr_title">Название:</label>
    <input class="form-input" type="text" id="cr_title" name="title" required>
    
    <label class="form-label" for="cr_release_year">Год выпуска:</label>
    <input class="form-input" type="number" id="cr_release_year" name="release_year" required>

    <label class="form-label" for="cr_genre">Жанр:</label>
    <input class="form-input" list="cr_genre_list" type="text" id="cr_genre" name="genre" required>
    <datalist class="form-input" id="cr_genre_list">
        <option value="мультфильм">мультфильм</option>
        <option value="драма">
        <option value="ужасы">
        <option value="триллер">
        <option value="фантастика">
        <option value="боевик">
    </datalist>

    <label class="form-label" for="cr_director">Режиссёр:</label>
    <input class="form-input" type="text" id="cr_director" name="director" required>

    <label class="form-label" for="cr_description">Описание:</label>
    <textarea class="form-input" id="cr_description" name="description" required></textarea>

    <label class="form-label" for="cr_age_rating">Возрастное ограничение:</label>
    <select class="form-input" id="cr_age_rating" name="age_rating">
        <option value="0+">0+</option>
        <option value="6+">6+</option>
        <option value="12+">12+</option>
        <option value="16+">16+</option>
        <option value="18+">18+</option>
    </select>

    <label class="form-label" for="cr_duration">Длительность (мин):</label>
    <input class="form-input" type="number" id="cr_duration" name="duration" required>

    <label class="form-label" for="cr_rating">Рейтинг:</label>
    <input class="form-input" type="number" id="cr_rating" name="rating" max-value="10" step="1">

    <label class="form-label" for="cr_poster_url">Постер (URL):</label>
    <input class="form-input" type="url" id="cr_poster_url" name="poster_url">

    <label class="form-label" for="cr_trailer_url">Трейлер (URL):</label>
    <input class="form-input" type="url" id="cr_trailer_url" name="trailer_url">

    <button class="cinema-btn" type="submit">Добавить</button>
</form>

<script>

    const createForm = document.getElementById('createForm');
    const updateForm = document.getElementById('updateForm');

    function fillForm(rowNumber) {
        var cells = document.getElementById('main-table').rows[rowNumber + 1].cells;
        var rowId = cells[0].innerText;
        updateForm.action = `/admin/tickets/${rowId}/edit`;
        document.getElementById('title').value = cells[1].innerText;
        document.getElementById('release_year').value = cells[2].innerText;
        document.getElementById('genre').value = cells[3].innerText;
        document.getElementById('director').value = cells[4].innerText;
        document.getElementById('description').value = cells[5].innerText;
        document.getElementById('age_rating').value = cells[6].innerText;
        document.getElementById('duration').value = cells[7].innerText;
        document.getElementById('rating').value = cells[8].innerText;
        document.getElementById('poster_url').value = cells[9].innerText;
        document.getElementById('trailer_url').value = cells[10].innerText;
    }

    function deleteRow(rowId) {
        window.location.href = `/admin/tickets/${rowId}/delete`;
    }
</script>