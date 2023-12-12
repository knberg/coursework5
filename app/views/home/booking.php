<div class="container boba">
    <div id="session-info" data-session-id="<?= $session['id'] ?>" data-session-price="<?= $session['price'] ?>">
        <h1 class="movie-title"><?= $session['movie']['title'] ?></h1>
        <div class="date"><span>Дата:</span> <?= $session['date'] ?></div>
        <div class="time"><span>Время:</span> <?= $session['time'] ?></div>
        <div class="time"><span>Зал:</span> <?= $session['hall']['number'] ?></div>
        <div class="price"><span>Цена билета:</span> <?= $session['price'] ?></div>
    </div>
    <table id="hall-map">
        <thead>
            <tr>
                <th></th>
                <?php foreach ($schema[1] as $seat_number => $seat_info): ?>
                <th><?= $seat_number ?></th>
                <?php endforeach ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($schema as $row_number => $row_info): ?>
            <tr>
                <th><?= $row_number ?></th>
                <?php 
                    foreach ($row_info as $seat_number => $seat_info): 
                    $class = in_array($seat_info['id'], $bookedSeats) ? 'seat reserved' : 'seat';
                ?>
                <td><button class="<?= $class ?>" data-seat-id="<?= $seat_info['id'] ?>"></button></td>
                <?php endforeach ?>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <div id="booking-info">
        <? if (checkAuthorization()): ?>
        <div class="final">Итого:</div>
        <div id="total">0 р</div>
        <button id="book-btn" class="cinema-btn" onclick="reserveSeats()">Забронировать</button>
        <? else: ?>
        <div id="warning">Резервирование доступно только для авторизованных пользователей</div>
        <button class="cinema-btn" onclick="openModal()">Войти</button>
        <? endif ?>
    </div>
</div>

<script>
    const sessionId = document.getElementById('session-info').getAttribute('data-session-id');
    const sessionPrice = document.getElementById('session-info').getAttribute('data-session-price');
    const seats = document.querySelectorAll('.seat');
    var selectedSeats = [];

    seats.forEach(seat => seat.addEventListener('click', function() {
        var seatId = seat.getAttribute('data-seat-id');
        seat.classList.toggle('selected');
        if (selectedSeats.includes(seatId)) {
            selectedSeats = selectedSeats.filter(item => item !== seatId);
        } else {
            selectedSeats.push(seatId);
        }
        calculateTotalAmount();
    }));

    function calculateTotalAmount() {
        var totalAmountElement = document.getElementById('total');
        var totalAmount = selectedSeats.length * Number(sessionPrice);
        totalAmountElement.textContent = totalAmount + "р";
    }

    function reserveSeats() {
        fetch('/booking', {
            method: 'POST',
            'Content-Type': 'application/json',
            body: JSON.stringify({ 'session_id': sessionId, 'seats': selectedSeats, 'total': sessionPrice })
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                alert('Произошла ошибка при бронировании мест. Пожалуйста, попробуйте ещё раз.');
            }
        })
        .then(data => alert(data.msg))
    }
</script>