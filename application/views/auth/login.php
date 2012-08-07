<div data-role='page' data-title='login'>
  
	<div data-theme='b' data-role='header' data-position='fixed'>
		<h3>Login</h3>
		<a href='/auth/create_user/' data-role='button' data-icon='plus'>Sign Up</a>
	</div>
  
	<div data-role='content'>
  
		<div class="margin_50_0">
			
			<form name='login' action='/auth/login' method='post' data-ajax='false'>
	 
				<p>
					<label for="identity">Email:</label>
					<input type='text' name='identity' value='' />
				</p>
			  
				<p>
					<label for="password">Password:</label>
					<input type='password' name='password' value='' />
				</p>
			  
				<label><input type="checkbox" name="remember" /> Remember Me </label>
				  
				<input type='submit' name='login' value='Login' data-theme='e'/>
			  
			</form>
			
		</div>
	
		<hr />
		
		<div class="margin_50_0">
			
			<a href='/utang/signup' data-role='button' data-theme='b'>Login Using Facebook</a>
			
		</div>
	
	</div><!-- content container -->
  
	<div data-role='header' style='position:fixed; bottom:0px;'></div>

</div><!-- index container -->
