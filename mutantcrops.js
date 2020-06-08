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
    constructor: function () { },

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
       if(args.location == "hand"){
         var meeple = dojo.query("#overall_player_board_" + this.getCurrentPlayerId() + " .meeple")[0];
         this.onClickFarmer(meeple.getAttribute('data-farmerId'));
       }
       /*
       else {

       }
       */
     },



     /*
      * onClickFarmer: TODO
      */
     onClickFarmer: function(farmerId){
       var _this = this;

       this._selectedFarmer = farmerId;
       dojo.query(".meeple").removeClass("selectable");
       dojo.addClass("meeple-" + this.getActivePlayerId() + "-" + farmerId, "selected");

       this._availableLocations.forEach(function(locationId){
         dojo.addClass('location-' + locationId, 'selectable');
         dojo.connect($('location-' + locationId), 'onclick', function(){ _this.onClickLocation(locationId); });
       });
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


     ///////////////////////////////////////
     ////////    Utility methods    ////////
     ///////////////////////////////////////

     /*
      * // TODO:
      */
     slide: function slide(sourceId, targetId, duration, delay) {
       var _this = this;
       return new Promise(function (resolve, reject) {
         var animation = _this.slideToObject(sourceId, targetId, duration, delay);
         dojo.connect(animation, 'onEnd', resolve);
         animation.play();
       });
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
