<script type="text/javascript">

	/***
	 *  models 
	 * 
	 * ***/
	var User = Backbone.Model.extend({
		defaults: {
			username: "",
			email: "",
			photo: "/static/img/placeholder.gif"
		}
	});

	var Notification = Backbone.Model.extend({
		defaults: {
			username: "",
			type: "added_transaction"
		}
	});

	/*** 
	 * collections 
	 * 
	 * ***/
	var UserList = Backbone.Collection.extend({
		model: User
	});

	var NotificationList = Backbone.Collection.extend({
		model: Notification
	});

	/*** 
	 * views 
	 * 
	 * ***/
	var UserView = Backbone.View.extend({
		tagName: "li",
		className: "ui-li ui-li-static ui-body-c",
		template: $('#user_template').html(),
		render: function() {
			var tmpl = _.template(this.template);
			this.$el.html(tmpl(this.model.toJSON()));
			return this;
		}
	});

	var UserListView = Backbone.View.extend({
		el: $('#user_list'),
		initialize: function(key) {
			
			this.collection = new UserList(data);
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

	var NotificationListView = Backbone.View.extend({
		el: $('#notification_list'),
		initialize: function() {
			this.collection = new NotificationList(JSON.parse(data));
			this.render();
		},
		render: function() {
			var that = this;
			_.each(this.collection.models, function(item) {
				that.renderNotification(item);
			}, this);
		},
		renderNotification: function(item) {
			var notificationView = new NotificationView({
				model: item
			});
			this.$el.append(notificationView.render().el);
		}
	});

</script>