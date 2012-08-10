function get_user_list(data) {

	/*** models ***/
	var User = Backbone.Model.extend({
		defaults: {
			username: "",
			email: "",
			photo: "/static/img/placeholder.gif"
		}
	});

	/*** collections ***/
	var UserList = Backbone.Collection.extend({
		model: User
	});

	/*** views ***/
	var UserView = Backbone.View.extend({
		tagName: "user",
		className: "user_container",
		template: $('#user_template').html(),
		render: function() {
			var tmpl = _.template(this.template);
			this.$el.html(tmpl(this.model.toJSON()));
			return this;
		}
	});

	var UserListView = Backbone.View.extend({
		el: $('#user_list'),
		initialize: function() {
			this.collection = new UserList(JSON.parse(data));
			this.render();
		},
		render: function() {
			var that = this;
			_.each(this.collection.models, function(item) {
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
	
	var user_list = new UserListView();

}
