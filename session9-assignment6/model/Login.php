<?php

require_once 'model/Model.php';

class Login extends Model{
    protected $table = 'users';
    protected $id = 'id';


    public function login_to($data){
        $select = '`id`,`name`,`username`,`role`,`email`';
        $where = ['username'=>$data['username'],'password'=>md5($data['password'])];
        $join = '';
        $order_by = '';
        $single = true;
        return parent::select($select,$where,$join,$order_by,$single);
    }
    
}