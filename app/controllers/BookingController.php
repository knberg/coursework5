<?php


class BookingController extends Controller 
{
    private $ticketMailer;

    public function __construct() 
    {
        $this->view = new View('home_template');
        $this->ticketMailer = new TicketMailer();
    }

    public function index($sessionId) 
    {
        $sessionModel = new SessionModel();
        $session = $sessionModel->getById($sessionId);
        if ($session == null) redirect("/404");
        
        $hallModel = new HallModel();
        $hallSchema = $hallModel->getHallSchema($session['hall']['number']);
        $ticketModel = new TicketModel();
        $bookedSeats = $ticketModel->getBookedSeatsBySession($sessionId);
        
        $this->view->add('session', $session);
        $this->view->add('schema', $hallSchema);
        $this->view->add('bookedSeats', $bookedSeats);
        $this->view->render("Бронирование", "home/booking");
    }

    public function make() 
    {
        $requestPayload = file_get_contents('php://input');
        $data = json_decode($requestPayload, true);
        $sessionId = $data['session_id'];   
        $seats = $data['seats'];
        $total = $data['total'];
        $userId = $_SESSION['user_id'];

        if (!$sessionId || !$seats) {
            $this->view->send(["status" => "error", "msg" => "ошибка во время резервирования мест"]);
        }
        
        $ticketModel = new TicketModel();
        foreach ($seats as $seatId) {
            $ok = $ticketModel->check($sessionId, $seatId);
            if ($ok != null) {
                $this->view->send(["status" => "error", "msg" => "ошибка во время резервирования мест"]);
            }
        }

        foreach ($seats as $seatId) {
            $id = $ticketModel->create($userId, $sessionId, $seatId, $total);
            $ticket = $ticketModel->getById($id);
            $this->ticketMailer->sendTicketEmail($ticket);
        }
    
        $this->view->send(["status" => "success", "msg" => "резервирование успешно, билеты отправлены по почте"]);
    }

    public function cancel() 
    {
        $this->view->render("Личный кабинет", "cabinet/settings");
    }
}