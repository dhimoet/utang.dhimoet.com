<script type="text/javascript">
(function($){

	<? if($title == 'Add Friend') {?> //---------------------- add_friend
		 
		/*** model ***/
		
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
		
		/*** collection ***/
		
		var UserList = Backbone.Collection.extend({
			model: User,
			url: function() {
				return '/ajax/get_users/';
			}
		});
		var userList = new UserList;
		
		/*** views ***/
		
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
				var user = this.model.toJSON();
				var username = user.facebook_username;
				this.$el.html(this.template(user));
				this.model.set('photo', 'http://graph.facebook.com/'+username+'/picture');
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
		
	<?} if(isset($_GET['msg'])) {?> //---------------------- any pages with $_GET['msg'] set
		
		/*** model ***/
		
		var OverlayModel = Backbone.Model.extend({
			defaults: {
				title: "Error",
				content: "Your last action was not executed successfully."
			},
			clear: function() {
				this.destroy();
			}
		});
		
		/*** collection ***/
		
		var OverlayCollection = Backbone.Collection.extend({
			model: OverlayModel
		});
		
		/*** views ***/
		
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
				$('#overlay_container').show();
			},
			events: {
				"click #overlay_ok_button" : "closeOverlay",
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
		
		/*** local storage ***/
		
		var message = [
			{ title: "Error!", content: "Your last action was not executed successfully."},
			{ title: "Thank you!", content: "Your report has been sent and will be reviewed shortly."},
			{ title: "Not found!", content: "The user you are looking for is not registered on our system."},
			{ title: "Saved!", content: "The transaction has been saved. Your friend will be notified on his/her notification page."},
			{ title: "Sent!", content: "Your message has been written to your Facebook newsfeed."},
			{ title: "Deleted!", content: "Your recent transaction has been deleted."},
			{ title: "Sent!", content: "Your friend request has been sent. Please notify your friend to approve it."},
			{ title: "Error!", content: "It appeared you entered the same input more than once. Please make sure only the first input was stored."},
		];
		
		/*** execute ***/
		
		var overlay_show = new OverlayWhole(<?=$_GET['msg'];?>);
		
	<?}?>	

} (jQuery));

	
	
</script>
