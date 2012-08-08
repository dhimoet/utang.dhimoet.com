<div data-role='page' data-title='signup' id='signup'>
  
	<div data-theme='b' data-role='header' data-position='fixed'>
		<h3>Sign Up</h3>
		<a data-rel="back" data-role='button' data-icon='back'>Back</a>
	</div>
  
	<div data-role='content'>
  
		<form name='signup' action='/auth/create_user' method='post' data-ajax='false'>

			<div class="ui-grid-a">
				<p class="ui-block-a">
					<label for="first_name">First Name:</label>
					<input type='text' name='first_name' value='' class="validate[required]"/>
				</p>
				<p class="ui-block-b">
					<label for="last_name">Last Name:</label>
					<input type='text' name='last_name' value='' class="validate[required]"/>
				</p>
			</div>
      
			<p>
				<label for="email">Email:</label>
				<input type='text' name='email' value='' class="validate[required,custom[email]]"/>
			</p>
      
			<div class="ui-grid-a">
				<p class="ui-block-a">
					<label for="password">Password:</label>
					<input type='password' name='password' value='' class="validate[required]"/>
				</p>
				<p class="ui-block-b">
					<label for="password_confirm">Confirm Password:</label>
					<input type='password' name='password_confirm' value='' class="validate[required]"/>
				</p>
			</div>
          
			<input type='submit' name='login' value='Sign Up!' data-theme='b'/>
      
		</form>
    
	</div><!-- content container -->
  
	<div data-role='footer' style='position:fixed; z-index: 999; bottom:0px;'></div>

</div><!-- index container -->
