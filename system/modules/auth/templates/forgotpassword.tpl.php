<form method="POST" action="/auth/forgotpassword">
    <input type="hidden" name="<?php echo CSRF::getTokenID(); ?>" value="<?php echo CSRF::getTokenValue(); ?>" />
	<label for="login">Login</label>
	<input id="login" name="login" type="text" placeholder="Your login" />
	<button type="submit" class="button large-5 small-12">Submit</button>
	<a href="/auth/login" class="button secondary large-5 small-12 right">Back</a>
</form>