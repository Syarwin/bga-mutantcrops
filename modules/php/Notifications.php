<?php
namespace MUT;
use MutantCrops;

class Notifications extends \APP_DbObject
{
  protected static function notifyAll($name, $msg, $data){
    MutantCrops::get()->notifyAllPlayers($name, $msg, $data);
  }

  protected static function notify($pId, $name, $msg, $data){
    MutantCrops::get()->notifyPlayer($pId, $name, $msg, $data);
  }


  public function assignFarmer($player, $farmerId, $locationId){
    self::notifyAll('farmerAssigned', clienttranslate('${player_name} assigns one of its farmers'), [
      'player_name' => $player->getName(),
      'playerId' =>  $player->getId(),
      'farmerId' => $farmerId,
      'locationId' => $locationId,
    ]);
  }

  public function addResources($player, $from, $amount, $type, $newTotal){
    self::notifyAll('addResources', clienttranslate('${player_name} obtain ${n} ${type}'), [
      'i18n' => ['type'],
      'player_name' => $player->getName(),
      'playerId' => $player->getId(),
      'locationId' => $from,
      'type' => $type,
      'n' => $amount,
      'total' => $newTotal,
    ]);
  }

  public function addMultiResources($player, $from, $amounts, $totals){
    self::notifyAll('addMultiResources', clienttranslate('${player_name} obtain ${nFood} food, ${nWater} water and ${nSeeds} seeds'), [
      'player_name' => $player->getName(),
      'playerId' => $player->getId(),
      'locationId' => $from,
      'nFood' => $amounts[0],
      'totalFood' => $totals[0],
      'nWater' => $amount[1],
      'totalWater' => $totals[1],
      'nSeeds' => $amount[2],
      'totalSeeds' => $total[2],
    ]);
  }


  public function sowCrop($player, $crop){
    self::notifyAll('sowCrop', clienttranslate('${player_name} spends ${n} seeds to sow ${crop_name}'), [
      'i18n' => ['crop_name'],
      'player_name' => $player->getName(),
      'playerId' => $player->getId(),
      'crop_name' => $crop->getName(),
      'n' => $crop->getSeeds(),
      'total' => $player->getSeeds(),
      'crop' => $crop->getStatus(),
    ]);
  }

  public function newCrop($crop){
    self::notifyAll('newCrop', clienttranslate('A new ${crop_name} is revealed'), [
      'i18n' => ['crop_name'],
      'crop_name' => $crop->getName(),
      'crop' => $crop->getStatus(),
    ]);
  }

  public function newField($fields){
    self::notifyAll('newField', clienttranslate('A new field is now available!'), [
      'fieldId' => $fields[count($fields) - 1]['id'],
      'index' => count($fields) - 1,
    ]);
  }

}

?>
