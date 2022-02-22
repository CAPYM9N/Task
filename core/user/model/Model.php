<?php

namespace core\user\model;

use core\base\controller\Singleton;
use core\base\model\BaseModel;

class Model extends BaseModel
{
    use Singleton;

    public function checkFieldOnUnique($item, $field){

        if(file_exists('users.json')){

            $users = $this->getUsers();

            foreach ($users  as $key => $data){
                if($data[$field] === $item) return true;
            }

            return false;
        }
    }

    public function getUsers(){

        return json_decode(file_get_contents('users.json'), true) ?: [];
    }
}