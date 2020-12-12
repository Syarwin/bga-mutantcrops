define(["dojo", "dojo/_base/declare"], (dojo, declare) => {
  return declare("mutantcrops.assignTrait", null, {
    constructor(){
      this._notifications.push(
        ['farmerAssigned', 1200]
      );
    },

    /*
     * playerAssign: assign a farmer to a location
     */
    onEnteringStatePlayerAssign(args) {
      this._availableLocations = args.availableLocations;
      this.makeFarmersSelectable( (args.location == "hand")? this.getFarmerInHand() : this.getPlayerFarmers() );
    },


    /*
     * makeFarmersSelectable: make a set of farmers selectable
     */
    makeFarmersSelectable(farmers) {
      this._selectableFarmers = farmers;

      // If only one farmer can work, automatically select it
      if (this._selectableFarmers.length == 1)
       this.onClickSelectFarmer(this._selectableFarmers[0]);
      // Otherwise, let the user make the choice
      else if (this._selectableFarmers.length > 1) {
        this._selectableFarmers.addClass("selectable").forEach(meeple => {
          this.connect(meeple, "click", () => this.onClickSelectFarmer(meeple) );
       });
      }

      //          this.connect(meeple, "onclick", function(evt){ evt.preventDefault(); evt.stopPropagation();_this.onClickSelectFarmer(meeple); });
    },



    /*
     * onClickFarmer: select a farmer and highlight corresponding zones
     */
    onClickSelectFarmer(farmer){
      var _this = this;
      var farmerId = farmer.getAttribute('data-farmerId');

      this.clearPossible();
      this._selectedFarmer = farmerId;
      dojo.addClass("meeple-" + this.getActivePlayerId() + "-" + farmerId, "selected");

      if (this._selectableFarmers.length > 1) {
        this.addSecondaryActionButton('buttonReset', _('Cancel'), 'onClickCancelSelect');
      }

      this._availableLocations.forEach(locationId => {
        dojo.addClass('location-' + locationId, 'selectable');
        this.connect($('location-' + locationId), 'click', () => this.onClickLocation(locationId) );
      });
    },


    /*
     * onClickCancelSelect:
     * 	triggered after a click on the action button "buttonReset".
     *  unselect the previously selected worker and make every worker selectable
     */
    onClickCancelSelect(evt) {
      this.clearPossible();
      this._selectedFarmer = null;
      this.makeFarmersSelectable(this._selectableFarmers);
    },



    /*
     * onClickLocation: triggered when clicked on a location
     */
    onClickLocation(locationId){
      if (!this.checkAction('assign') || !this._availableLocations.includes(locationId))
        return false;

      this.takeAction('assign', {
        farmerId: this._selectedFarmer,
        locationId: locationId,
      });
      this.clearPossible();
    },


    /*
     * notif_farmerAssigned: TODO
     */
    notif_farmerAssigned(n) {
      debug('Notif: farmer assigned', n.args);

      var meeple = "meeple-" + n.args.playerId + "-" + n.args.farmerId;
      var location = "location-" + n.args.locationId;
      this.attachToNewParent(meeple, location);
      this.slide(meeple, location, 1200);
    },

  });
});
