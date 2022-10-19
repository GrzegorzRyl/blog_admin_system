<?php

Class LoginValidation
{
    public $info_login;
    public $user = "Blog";
    private $password = "Test";
    public function __construct(string $user_form, string $password_form)
    {
        $this -> userValidation($user_form);
        $this -> passwordValidation($password_form);

        if($this -> info_login == null){
            $this -> info_login = "logged";
        }



    }

    private function userValidation($user_form){

        if ($this -> user != $user_form){
            $this -> info_login = "Zła nazwa użytkownika lub hasło";
        }

        if ($user_form == null){
            $this -> info_login = "Wprowadz dane";
        }
    }

    private function passwordValidation($password_form){

        if ($this -> password != $password_form){
            $this -> info_login = "Zła nazwa użytkownika lub hasło";
        }

        if ($password_form == null){
            $this -> info_login = "Wprowadz dane";
        }
    } 


}