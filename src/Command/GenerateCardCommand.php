<?php

namespace App\Command;

use App\Entity\Card;
use App\Repository\CardRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

#[AsCommand(
    name: 'app:generate-card',
    description: 'Generate full deck.',
    hidden: false,
)]
class GenerateCardCommand extends Command
{
    public function __construct(public CardRepository $cardRepository){
        parent::__construct();
    }
protected function execute(InputInterface $input, OutputInterface $output): int
{
    $cardRepository = $this->cardRepository;
    $id = 0;

    for ($i = 1; $i <= 4; $i++) {
        for ($j = 1; $j <= 13; $j++) {
            $card = new Card();
            if ($i === 1) {
                $card->setColor("Piques");
                $card->setValue($j);
                $card->setPosition([]);
                if ($j < 10) {
                    $card->setImg("P_0". $j. ".jpg");
                } else {
                    $card->setImg("P_" .$j . ".jpg");
                }
            }
            if ($i === 2) {
                $card->setColor("Coeur");
                $card->setValue($j);
                $card->setPosition([]);
                if ($j < 10) {
                    $card->setImg("C_0". $j. ".jpg");
                } else {
                    $card->setImg("C_". $j .".jpg");
                }
            }
            if ($i === 3) {

                $card->setColor("Carreau");
                $card->setValue($j);
                $card->setPosition([]);
                if ($j < 10) {
                    $card->setImg("K_0". $j .".jpg");
                } else {
                    $card->setImg("K_". $j . ".jpg");
                }
            }
            if ($i === 4) {
                $card->setColor("Trefle");
                $card->setValue($j);
                $card->setPosition([]);
                if ($j < 10) {
                    $card->setImg("T_0" . $j . ".jpg");
                } else {
                    $card->setImg("T_" . $j . ".jpg");
                }
            }
            $id++;
            $cardRepository->save($card);
        }

    }
    $cardRepository->save($card, true);
    new JsonResponse(json_encode('true'));
    return Command::SUCCESS;
}
}