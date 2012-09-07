<ul id="friends_list"></ul>

<script>
	requirejs.config({
		baseUrl: "/",
		paths: {
			jquery: "static/js/jquery-1.8.1.min",
			underscore: "static/js/underscore-min",
			backbone: "static/js/backbone-min",
			text: "static/js/text"
		},
		shim: {
			jquery: {
				exports: "$"
			},
			underscore: {
				deps: ['text'],
				exports: "_"
			},
			backbone: {
				deps: ['underscore', 'jquery'],
				exports: "Backbone"
			}
		}
	});
	require(['jquery', 'underscore', 'backbone', 'text!static/templates/backbone.html'], 
	function($, _, Backbone, Template) {
		
		/**
		 * collections
		 */
		var FriendsCollection = Backbone.Collection.extend({
			url: "/api/friends",
		});

		/**
		 * views
		 */		
		var FriendsView = Backbone.View.extend({
			el: $('#friends_list'),
			initialize: function() {
				var that = this;
				that.collection = new FriendsCollection();
				that.collection.fetch({
					success: function() {
						that.render();
					}
				});
			},
			render: function() {
				var that = this;
				_.each(that.collection.models, function(items) {
					//console.log(items);
					that.renderEach(items);
				}, this);
			},
			renderEach: function(item) {
				var friendView = new FriendView({
					model: item
				});
				this.$el.append(friendView.render().el);
			}
		});
		
		var FriendView = Backbone.View.extend({
			tagName: "li",
			//template: $('#friends_collection_template').html(),
			render: function() {
				var tmpl = _.template(Template);
				//console.log(this.model.toJSON());
				this.$el.html(tmpl(this.model.toJSON()));
				return this;
			}
		});
		
		/**
		 * routers
		 */
		var AppRouter = Backbone.Router.extend({
			routes: {
				"get_friends": "get_friends",
				"*any": "default_route"
			},
			get_friends: function() {
				var friends_view = new FriendsView();
			},
			default_route: function() {
				alert(0);
			}
		});
		// Initiate the router
		var app_router = new AppRouter;
		// Start Backbone history a neccesary step for bookmarkable URL's
		Backbone.history.start();
		
	});
</script>
