<?php

/*
 * MutantCropsCards: all utility functions concerning cards are here
 */
class MutantCropsCards extends APP_GameClass
{
  public $game;
  public function __construct($game)
  {
    $this->game = $game;

    $this->crops = $this->game->getNew("module.common.deck");
    $this->crops->init("crops");
    $this->crops->autoreshuffle = true; // TODO really ?
  }

  public function setupNewGame($players)
  {
    // Create crops
    $crops = [];
    for($i = 0; $i < count($this->game->crops); $i++){
      $crop = $this->game->crops[$i];
      $crops[] = ['type' => $crop['id'], 'type_arg' => 0, 'nbr' => $crop['number']];
    }
    $this->crops->createCards($crops, 'deck');
    $this->crops->shuffle('deck');
    $this->crops->pickCardsForLocation(count($players) == 4? 3 : 3, 'deck', 'board');
  }



  public function getCropsOnBoard()
  {
    return array_values(array_map(function($card){ return $card['type']; }, $this->crops->getCardsInLocation("board")));
  }
}
