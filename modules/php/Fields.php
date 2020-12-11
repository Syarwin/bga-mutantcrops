<?php
namespace MUT;

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

  public function getOnBoard()
  {
    return self::getInLocation(['stage', '%'])->map(function($field){ return $field->getInfo(); });
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


  public function getAvailable()
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
