<?php
namespace MUT;
use MUT\Helpers\Utils;

/*
 * MutantCropsFields: all utility functions concerning fields
 */
class Fields extends Helpers\Pieces
{
  protected static $table = "fields";
	protected static $prefix = "field_";
  protected static $autoIncrement = false;
  protected static $customFields = [];
  protected static function cast($card){
    return self::getField($card['id'], $card);
  }

  protected static $nbrFields = 12;
  public function getField($id, $info = null){
    $name = '\MUT\Fields\Field'.$id;
    require_once("Fields/Field".$id.".php");
    return new $name($info);
  }


  public function setupNewGame($players)
  {
    // Create fields
    $fields = [];
    for($i = 0; $i < self::$nbrFields; $i++){
      $field = self::getField($i);
      //if(...)
      $fields[] = [
        'id' => $i,
        'location' => ['deck', $field->getStage()]
      ];
    }
    self::create($fields);
    self::pickForLocation(6, 'deck_1', 'stage_1');
    self::shuffle('deck_2');
    self::shuffle('deck_3');
  }

  public function getOnBoard($keepInfoOnly = true)
  {
    $fields = self::getInLocation(['stage', '%']);
    return $keepInfoOnly? $fields->map(function($field){ return $field->getInfo(); }) : $fields;
  }


  public function new($stage)
  {
    self::pickForLocation(1, ['deck', $stage], ['stage', $stage]);
    return self::getOnBoard();
  }

  public function getSowedCrops($pId)
  {
    return [];
  }


  public function getAvailable($player = null)
  {
    $fields = self::getOnBoard(false);
    $player = $player ?? Players::getActive();
    $farmersLocations = Players::getFarmersLocations();
    $locations = [];
    foreach($fields as $field){
      $field->addAvailableLocations($locations, $player, $farmersLocations);
    }

    return $locations;
  }

  public function resolve($locationId, $player){
    $field = self::get((int) ($locationId / 2));
    if($locationId % 2 == 0)
      return $field->resolveTop($player);
    else
      return $field->resolveBottom($player);
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
