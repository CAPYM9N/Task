<?php

namespace core\user\model;

use core\base\controller\Singleton;

class User extends Model
{
    use Singleton;

    public function registerNewUser($data, $messages)
    {
        $users = $this->getUsers();
        $users[] = $data;

        file_put_contents('users.json', json_encode($users,   ));

        $_SESSION['result']['success'] = $messages['registerSuccess'];
        $_SESSION['guest'] = $data['login'];

        return true;

    }

    public function checkLogin($data, $messages){

        $users = $this->getUsers();

        foreach ($users  as $key => &$value){

            if($value['login'] === $data['aut_login']) {

                if($value['password'] === $data['aut_password']){

                    if($data['remember']) {

                        $value['remember_token'] = md5($value['email'] . SALT);

                        setcookie("remember", $value['remember_token'], time() + (1000 * 60 * 60 * 24 * 30));

                        file_put_contents('users.json', json_encode($users, JSON_FORCE_OBJECT));

                        $_SESSION['result']['success'] = $messages['loginSuccess'];
                        $_SESSION['guest'] = $value['login'];

                        return true;
                    }

                    $_SESSION['result']['success'] = $messages['loginSuccess'];
                    $_SESSION['guest'] = $value['login'];

                    return true;

                }else{
                    $_SESSION['result']['warning']['aut_password'] = $messages['passwordFail'];

                    return false;
                }
            }
        }

        $_SESSION['result']['warning']['aut_login'] = $messages['loginFail'];

        return false;
    }

    public function getUser($cookie){

        $users = $this->getUsers();

        foreach ($users  as $key => $value){

            if($value['remember_token'] === $cookie){

                    return $value['login'];

            }
        }

        return false;
    }
}