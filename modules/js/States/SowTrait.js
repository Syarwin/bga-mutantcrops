define(["dojo", "dojo/_base/declare"], (dojo, declare) => {
  return declare("mutantcrops.sowTrait", null, {
    constructor(){
      this._notifications.push(
        ['sowCrop', 1500],
        ['newCrop', 100]
      );
    },


    /*
     * playerSow: TODO
     */
    onEnteringStatePlayerSow(args) {
      this._selectableCrops = args.crops;
      args.crops.forEach(cropId => {
        let elem = document.querySelector(".crop[data-id='"+ cropId +"']");
        dojo.addClass(elem, "selectable");
        this.connect(elem, "click", () => this.onClickSelectCrop(cropId) );
      });
    },


    /*
     * onClickSelectCrop: TODO
     */
    onClickSelectCrop(cropId){
      if (!this.checkAction('sow') || !this._selectableCrops.includes(cropId))
        return false;

      this.takeAction('sow', {  cropId: cropId });
      this.clearPossible();
    },


    notif_sowCrop(n) {
      debug('Notif: sowing a crop', n.args);

      this.removeResources(n.args.playerId, "seeds", n.args.n, n.args.total, 0);
      let elem = document.querySelector(".crop[data-id='"+ n.args.crop.id +"']");
      this.slideAndDestroy(elem, "player-crops-" + n.args.playerId, 1000, 0)
      .then( () => {
        this.addCrop(n.args.crop, n.args.playerId + "-" + n.args.cardId , "player-crops-" + n.args.playerId );
      });
    },


    notif_newCrop(n) {
      debug('Notif: adding a new crop to the board', n.args);
      for(var i = 1; i <= 4; i++){
        if(!$('crop-' + i)){
          this.addCrop(n.args.crop, i, 'mutantcrops-grid' );
          return;
        }
      }
    },
  });
});
