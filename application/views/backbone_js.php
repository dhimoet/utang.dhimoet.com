<script type="text/javascript">

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

</script>
