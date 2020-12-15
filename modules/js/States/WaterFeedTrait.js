define(["dojo", "dojo/_base/declare"], (dojo, declare) => {
  return declare("mutantcrops.waterFeedTrait", null, {
    constructor(){
      this._notifications.push(
        ['growCrop', 1500]
      );
    },


    /*
     * playerWaterOrFeed: TODO
     */
    onEnteringStatePlayerWaterOrFeed(args) {
      this.makeZonesSelectable(args.zones);
    },


    makeZonesSelectable(zones) {
      this._selectableZones = zones;

      this._selectableZones.forEach(zone => {
        var elem = document.querySelector(`.crop[data-id="${zone[0]}"] .crop-power-box.power-${zone[1]}`);
        dojo.addClass(elem, 'selectable');
        this.connect(elem, 'click', () => this.onClickZone(zone) );
      });
    },

    onClickZone(zone){
      debug("Coucou");
      if (!this.checkAction('grow') || !this._selectableZones.includes(zone))
        return false;

      this.takeAction('grow', {
        cropId: zone[0],
        type: zone[1]
      });
//      this.clearPossible();
    },


    notif_growCrop(n){
      debug("Growing crop", n);
      let targetId = "crop-" + n.args.playerId + "-" + n.args.crop.id;
//      var zone = document.querySelector(`.crop[data-id="${n.args.crop.id}"] .crop-power-box.power-${n.args.type}`);
      this.removeResources(n.args.playerId, n.args.resource_name, n.args.n, n.args.total, 0, targetId);

      setTimeout( () => {
        dojo.attr(targetId, "data-" + n.args.type, 1);
        // Earn coins
        if(n.args.m){
          this.addResources(targetId, n.args.playerId, "coins", n.args.m, n.args.totalCoins, 0);
        }
      }, 1000);
    },
  });
});
