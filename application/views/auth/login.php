<div data-role='page' data-title='login' id='login'>
  
	<div data-theme='b' data-role='header' data-position='fixed'>
		<h3>Login</h3>
		<a href='/auth/create_user/' data-role='button' data-icon='plus'>Sign Up</a>
	</div>
  
	<div data-role='content'>
		
		<div class="bottom_40">
			
			<a href='/fb/login/' data-role='button' data-theme='b' data-ajax="false">Login With Facebook</a>
			
		</div>
	
		<hr />
		
		<div class="top_40">
			
			<form name='login' action='/auth/login' method='post' data-ajax='false'>
	 
				<p>
					<label for="identity">Email:</label>
					<input type='text' name='identity' value='' class="validate[required,custom[email]]"/>
				</p>
			  
				<p>
					<label for="password">Password:</label>
					<input type='password' name='password' value='' class="validate[required]"/>
				</p>
			  
				<label><input type="checkbox" name="remember" /> Remember Me </label>
				  
				<input type='submit' name='login' value='Login' data-theme='e'/>
			  
			</form>
			
		</div>
	
	</div><!-- content container -->
  
	<div data-role='header' style='position:fixed; bottom:0px;'></div>

</div><!-- index container -->

