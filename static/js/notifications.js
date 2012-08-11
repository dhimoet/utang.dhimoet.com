function get_notification_list(data) {

	/*** models ***/
	var Notification = Backbone.Model.extend({
		defaults: {
			username: "",
			type: "added_transaction"
		}
	});

	/*** collections ***/
	var NotificationList = Backbone.Collection.extend({
		model: Notification
	});

	/*** views ***/
	var NotificationView = Backbone.View.extend({
		tagName: "li",
		className: "ui-li ui-li-static ui-body-c",
		template: $('#notification_template').html(),
		render: function() {
			var tmpl = _.template(this.template);
			this.$el.html(tmpl(this.model.toJSON()));
			return this;
		}
	});

	var UserListView = Backbone.View.extend({
		el: $('#notification_list'),
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
