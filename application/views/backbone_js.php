<script type="text/javascript">
	(function($){

		/***
		 *  models 
		 * 
		 * ***/
		var User = Backbone.Model.extend({
			defaults: {
				username: "n/a",
				email: "n/a",
				photo: "/static/img/placeholder.gif"
			},
			clear: function() {
				this.destroy();
			}
		});
		
		/*******************/
		
		var OverlayModel = Backbone.Model.extend({
			defaults: {
				title: "Error",
				content: "Your last action was not executed successfully."
			},
			clear: function() {
				this.destroy();
			}
		});

		/*** 
		 * collections 
		 * 
		 * ***/
		var UserList = Backbone.Collection.extend({
			model: User,
			url: function() {
				return '/ajax/get_users/';
			}
		});
		var userList = new UserList;
		
		/*******************/
		
		var OverlayCollection = Backbone.Collection.extend({
			model: OverlayModel
		});
		//var overlay = new OverlayCollection;

		/*** 
		 * views 
		 * 
		 * ***/
		var UserView = Backbone.View.extend({
			tagName: "li",
			className: "ui-li ui-li-static ui-body-c",
			template: _.template($('#user_template').html()),
			events: {
				"click a" : "updateInputText"
			},
			initialize: function() {
				this.model.bind('change', this.render, this);
				this.model.bind('destroy', this.remove, this);
			},
			render: function() {
				this.$el.html(this.template(this.model.toJSON()));
				return this;
			},
			updateInputText: function() {
				$('#name').val(this.model.get('username'));
				$('#email').val(this.model.get('email'));	
			},
			clear: function() {
				this.model.clear();
			}
		});

		var UserListView = Backbone.View.extend({
			el: $('#user_list'),
			initialize: function(key) {
				userList.fetch({
					type: 'post',
					data: {key:key}
				});
				userList.bind('reset', this.render, this);
			},
			render: function() {
				var that = this;
				// clear out this element
				$(this.el).empty();
				_.each(userList.models, function(item) {
					that.renderUser(item);
				}, this);
			},
			renderUser: function(item) {
				var userView = new UserView({
					model: item
				});
				this.$el.append(userView.render().el);
			}
		});
		
		/*******************/
		
		var OverlayView = Backbone.View.extend({
			tagName: "div",
			template: _.template($('#overlay_template').html()),
			initialize: function() {
				this.render();
			},
			render: function() {
				this.$el.html(this.template(this.model.toJSON()));
				return this;
			},
			clear: function() {
				this.model.clear();
			}
		});
		
		var OverlayWhole = Backbone.View.extend({
			el: $('#overlay_container'),
			initialize: function(message_id) {
				this.collection = new OverlayCollection(message[message_id]);
				this.render();
				this.openOverlay();
			},
			render: function() {
				var that = this;
				_.each(this.collection.models, function(item) {
					that.renderOverlay(item);
				}, this);
			},
			renderOverlay: function(item) {
				var overlayView = new OverlayView({
					model: item
				});
				this.$el.append(overlayView.render().el);
			},
			openOverlay: function() {
				var screen_width = $(window).width();
				var screen_height = $(window).height();
				var window_width = screen_width * 50/100;
				var window_height = screen_height * 50/100;
				
				$('#overlay_container').show();
				$('#overlay_window').css('top', (screen_height/2) - (window_height/2));
				$('#overlay_window').css('left', (screen_width/2) - (window_width/2));
			},
			events: {
				"click #overlay_ok_button" : "closeOverlay",
				"click #overlay_close_button" : "closeOverlay",
			},
			closeOverlay: function() {
				var that = this;
				_.each(this.collection.models, function(item) {
					that.destroyOverlay(item);
				}, this);
				$('#overlay_container').hide();
			},
			destroyOverlay: function(item) {
				var overlayView = new OverlayView({
					model: item
				});
				this.$el.empty();
			},
		});
		
		/*** 
		 * local storage 
		 * 
		 * ***/
		
		var message = [
			{ title: "Error!", content: "Your last action was not executed successfully."},
		];
		
		/*** 
		 * executions 
		 * 
		 * ***/
		
		<?if(isset($_GET['msg'])) {?> 
			var overlay_show = new OverlayWhole(<?=$_GET['msg'];?>);
		<?}?>
		
		<?if($title == 'Add Friend') {?>
		$(document).ready(function() {
			/*** search for user names ***/
			$('#name').keyup(function() {
				if(!($('#name').val().length % 3) && $('#name').val().length) {
					var key = $('#name').val();
					// call backbone
					var user_list = new UserListView(key);
				}
			});
		});
		<?}?>
	} (jQuery));

	
	
</script>
