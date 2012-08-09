	<div data-role='content'>
		
		<form name='add_transaction' action="/main/add_transaction/" method="post" id='add_transaction' data-ajax="false">
		
			<div class='details_label'>Transaction with:</div>
			
			<div>
				<select name="add_transaction[user]" id="user">
					<option value='First Last'>First Last</option>
					<option value='First Last'>First Last</option>
					<option value='First Last'>First Last</option>
					<option value='First Last'>First Last</option>
				</select>
			</div>
			
			<div class='details_label'>Action:</div>
			
			<div class="ui-grid-a">
				<div class="ui-block-a">
					<select name="add_transaction[action]" id="action">
						<option value='I gave'>I gave</option>
						<option value='I received'>I received</option>
					</select>
				</div>
				<div class="ui-block-b amount_input">  
					<label for='add_transaction[amount]'>$</label>
					<input type="text" name="add_transaction[amount]" id="amount" class="validate[required,custom[number]]" placeholder="0.00" />
				</div>
			</div>
			
			<div class='details_label'>Title:</div>
			
			<div>
				<input type='text' name="add_transaction[title]" id="title" class="validate[required]" placeholder='Enter a brief comment' />
			</div>
			
			<div class='details_label'>Description:</div>
			
			<div>
				<textarea name="add_transaction[description]" id="description" placeholder='Enter longer comments'></textarea>
			</div>
			
			<div>
				<input type='submit' value='Add Now!' data-theme='b' />
			</div>
			
		</form>
		
	</div><!-- content container -->
