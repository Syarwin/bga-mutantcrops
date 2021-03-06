define(["dojo", "dojo/_base/declare"], (dojo, declare) => {
  return declare("mutantcrops.playerTrait", null, {
    constructor(){
      this._notifications.push(
        ['addResources', 1000],
        ['addMultiResources', 1000]
      );
    },


    setupPlayers(){
      // Add meeples and tokens
      this.gamedatas.fplayers.forEach(player => {
        this.place('jstpl_player_crops', player, 'player-crops');
        if(this.player_id == player.id)
          dojo.style("player-crops-" + player.id, "order", 0);

        dojo.place( this.format_block( 'jstpl_player_panel', player) , 'overall_player_board_' + player.id );

        // Meeples
        player.farmers.forEach((location, id) => {
          var meeple = this.format_block( 'jstpl_player_meeple', { playerId:player.id, farmerId:id, color:player.color });
          dojo.place(meeple , location == null? ('tokens-container-' + player.id) : ('location-' + location) );
        });

        player.crops.forEach(crop => {
          this.addCrop(crop, player.id + "-" + crop.id , "player-crops-" + player.id );
        })
      });
    },


    getPlayerFarmers(playerId){
      playerId = playerId || this.getCurrentPlayerId();
      var no = this.gamedatas.fplayers.reduce(function(carry, player){
        return (player.id == playerId)? player.no : carry;
      }, 1);

      return dojo.query("#board .meeple-" + no);
    },


    getFarmerInHand(playerId){
      playerId = playerId || this.getCurrentPlayerId();
      return [dojo.query("#overall_player_board_" + this.getCurrentPlayerId() + " .meeple")[0]];
    },


    notif_addResources(n) {
      debug('Notif: adding resources to a player', n.args);
      this.addResourcesFromLocation(n.args.locationId, n.args.playerId, n.args.type, n.args.n, n.args.total, 0);
    },


    notif_addMultiResources(n) {
      debug('Notif: adding several types of resources to a player', n.args);

      this.addResourcesFromLocation(n.args.locationId, n.args.playerId, "food", n.args.nFood, n.args.totalFood, 0);
      this.addResourcesFromLocation(n.args.locationId, n.args.playerId, "water", n.args.nWater, n.args.totalWater, 1);
      this.addResourcesFromLocation(n.args.locationId, n.args.playerId, "seeds", n.args.nSeeds, n.args.totalSeeds, 2);
    },

    addResourcesFromLocation(locationId, playerId, type, n, total, delay){
      this.addResources("location-" + locationId, playerId, type, n, total, delay);
    },

    addResources(location, playerId, type, n, total, delay){
      debug("Adding resource : " + n + " " + type);
      var container = "tokens-container-" + playerId;

      for(var i = 0; i < n; i++){
        this.slideTemporary('jstpl_token', { type:type }, container, location, container, 1000, (i + delay)*100);
      }

      setTimeout(function(){
        dojo.query("#" + container + " .token-" + type)[0].innerHTML = "x" + total;
      }, 1000 + n*100);
    },

    removeResources(playerId, type, n, total, delay, target){
      debug("Removing resource : " + n + " " + type);
      var container = "tokens-container-" + playerId,
          target  = target ?? "pagemaintitletext";

      for(var i = 0; i < n; i++){
        this.slideTemporary('jstpl_token', { type:type }, container, container, target, 1000, (i + delay)*100);
      }
      dojo.query("#" + container + " .token-" + type)[0].innerHTML = "x" + total;
    },

  });
});
