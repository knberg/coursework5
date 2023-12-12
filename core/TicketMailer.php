<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class TicketMailer
{
    private $ticketTemplate;
    private $mailer;

    public function __construct() 
    {
        $this->ticketTemplate = file_get_contents(TEMPLATE_PATH . 'ticket_template.html');
        $this->mailer = new PHPMailer();
    }

    public function sendTicketEmail($ticket) 
    {
        $this->mailer->isSMTP();
        $this->mailer->Host       = SMTP_HOST;
        $this->mailer->SMTPAuth   = true;
        $this->mailer->CharSet    = 'UTF-8';
        $this->mailer->Username   = SMTP_USERNAME;
        $this->mailer->Password   = SMTP_PASSWORD;
        $this->mailer->Port       = SMTP_PORT;

        $this->mailer->setFrom(SMTP_FROM, SMTP_FROM_NAME);
        $this->mailer->addAddress($_SESSION['user_email']);
        $this->mailer->Subject = "Билеты";
        $this->mailer->isHTML(true);
        $this->mailer->Body = $this->generateHtmlTicket($ticket);

        return $this->mailer->send();
    }

    public function generateHtmlTicket($data) 
    {
        $placeholders = array(
            '{ticketId}',
            '{movieTitle}',
            '{sessionDate}',
            '{sessionTime}',
            '{hallNumber}',
            '{rowNumber}',
            '{seatNumber}',
            '{total}',
        );
    
        $replace = array(
            $data['id'],
            $data['title'],
            $data['session_date'],
            $data['session_time'],
            $data['hall_number'],
            $data['row_numb'],
            $data['col_numb'],
            $data['total'],
        );
    
        return str_replace($placeholders, $replace, file_get_contents(TEMPLATE_PATH . 'ticket_template.html'));
    }
}