<?php
namespace MUT\States;
use MUT\Log;
use MUT\Players;
use MUT\Fields;
use MUT\Notifications;

trait WaterFeedTrait
{
  public function argPlayerWaterOrFeed()
  {
    return [
      'zones' => Players::getActive()->getWaterableAndFeedableCrops()
    ];
  }



  /*
   * playerGrow : water/feed/special a crop
   */
  public function playerGrow($cropId, $type)
  {
    self::checkAction('grow');
    $args = $this->gamestate->state()['args'];
    $zone = [$cropId, $type];
    if(!in_array($zone, $args['zones']) ){
      throw new \BgaUserException(clienttranslate("You can't grow this crop"));
    }

    $newState = Players::getActive()->growCrop($cropId, $type);
    $this->gamestate->nextState($newState ?? "grow");
  }
}
