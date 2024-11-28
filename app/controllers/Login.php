<?php

class Login extends Controller{
    public function index()
    {   
        $this->view('login/index');
    }

    public function addUser()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            session_start();
            $username = $_POST['username'];
            $password = md5($_POST['password']);

            $userModel = $this->model("User_model");
            $user = $userModel->checkUser($username, $password);
            var_dump($user);

            if ($user) {
                $_SESSION['username'] = $username;
                Flasher::setFlash('success','Login Success!', 'Welcome '.$username.'');
                header('Location: ' . BASEURL . '/dashboard');
                exit();
            } else {
                Flasher::setFlash('error','Failed!', 'Username or Password Incorrect!');
                header('Location: ' . BASEURL . '/login');
                exit();
            }
        } else {
            require 'app/Views/login.php';
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        
        header('Location: ' . BASEURL . '/login');
        exit();
    }
}