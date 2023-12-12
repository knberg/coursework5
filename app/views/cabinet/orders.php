<?php $now = new DateTime() ?>
<h1>Мои билеты</h1>
<h2>Активные билеты</h2>
<table id="active-tickets-table">
    <thead>
        <tr>
            <th style="">Номер</th>
            <th style="">Фильм</th>
            <th style="">Дата сеанса</th>
            <th style="">Зал</th>
            <th style="">Ряд</th>
            <th style="">Место</th>
            <th style="">Стоимость</th>
            <th style="">Оформлен</th>
            <th style="">Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($tickets as $ticket): 
            $ticketDate = $ticket['session_date'] . ' ' . $ticket['session_time'];
            if (new DateTime($ticketDate) > $now):
        ?>
        <tr>
            <td><?= $ticket['id'] ?></td>
            <td><?= $ticket['title'] ?></td>
            <td><?= $ticketDate ?></td>
            <td><?= $ticket['hall_number'] ?></td>
            <td><?= $ticket['row_numb'] ?></td>
            <td><?= $ticket['col_numb'] ?></td>
            <td><?= $ticket['total'] ?>р</td>
            <td><?= $ticket['buy_date'] ?></td>
            <td>
                <button class="cinema-btn return-btn">Вернуть</button>
                <button class="cinema-btn download-btn">Скачать</button>
            </td>
        </tr>
        <?php endif ?>
        <?php endforeach ?>
    </tbody>
</table>

<h2>История билетов</h2>
<table id="history-tickets-table">
    <thead>
        <tr>
            <th style="">Номер</th>
            <th style="">Фильм</th>
            <th style="">Дата сеанса</th>
            <th style="">Зал</th>
            <th style="">Стоимость</th>
            <th style="">Оформлен</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        foreach ($tickets as $ticket): 
            $ticketDate = $ticket['session_date'] . ' ' . $ticket['session_time'];
            if (new DateTime($ticketDate) < $now):
        ?>
        <tr>
            <td><?= $ticket['id'] ?></td>
            <td><?= $ticket['title'] ?></td>
            <td><?= $ticketDate ?></td>
            <td><?= $ticket['hall_number'] ?></td>
            <td><?= $ticket['total'] ?>р</td>
            <td><?= $ticket['buy_date'] ?></td>
        </tr>
        <?php endif ?>
        <?php endforeach ?>
    </tbody>
</table>