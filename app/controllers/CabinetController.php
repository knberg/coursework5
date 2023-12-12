<?php

class CabinetController extends Controller 
{
    public function __construct() 
    {
        $this->view = new View('cabinet_template');
    }

    public function orders() 
    {
        $ticketModel = new TicketModel();
        $tickets = $ticketModel->getByUser($_SESSION['user_id']);
        $this->view->add("tickets", $tickets);
        $this->view->render("Личный кабинет", "cabinet/orders");
    }

    public function settings() 
    {
        $this->view->render("Личный кабинет", "cabinet/settings");
    }

    public function update() 
    {
        $validator = new Validator([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'old_password' => ['required'],
        ]);

        $validator->validate($_POST);

        if ($validator->hasErrors()) {
            $this->view->add('error', 'Ошибка обновления данных профиля');
            redirect('/me/settings');
        } 

        $name = $_POST['name'];
        $email = $_POST['email'];
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'] ?? null;

        $userModel = new UserModel();
        $user = $userModel->getById($_SESSION['user_id']);
        if (password_verify($oldPassword, $user['password'])) {
            $userModel->updateProfile($_SESSION['user_id'], $name, $email);
            $_SESSION["user_name"] = $user['name'];
            $_SESSION["user_email"] = $user['email'];
            if ($newPassword) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $userModel->updatePassword($_SESSION['user_id'], $hashedPassword);
            }
        } else {
            $this->view->add('error', 'Неверный пароль');
        }

        redirect('/me/settings');
    }
}