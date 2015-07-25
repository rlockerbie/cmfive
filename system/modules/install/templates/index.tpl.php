<div class="row-fluid">
	<div class="columns large-12">
		<div class="steps">
			<ul class="clearfix">
				<li class="<?php echo $step == 1 ? 'active' : ($step > 1 ? 'complete' : ''); ?>">1</li>
				<li class="<?php echo $step == 2 ? 'active' : ($step > 2 ? 'complete' : ''); ?>">2</li>
				<li class="<?php echo $step == 3 ? 'active' : ($step > 3 ? 'complete' : ''); ?>">3</li>
				<li class="<?php echo $step == 4 ? 'active' : ($step > 4 ? 'complete' : ''); ?>">4</li>
			</ul>
		</div>
	</div>
	<div class="columns large-12">
		<h4 class="subheader">Step <?php echo $step; ?> &ndash; <?php echo $step_description; ?></h4>
	</div>
	<div class="columns large-12">
		<?php if( isset($error) ): ?>
		<div data-alert class="alert-box alert">
			<?php echo $error; ?>
		</div>
		<?php endif; ?>
		<?php if( isset($info) ): ?>
		<div data-alert class="alert-box success">
			<?php echo $info; ?>
		</div>
		<?php endif; ?>
	<?php if( $step == 1 ): ?>
		<form method="post" data-abide action="<?php echo $form_action; ?>">
			<fieldset>
				<legend>Database connection</legend>
				<div class="hostname-field">
					<label>Hostname <small>Required</small></label>
					<input type="text" placeholder="Hostname" required value="<?php echo empty($_POST['db_hostname']) ? 'localhost' : $_POST['db_hostname']; ?>" name="db_hostname" />
					<small class="error">Hostname is required</small>
				</div>
				<div class="username-field">
					<label>Username <small>Required</small></label>
					<input type="text" placeholder="Username" required value="<?php echo empty($_POST['db_username']) ? '' : $_POST['db_username']; ?>" name="db_username" />
					<small class="error">Username is required</small>
				</div>
				<div class="password-field">
					<label>Password</label>
					<input type="password" placeholder="Password" value="<?php echo empty($_POST['db_password']) ? '' : $_POST['db_password']; ?>" name="db_password" />
				</div>
				<div class="port-field">
					<label>Port</label>
					<input type="number" placeholder="Port" value="<?php echo empty($_POST['db_port']) ? '' : $_POST['db_port']; ?>" name="db_port" />
				</div>
				<div class="driver-field">
					<label>Driver <small>Required</small></label>
					<select name="db_driver" required="true">
						<?php echo $driver_options; ?>
					</select>
					<small class="error">Hostname is required</small>
				</div>
				<button class="button" type="submit">Check connection</button>
			</fieldset>
		</form>
	<?php elseif( $step == 2 ): ?>
		<form method="post" action="<?php echo $form_action; ?>">
			<fieldset>
				<legend>Select database</legend>
				<table>
					<tbody>
						<?php foreach($databases as $database=>$tables): ?>
						<tr>
							<td>
								<div class="switch tiny round">
									<input id="database_<?php echo $database; ?>" required="true" type="radio" name="db_database" value="<?php echo $database; ?>" />
									<label for="database_<?php echo $database; ?>"></label>
								</div>
							</td>
							<td>
								<label for="database_<?php echo $database; ?>"><?php echo $database; ?>
								<?php if(!empty($tables)): ?>
								<span class="label round alert">This database is not empty, existing tables will be removed!</span>
								<?php else: ?>
								<span class="label round success">This database is empty</span>
								<?php endif; ?>
								</label>
							</td>
						<?php endforeach; ?>
					</tbody>
				</table>
				<button class="button" type="submit">Import required tables</button>
			</fieldset>
		</form>
	<?php elseif( $step == 3 ): ?>
		<form method="post" data-abide action="<?php echo $form_action; ?>">
			<fieldset>
				<legend>Access settings</legend>
				<h4>Admin user details</h4>
				<div class="username-field">
					<label for="admin_username">Username <small>Required</small></label>
					<input type="text" id="admin_username" required placeholder="admin" pattern="alpha_numeric" value="<?php echo empty($_POST['admin_user']) ? '' : $_POST['admin_user']; ?>" name="admin_user" />
					<small class="error">Username is required</small>
				</div>
				<div class="password-field">
					<label for="admin_password">Password <small>Required</small></label>
					<input type="password" id="admin_password" required placeholder="password" value="<?php echo empty($_POST['admin_password']) ? '' : $_POST['admin_password']; ?>" name="admin_password" />
					<small class="error">Password is required</small>
					<div class="row password-strength-c hide">
						<div class="columns large-12">
							<h6>Password strength</h6>
							<div data-alert class="alert-box info password-strength">
								<div class="password-strength-p radius progress success large-12">
									<span class="meter"></span>
								</div>
								<span class="text"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="firstname-field">
					<label for="firstname">First name</label>
					<input type="text" id="firstname" placeholder="Administrator" value="<?php echo empty($_POST['firstname']) ? 'Administrator' : $_POST['firstname']; ?>" name="firstname" />
				</div>
				<div class="lastname-field">
					<label for="lastname">Last name</label>
					<input type="text" id="lastname" placeholder="Last name" value="<?php echo empty($_POST['lastname']) ? '' : $_POST['lastname']; ?>" name="lastname" />
				</div>
				<div class="email-field">
					<label for="email">Email</label>
					<input type="email" id="email" placeholder="Last name" value="<?php echo empty($_POST['email']) ? '' : $_POST['email']; ?>" name="email" />
				</div>
				<script>
				$('#admin_password').keyup(function() {
					if(this.value.length == 0) {
						$('.password-strength-c').addClass('hide');
					} else {
						$('.password-strength-c').removeClass('hide');
					}
					var s = zxcvbn(this.value);
					$('.password-strength .text').text('Time to crack this password: '+s.crack_time_display);
					$('.password-strength-p span').css('width', (s.score / 4 * 100)+'%');
				});
				</script>
				<hr />
				<h4>CSRF</h4>
				<label>Enable CSRF protection</label>
				<div class="row">
					<div class="columns large-1">
						<div class="switch tiny round">
							<input id="checkCSRF" checked="checked" type="checkbox" name="checkCSRF" value="yes" />
							<label for="checkCSRF"></label>
						</div>
					</div>
					<div class="columns large-8"></div>
				</div>
				<h4>Anonymous access</h4>
				<p>IP bypass: bypass authentication if sent from the following IP addresses</p>
				<div class="row">
					<div class="columns large-8 ip-list">
						<div class="no-ips-set">No IP's set</div>
					</div>
					<div class="columns large-4">
						<button type="button" id="add_ip_address" class="button radius success tiny">Add IP</button>
					</div>
				</div>
				<script>
					var ipId = 0;
					$('#add_ip_address').click(function() {
						$('.ip-list').append('<div class="row"><div class="ip-field"><div class="columns large-8"><input placeholder="0.0.0.0" type="text" required name="allow_from_ip[]" pattern="ip_address" /><small class="error">Valid IP address required.</small></div><div class="columns large-4"><button type="button" class="button radius tiny alert">Remove</button></div></div></div>');
						$('.no-ips-set').addClass('hide');
						$(document).foundation('abide');
						ipId++;
					});
					$('.ip-list').on('click', 'button', function() {
						$(this).parent().parent().remove();
						ipId--;
						if(ipId == 0) {
							$('.no-ips-set').removeClass('hide');
						}
					});
				</script>
			</fieldset>
			<fieldset>
				<legend>General configuration</legend>
				<h4>Application information</h4>
				<label>Application name</label><input type="text" placeholder="Cmfive" value="<?php echo empty($_POST['app_name']) ? 'Cmfive' : $_POST['app_name']; ?>" name="app_name" />
				<label>Company name</label><input type="text" placeholder="2pi Software" value="<?php echo empty($_POST['company_name']) ? '2pi Software' : $_POST['company_name']; ?>" name="company_name" />
				<label>Company url</label><input type="url" placeholder="http://2pisoftware.com" value="<?php echo empty($_POST['company_url']) ? 'http://2pisoftware.com' : $_POST['company_url']; ?>" name="company_url" />
				<hr />
				<h4>Timezone</h4>
				<label>Timezone</label>
				<input type="text" id="timezone" placeholder="Australia/Sydney" value="<?php echo empty($_POST['timezone']) ? 'Australia/Sydney' : $_POST['timezone']; ?>" name="timezone" />
				<script>
				var availableTimezones = <?php echo json_encode(DateTimeZone::listIdentifiers()); ?>;
				$('#timezone').autocomplete({source:availableTimezones});
				</script>
				<hr />
				<h4>Email</h4>
				<label>Layer</label><input type="text" placeholder="smtp" value="<?php echo empty($_POST['email_layer']) ? 'smtp' : $_POST['email_layer']; ?>" name="email_layer" />
				<label>Host</label><input type="text" placeholder="smtp.gmail.com" value="<?php echo empty($_POST['email_host']) ? 'smtp.gmail.com' : $_POST['email_host']; ?>" name="email_host" />
				<label>Port</label><input type="text" placeholder="465" value="<?php echo empty($_POST['email_port']) ? '465' : $_POST['email_port']; ?>" name="email_port" />
				<label>Authentication required</label>
				<div class="row">
					<div class="columns large-1">
						<div class="switch tiny round">
							<input id="email_auth_true" checked="checked" type="checkbox" name="email_auth" value="yes" />
							<label for="email_auth_true"></label>
						</div>
					</div>
					<div class="columns large-8"></div>
				</div>
				<label for="email_username">Username</label><input type="text" id="email_username" placeholder="username" value="<?php echo empty($_POST['email_username']) ? '' : $_POST['email_username']; ?>" name="email_username" />
				<label for="email_password">Password</label><input type="password" id="email_password" placeholder="password" value="<?php echo empty($_POST['email_password']) ? '' : $_POST['email_password']; ?>" name="email_password" />
				<hr />
				<h4>REST</h4>
				<p>Use the API_KEY to authenticate with username and password</p>
				<label>API Key</label><input type="text" placeholder="password" value="<?php echo empty($_POST['rest_api_key']) ? 'abcdefghijklmnopqrstuvwxyz1234567890' : $_POST['rest_api_key']; ?>" name="rest_api_key" />
				<button class="button" type="submit">Complete configuration</button>
			</fieldset>
		</form>
		<script>
		$(function() {
			$('#email_auth_true').change(function() {
				if(this.checked) {
					$('#email_password, #email_username').prop('disabled', false);
				} else {
					$('#email_password, #email_username').prop('disabled', true);
				}
			});
		});
		</script>
	<?php elseif($step == 4): ?>
		<h4>You are all set!</h4>
		<button class="button" type="button" onclick="window.location='/';">Login</button>
	<?php endif; ?>
	</div>
</div>