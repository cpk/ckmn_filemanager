
	
		
		
		
		<!--
		===========================================================
		BEGIN PAGE
		===========================================================
		-->
		<div class="login-header text-center">
			<img src="<?php echo $webroot; ?>/img/logo-login.png" class="logo" alt="Logo">
		</div>
		<div class="login-wrapper">
			<div class="alert alert-warning alert-bold-border fade in alert-dismissable">
			  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			  <strong>Warning!</strong> Better check yourself, you're <a href="#fakelink" class="alert-link">not looking too good</a>.
			</div>
                        <?php echo $this->Form->create('User', array('class' => 'form-horizontal', 'role' => 'form') ); ?>
				<div class="form-group has-feedback lg left-feedback no-label">
                                  <?php echo $this->Form->input('username', array('class'=> 'form-control no-border input-lg rounded', 'label'=>false, 'div'=>false, 'placeholder'=>'Enter Email or Username')); ?>
				  <span class="fa fa-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback lg left-feedback no-label">
                                  <?php echo $this->Form->input('password', array('label'=>false,'class'=> 'form-control no-border input-lg rounded', 'div'=>false, 'placeholder'=>'Enter Password')); ?>				  
				  <span class="fa fa-unlock-alt form-control-feedback"></span>
				</div>
				<div class="form-group">
				  <div class="checkbox">
					<label>
					  <input type="checkbox" class="i-yellow-flat"> Remember me
					</label>
				  </div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-warning btn-lg btn-perspective btn-block">LOGIN</button>
				</div>
			<?php echo $this->Form->end(); ?>
			<p class="text-center"><strong><a href="forgot-password.html">Forgot your password?</a></strong></p>
			<p class="text-center">or</p>
			<p class="text-center"><strong><a href="register.html">Create new account</a></strong></p>
		</div><!-- /.login-wrapper -->
		<!--
		===========================================================
		END PAGE
		===========================================================
		-->
		
		