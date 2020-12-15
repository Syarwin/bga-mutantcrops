<?php
namespace MUT\States;
use MUT\Players;

trait SowTrait
{
  //////////////////////////////////////
  /////////////    Sow    //////////////
  //////////////////////////////////////

  /*
   * argPlayerSow: give the list of accessible crops for sowing
   */
  public function argPlayerSow()
  {
    return [
      'crops' => Players::getActive()->getSowableCrops()
    ];
  }



  /*
   * playerSow : sow a crop from deck
   */
  public function playerSow($cropId)
  {
    self::checkAction('sow');
    $arg = $this->argPlayerSow();
    if(!in_array($cropId, $arg['crops']) ){
      throw new \BgaUserException(clienttranslate("You can't sow this crop"));
    }

    Players::getActive()->sowCrop($cropId);
    $this->gamestate->nextState("sowed");
  }
}
