<?php

namespace App\Manager;

class SecurityManager
{
    public function securityEmail($email){

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = "Mail not valid";
            return $error;
        }
        return;
    }

    public function securitySiret($siret){
        if (strlen($siret) != 14) {
            $error []= "The size of the siret is not correct";
        }
        if(isset($error)){
            return $error;
        }
        return;
    }

    public function securityMinMax($string, $min, $max = 0){
        if (strlen($string) < $min) {
            $error []= "The entered value contains at least ".$min." characters";
            return ;
        }
        if($max != 0){
            if (strlen($string) > $max) {
                $error []= "The entered value contains at least ".$max." characters";
                return ;
            }
        }
        if(isset($error)){
            return $error;
        }
        return;
    }

    public function securityPassword($string, $min, $max){
        if(strlen($string) < $min || strlen($string) > $max){
            $error [] = "Value must contain ".$min." and ".$max." characters";
        }
        if($string != trim($string)){
            $error [] = "Spaces not allowed in password";
        }
        if(isset($error)){
            return $error;
        }
        return;
    }

}