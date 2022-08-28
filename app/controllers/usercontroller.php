<?php


class UserController extends Controller
{

    public function beforeAction() {
        $now = time();
        if (!empty($_SESSION['discard_after'])) {
            if($now > $_SESSION['discard_after']) {
                $this->logout();
            }
        }
    }

    public function login() {
        if(!empty($_POST)) {
            $userExistsByEmailPassword = $this->User->select(['email' => $_POST['email'], 'password' => md5($_POST['password'])]);

            if(count($userExistsByEmailPassword) > 0) {
                $keepSessionAliveFor = (!empty($_POST['remember_me'])) ? 3600 : 60;
                $_SESSION['user'] = $userExistsByEmailPassword;
                $_SESSION['discard_after'] = time() + $keepSessionAliveFor;
                $_SESSION['success'] = 'Login successful';
                header('location:'.APP_URL.'user/dashboard');
                die();
            } else {
                $this->set('error', 'Check your credentials!');
            }

        }
        $this->set('title', 'Login');
    }

    public function dashboard() {
        if(!empty($_SESSION['user'])) {
            if(!empty($_SESSION['success'])) {
                $this->set('success', $_SESSION['success']);
                unset($_SESSION['success']);
            }
            $this->set('user', $_SESSION['user']);
            $this->set('title', 'dashboard');
        } else {
            $this->logout();
        }
    }

    public function logout() {
        unset($_SESSION['user']);
        session_unset();
        session_destroy();
        header('location:'.APP_URL.'user/login');
        die();
    }

    public function register() {
        if(!empty($_POST)) {
            $userExistsByEmail = $this->User->select(['email' => $_POST['email']]);
            if(count($userExistsByEmail) > 0) {
                $this->set('error', 'User exists with email!');
            } else {
                $this->User->id = null;
                $this->User->email = $_POST['email'];
                $this->User->password = md5($_POST['password']);
                $this->User->created_at = date('Y-m-d H:i:s');
                $this->User->save();
                $this->set('success', 'User registered successfully!');
                unset($_POST);
            }

        }

        $this->set('title', 'Register');
    }
}