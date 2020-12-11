<?php
namespace MUT\States;

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
    return [];
    /*
    $arg = [
      'crops' => $this->cards->getSowableCrops(),
    ];

    return $arg;
    */
  }



  /*
   * Assign : TODO
   */
  public function playerSow($cropPos)
  {
    self::checkAction('sow');
    $arg = $this->argPlayerSow();

    if(!in_array($cropPos, $arg['crops']) ){
      throw new BgaUserException(_("You can't sow this crop"));
    }

    $this->cards->sowCrop($cropPos);
    $this->gamestate->nextState("sowed");
  }

}
