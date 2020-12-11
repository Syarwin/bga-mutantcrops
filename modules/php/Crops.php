<?php
namespace MUT;

/*
 * MutantCropsCards: all utility functions concerning cards are here
 */
class Crops extends Helpers\Pieces
{
  protected static $table = "crops";
	protected static $prefix = "crop_";
  protected static $customFields = ['type', 'water', 'food', 'special'];
  protected static function cast($card){
    return self::getCrop($card['type'], $card);
  }

  protected static $classes = [
    ASPARAGUS => 'Asparagus',
    BANANA => 'Banana',
    BROCCOLI => 'Broccoli',
    CHARD => 'Chard',
    CRANBERRY => 'Cranberry',
    CUCUMBER => 'Cucumber',
    EGGPLANT => 'Eggplant',
    MELON => 'Melon',
    ONION => 'Onion',
    ORANGE => 'Orange',
    PEAR => 'Pear',
    PEACH => 'Peach',
    PEPPER => 'Pepper',
    POTATO => 'Potato',
    PUMPKIN => 'Pumpkin',
    STRAWBERRY => 'Strawberry',
  ];

  public function getCrop($type, $info = null){
    $typeName = self::$classes[$type];
    $name = '\MUT\Crops\Crop'.$typeName;
    require_once("Crops/".$typeName.".php");
    return new $name($info);
  }

  public function getUiData(){
    $ui = [];
    foreach(self::$classes as $typeId => $typeName){
      $crop = self::getCrop($typeId);
      $ui[] = $crop->getUiData();
    }

    return $ui;
  }


  public function setupNewGame($players)
  {
    $crops = [];
    foreach(self::$classes as $typeId => $typeName){
      $crop = self::getCrop($typeId);

      $crops[] = ['type' => $typeId, 'nbr' => $crop->getCopies(), 'water' => false, 'food' => false, 'special' => false];
    }
    self::create($crops, 'deck');
    self::shuffle('deck');
    self::pickForLocation(count($players) == 4? 4 : 3, 'deck', 'board');
  }

  public function getOnBoard()
  {
    return self::getInLocation("board")->map(function($crop){ return $crop->getInfo(); });
  }

/*

  public function getSowedCrops($pId)
  {
    return [];
  }


  public function getPlayerCrops($pId = null)
  {
    $pId = $pId ?: Players::getActiveId();
    return self::getInLocation(["hand", $pId]);
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
*/
}
