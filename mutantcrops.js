/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * MutantCrops implementation : © <Your name here> <Your email address here>
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * mutantcrops.js
 *
 * MutantCrops user interface script
 *
 * In this file, you are describing the logic of your user interface, in Javascript language.
 *
 */

var isDebug = true;
var debug = isDebug ? console.info.bind(window.console) : function () { };
define(["dojo", "dojo/_base/declare", "ebg/core/gamegui", "ebg/counter"], function (dojo, declare) {
  return declare("bgagame.mutantcrops", ebg.core.gamegui, {
    /*
     * Constructor
     */
    constructor: function () {
      this._connections = [];
    },

    /*
     * Setup:
     *  This method set up the game user interface according to current game situation specified in parameters
     *  The method is called each time the game interface is displayed to a player, ie: when the game starts and when a player refreshes the game page (F5)
     *
     * Params :
     *  - mixed gamedatas : contains all datas retrieved by the getAllDatas PHP method.
     */
    setup: function (gamedatas) {
      var _this = this;
      debug('SETUP', gamedatas);

      // Add meeples and tokens
      gamedatas.fplayers.forEach(function(player){
        dojo.place( _this.format_block( 'jstpl_player_panel', player) , 'overall_player_board_' + player.id );

        // Meeples
        player.farmers.forEach(function(location, id){
          var meeple = _this.format_block( 'jstpl_player_meeple', { playerId:player.id, farmerId:id, no:player.no });
          dojo.place(meeple , location == null? ('tokens-container-' + player.id) : ('location-' + location) );
        });
      });

      // Display crops
      gamedatas.crops.forEach(function(crop, id){
        var data = gamedatas.cropsData[crop];
        data.index = id;
        data.power3Effect = data.power3Effect.replace("COINS",  "<span class='coin'></span>");
        data.power3Effect = data.power3Effect.replace("WATERS", "<span class='water'></span>");
        data.power3Effect = data.power3Effect.replace("FOODS",  "<span class='food'></span>");
        data.power3Effect = data.power3Effect.replace("SEEDS",  "<span class='seed'></span>");
        dojo.place( _this.format_block( 'jstpl_crop', data) , 'mutantcrops-grid' );
        _this.addTooltipHtml('crop-' + id, _this.format_block( 'jstpl_crop', data), 0);
      });

      // Display fields (only the ones visible at that stage)
      gamedatas.fields.forEach(function(fieldId, index){
        dojo.addClass('field-' + index, 'field-' + fieldId);
      });

       // Setup game notifications
       this.setupNotifications();
     },


     ///////////////////////////////////////
     ////////  Game & client states ////////
     ///////////////////////////////////////

     /*
      * onEnteringState:
      * 	this method is called each time we are entering into a new game state.
      *
      * params:
      *  - str stateName : name of the state we are entering
      *  - mixed args : additional information
      */
     onEnteringState: function (stateName, args) {
       debug('Entering state: ' + stateName, args);

       // Stop here if it's not the current player's turn for some states
       if (["playerAssign"].includes(stateName) && !this.isCurrentPlayerActive())
         return;

       // Call appropriate method
       var methodName = "onEnteringState" + stateName.charAt(0).toUpperCase() + stateName.slice(1);
       if (this[methodName] !== undefined)
         this[methodName](args.args);
     },


     /*
      * onLeavingState:
      * 	this method is called each time we are leaving a game state.
      *
      * params:
      *  - str stateName : name of the state we are leaving
      */
     onLeavingState: function (stateName) {
       debug('Leaving state: ' + stateName);


       this.clearPossible();
     },



     /*
      * onUpdateActionButtons:
      * 	called by BGA framework before onEnteringState
      *  in this method you can manage "action buttons" that are displayed in the action status bar (ie: the HTML links in the status bar).
      */
     onUpdateActionButtons: function (stateName, args) {
       debug('Update action buttons: ' + stateName, args); // Make sure it the player's turn

       if (!this.isCurrentPlayerActive())
         return;

/*
       if ((stateName == "playerMove" || stateName == "playerBuild" || stateName == "playerUsePower")) {
         if (args.skippable) {
           this.addActionButton('buttonSkip', _('Skip'), 'onClickSkip', null, false, 'gray');
         }

         if (args.cancelable) {
           this.addActionButton('buttonCancel', _('Restart turn'), 'onClickCancel', null, false, 'gray');
         }
       }
*/
     },


     /*
 		 * TODO description
 		 */
     takeAction: function (action, data, callback) {
       data = data || {};
       data.lock = true;
       callback = callback || function (res) { };
       this.ajaxcall("/mutantcrops/mutantcrops/" + action + ".html", data, this, callback);
     },



     connect: function(node, action, callback){
       this._connections.push(dojo.connect(node, action, callback));
     },

     /*
      * clearPossible:
      * 	clear every clickable space and any selected worker
      */
     clearPossible: function clearPossible() {
       this.removeActionButtons();
       this.onUpdateActionButtons(this.gamedatas.gamestate.name, this.gamedatas.gamestate.args);

       this._selectedFarmer = null;
       dojo.query(".meeple").removeClass("selectable selected");
       dojo.query(".field > div").removeClass("selectable");
       this._connections.forEach(dojo.disconnect);
       this._connections = [];
     },




     /////////////////////////////////
     /////////////////////////////////
     /////////    Assign    //////////
     /////////////////////////////////
     /////////////////////////////////

     /*
      * playerAssign: TODO
      */
     onEnteringStatePlayerAssign: function (args) {
       var _this = this;

       this._availableLocations = args.availableLocations;
       this.makeFarmersSelectable( (args.location == "hand")? this.getFarmerInHand() : this.getPlayerFarmers() );
     },


     /*
      * makeFarmersSelectable:
      */
     makeFarmersSelectable: function (farmers) {
       var _this = this;
       this._selectableFarmers = farmers;

       // If only one farmer can work, automatically select it
       if (this._selectableFarmers.length == 1)
        this.onClickSelectFarmer(this._selectableFarmers[0]);
       // Otherwise, let the user make the choice
       else if (this._selectableFarmers.length > 1) {
         this._selectableFarmers.addClass("selectable").forEach(function(meeple){
           _this.connect(meeple, "onclick", function(evt){ evt.preventDefault(); evt.stopPropagation();_this.onClickSelectFarmer(meeple); });
         });
       }
     },



     /*
      * onClickFarmer: TODO
      */
     onClickSelectFarmer: function(farmer){
       var _this = this;
       var farmerId = farmer.getAttribute('data-farmerId');

       this.clearPossible();
       this._selectedFarmer = farmerId;
       dojo.addClass("meeple-" + this.getActivePlayerId() + "-" + farmerId, "selected");

       if (this._selectableFarmers.length > 1) {
         this.addActionButton('buttonReset', _('Cancel'), 'onClickCancelSelect', null, false, 'gray');
       }

       this._availableLocations.forEach(function(locationId){
         dojo.addClass('location-' + locationId, 'selectable');
         _this.connect($('location-' + locationId), 'onclick', function(evt){ evt.preventDefault(); evt.stopPropagation(); _this.onClickLocation(locationId); });
       });
     },


     /*
      * onClickCancelSelect:
      * 	triggered after a click on the action button "buttonReset".
      *  unselect the previously selected worker and make every worker selectable
      */
     onClickCancelSelect: function (evt) {
       dojo.stopEvent(evt);
       this.clearPossible();
       this._selectedFarmer = null;
       this.makeFarmersSelectable(this._selectableFarmers);
     },



     /*
      * onClickLocation: TODO
      */
     onClickLocation: function(locationId){
       if (!this.checkAction('assign')) return false;

       this.takeAction('assign', {
         farmerId: this._selectedFarmer,
         locationId: locationId,
       });
       this.clearPossible();
     },


     /*
      * notif_farmerAssigned: TODO
      */
     notif_farmerAssigned: function (n) {
       debug('Notif: farmer assigned', n.args);

       var _this = this;
       var meeple = "meeple-" + n.args.playerId + "-" + n.args.farmerId;
       var location = "location-" + n.args.locationId;

       this.attachToNewParent(meeple, location);
       this.slide(meeple, location, 1200);
     },


     notif_addResources: function (n) {
       debug('Notif: adding resources to a player', n.args);
       this.addResources(n.args.locationId, n.args.playerId, n.args.type, n.args.n, n.args.total, 0);
     },

     notif_addMultiResources: function (n) {
       debug('Notif: adding several type of resources to a player', n.args);

       this.addResources(n.args.locationId, n.args.playerId, "food", n.args.nFood, n.args.totalFood, 0);
       this.addResources(n.args.locationId, n.args.playerId, "water", n.args.nWater, n.args.totalWater, 1);
       this.addResources(n.args.locationId, n.args.playerId, "seeds", n.args.nSeeds, n.args.totalSeeds, 2);
     },


     ///////////////////////////////////////
     ////////    Utility methods    ////////
     ///////////////////////////////////////

     /*
      * // TODO:
      */
     slide: function (sourceId, targetId, duration, delay) {
       var _this = this;
       return new Promise(function (resolve, reject) {
         var animation = _this.slideToObject(sourceId, targetId, duration, delay);
         dojo.connect(animation, 'onEnd', resolve);
         animation.play();
       });
     },


     getPlayerFarmers: function(playerId){
       playerId = playerId || this.getCurrentPlayerId();
       var no = this.gamedatas.fplayers.reduce(function(carry, player){
         return (player.id == playerId)? player.no : carry;
       }, 1);

       return dojo.query("#board .meeple-" + no);
     },


     getFarmerInHand: function(playerId){
       playerId = playerId || this.getCurrentPlayerId();
       return dojo.query("#overall_player_board_" + this.getCurrentPlayerId() + " .meeple")[0];
     },


     addResources: function(locationId, playerId, type, n, total, delay){
       debug("Adding resource : " + n + " " + type);
       var container = "tokens-container-" + playerId,
           location  = "location-" + locationId;

       for(var i = 0; i < n; i++){
         this.slideTemporaryObject(this.format_block( 'jstpl_token', { type:type }), container, location, container, 2000, (i + delay)*100);
       }

       setTimeout(function(){
         dojo.query("#" + container + " .token-" + type)[0].innerHTML = "x" + total;
       }, 2000 + n*100);
     },

     ///////////////////////////////////////////////////
     //////   Reaction to cometD notifications   ///////
     ///////////////////////////////////////////////////

     /*
      * setupNotifications:
      *  In this method, you associate each of your game notifications with your local method to handle it.
      *	Note: game notification names correspond to "notifyAllPlayers" and "notifyPlayer" in the santorini.game.php file.
      */
     setupNotifications: function () {
       var notifs = [
         ['farmerAssigned', 1000],
         ['addResources', 2000],
         ['addMultiResources', 2000],
       ];
/*
         ['cancel', 1000],
         ['automatic', 1000],
         ['addOffer', 500],
         ['removeOffer', 500],
         ['powerAdded', 1200],
         ['workerPlaced', 1000],
         ['workerMoved', 1600],
       ];
*/

       var _this = this;
       notifs.forEach(function (notif) {
         dojo.subscribe(notif[0], _this, "notif_" + notif[0]);
         _this.notifqueue.setSynchronous(notif[0], notif[1]);
       });
     }
   });
});
