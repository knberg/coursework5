<?php


class AuthController extends Controller
{
    public function __construct() 
    {
        $this->view = new View();
    }

    public function register()
    {
        $validator = new Validator([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'confirm_password' => ['required']
        ]);

        $validator->validate($_POST);

        if ($validator->hasErrors()) {
            $this->view->send(['status' => 'error', 'errors' => $validator->getFirstErrors()]);
        } 

        $userModel = new UserModel();
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $registeredUser = $userModel->create($name, $email, $hashedPassword);
        $this->view->send(['status' => 'success']);
    }

    public function login()
    {
        $validator = new Validator([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $validator->validate($_POST);

        if ($validator->hasErrors()) {
            $this->view->send(['status' => 'error', 'errors' => $validator->getFirstErrors()]);
        } 

        $userModel = new UserModel();
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = $userModel->getByEmail($email);

        if (!empty($user)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION["user_id"] = $user['id'];
                $_SESSION["user_name"] = $user['name'];
                $_SESSION["user_email"] = $user['email'];
                $_SESSION["user_role"] = $user['role'];
                $this->view->send(['status' => 'success']);
            } 
        }
        $this->view->send(['status' => 'error', 'errors' => "Неверный логин или пароль"]);
    }

    public function logout()
    {
        session_destroy();
        $_SESSION = []; 
        redirect('/');
    }
}