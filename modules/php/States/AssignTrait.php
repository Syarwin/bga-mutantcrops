<?php
namespace MUT\States;
use MUT\Log;
use MUT\Players;
use MUT\Fields;
use MUT\Notifications;

trait AssignTrait
{
  /////////////////////////////////////////
  /////////////////////////////////////////
  /////////////    Assign    //////////////
  /////////////////////////////////////////
  /////////////////////////////////////////

  /*
   * argPlayerAssign: give the list of accessible unnocupied spaces for builds
   */
  public function argPlayerAssign()
  {
    return [
      'location' => Players::getActive()->hasFarmerInHand()? 'hand' : 'board',
      'availableLocations' => Fields::getAvailable(),
    ];
  }



  /*
   * Assign : assign a famer to a location
   */
  public function playerAssign($farmerId, $locationId)
  {
    self::checkAction('assign');
    $arg = $this->argPlayerAssign();
    $player = Players::getActive();

    // Can't move a farmer on board unless all the farmers are already on the board
    if($arg['location'] == 'hand' && $farmerId < count($player->getFarmersOnBoard()) ){
      throw new \BgaUserException(clienttranslate("You have to assign one of the farmers in your hand"));
    }

    // Make sure the location is free
    if(!in_array($locationId, $arg['availableLocations'])){
      throw new \BgaUserException(clienttranslate("This location is not free"));
    }

    // Update position
    self::DbQuery("UPDATE player SET farmer_$farmerId = '$locationId' WHERE player_id = '{$player->getId()}'");
    Notifications::assignFarmer($player, $farmerId, $locationId);

    // Handle effect
    $transition = Fields::resolve($locationId, $player) ?? 'farmerAssigned';

    $this->gamestate->nextState($transition);
  }
}
