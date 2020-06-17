<?php

/*
 * MutantCropsCards: all utility functions concerning cards are here
 */
class MutantCropsCards extends APP_GameClass
{
  public $game;
  public $crops;
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
    $this->crops->pickCardsForLocation(count($players) == 4? 4 : 3, 'deck', 'board');


    // Create fields
    $allFields = [];
    for($stage = 1; $stage <= 3; $stage++){
      $fields = array_values(array_map(function($field){ return $field['id']; }, array_filter($this->game->fields, function($field) use ($stage){
        return $field['stage'] == $stage && $field['id'] < 12; // TODO : handle extension
      })));

      if($stage == 1)
        $allFields = $fields;
      else {
        shuffle($fields);
        $allFields = array_merge($allFields,  array_slice($fields, 0, 3));
      }
    }

    $this->game->log->addAction("fields", ['fields' => $allFields]);
  }



  public function getCropsOnBoard()
  {
    return array_values(array_map(function($card){ return $card['type']; }, $this->crops->getCardsInLocation("board")));
  }


  public function getPlayerCrops($pId = null)
  {
    $pId = $pId ?: $this->game->getActivePlayerId();
    return array_values($this->crops->getCardsInLocation("hand", $pId));
  }


  public function getFieldsOnBoard()
  {
    $fields = $this->game->log->getAction("fields");
    $round = (int) $this->game->getGamestateValue('currentRound');
    return array_values(array_slice($fields['fields'], 0, 6 + $round));
  }


  public function getSowableCrops()
  {
    $player = $this->game->playerManager->getPlayer();
    $crops = [];
    foreach($this->getCropsOnBoard() as $pos => $cropId){
      if($player->canSow($cropId))
        $crops[] = $pos;
    }

    return $crops;
  }

  public function canSow()
  {
    return count($this->getSowableCrops()) > 0;
  }


  public function getAvailableLocations()
  {
    $fields = $this->getFieldsOnBoard();
    $locations = [];
    foreach($fields as $fieldId){
      $locations[] = 2*$fieldId;
      $locations[] = 2*$fieldId + 1;
    }

    $farmersLocations = $this->game->playerManager->getFarmersLocations();
    return array_values(array_filter($locations, function($location) use ($farmersLocations){
      return !in_array($location, $farmersLocations)
        && (!in_array($location, [1]) || $this->canSow());
    }));
  }



  public function sowCrop($cropPos)
  {
    $card = array_values($this->crops->getCardsInLocation("board"))[$cropPos];
    $this->crops->moveCard($card['id'], 'hand', $this->game->getActivePlayerId());
    $this->game->playerManager->getPlayer()->sowCrop($card, $cropPos);

    $newCard = $this->crops->pickCardForLocation('deck', 'board', $cropPos);
    $this->game->notifyAllPlayers('newCrop', '', [
      'cropPos' => $cropPos,
      'cropType' => $newCard['type'],
    ]);

  }
}
