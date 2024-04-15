<?php

class Jeu
{
    private $aDeviner = 30;
    private $message = -1;
    private $value = null;
    private $alcoolemie = 0;
    public $numberToGuess;

    public function __construct()
    {
    }

    public function deviner($chiffre = null)
    {
        
        if (isset($chiffre)) {
            $tries = Session::get("usertries");
            $tries = $tries + 1;
            Session::set("usertries", $tries);

            $numberToGuess = $this->getNumberToGuess();

            $this->value = (int)$_GET['chiffre'];
            
            if ($this->bernoulli_distribution($this->alcoolemie)) {
                if ($this->value > $numberToGuess) {
                    $this->message = 1;
                } elseif ($this->value < $numberToGuess) {
                    $this->message = 2;
                } else {
                    $this->message = 0;
                }
                
                if ($this->alcoolemie<=0.9){
                    $this->alcoolemie+=0.1;
                }
                else {
                    $this->alcoolemie=1;
                };
            }
            else {
                if ($this->value > $numberToGuess) {
                    $this->message = 2;
                } elseif ($this->value < $numberToGuess) {
                    $this->message = 1;
                } else {
                    $this->message = 0;
                }
                
            }
            $_SESSION['drunk'] = $this->alcoolemie;
            $this->value = $_GET['chiffre'];

        }
    }

    public function bernoulli_distribution( $taux ){
        $number = rand(0, 99);
        if($number <= 100 - $taux*100){
            return true;
        }else{
            return false;
        }
    }

    public function getMessage()
    {
        return $this->message;
    }
    public function getValue()
    {
        return $this->value;
    }
    private function getNumberToGuess()
    {
        // Check option random
        if (isset($_GET['games']) && in_array('first', $_GET['games'])) {
            $_SESSION['random_number'] = null;
            return $this->aDeviner;
        }        
        elseif (isset($_GET['games']) && in_array('second', $_GET['games'])) {
            
            if (!isset($_SESSION['random_number'])){
                $_SESSION['random_number'] = rand(1, 100);
            }
            return $_SESSION['random_number'];
        }
        elseif (isset($_GET['games']) && in_array('third', $_GET['games'])) {
            $this->alcoolemie = $_SESSION['drunk'];
            $_SESSION['random_number'] = null;
            return $this->aDeviner;
        }
        else {
            $_SESSION['random_number'] = null;
            return $this->aDeviner;
        }
    }
}

