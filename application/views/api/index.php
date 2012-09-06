<script>
	requirejs.config({
		baseUrl: "/",
		paths: {
			jquery: "static/js/jquery-1.8.1.min",
			underscore: "static/js/underscore-min",
			backbone: "static/js/backbone-min"
		},
		shim: {
			jquery: {
				exports: "$"
			},
			underscore: {
				exports: "_"
			},
			backbone: {
				deps: ['underscore', 'jquery'],
				exports: "Backbone"
			}
		}
	});
	require(['jquery', 'underscore', 'backbone'], 
	function($, _, Backbone) {
		
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
			initialize: function() {
				this.collection = new FriendsCollection();
				this.collection.fetch();
				this.render();
			},
			render: function() {
				var that = this;
				_.each(this.collection.models, function(item) {
					console.log(item);
				}, this);
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
