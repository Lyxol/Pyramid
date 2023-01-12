<?php

namespace App\service;

use App\Entity\Player;
use App\Entity\Pyramid;
use App\Repository\PlayerRepository;

class PyramidManagerService
{

    public function __construct(private PlayerRepository $playerRepository)
    {
    }

    public function gameRound(Pyramid $pyramid){
        $nbRound = 1;
        $numLine = 1;
        $nameCard = returnCardInit();
        $changePlayerTurn = false;
        while(!$changePlayerTurn) {
            $number = substr($nameCard, -6, 2);
            if ($number > 10) {
                echo("boire " . $numLine . "gorger");
                $changePlayerTurn=true;
                $this->playerChange($pyramid,$nbRound);
            } else {
                returnCard();
                $numLine++;
            }
            $nbRound++;
        }
    }

    public function playerChange(Pyramid $pyramid, int $p){

        $Nameplayer = $this->playerRepository->findAllPlayerNameByPyramid($pyramid);
        $name = $Nameplayer[$p];
        echo ("Changement de joueur : \nC'est au tour de ".$name.".");
    }


}