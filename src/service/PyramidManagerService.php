<?php

namespace App\service;

class PyramidManagerService
{

    public function gameRound(){
        $numligne = 0;
        $namecard = returnCardInit();
        $changePlayerTurn = false;
        while(!$changePlayerTurn) {
            $number = substr($namecard, -6, 2);
            if ($number > 10) {
                echo("boire " . $numligne . "gorger");
                $changePlayerTurn=true;
                //TODO change name in dynamic
                $this->playerChange("Alexis");
            } else {
                returnCard();
                $numligne++;
            }
        }
    }
    public function playerChange(string $nameOtherPlayers){
        echo ("Changement de joueur : \nC'est au tour de ".$nameOtherPlayers.".");
    }


}