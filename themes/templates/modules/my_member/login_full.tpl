<div class="login-box" style="margin: 0% auto;width:100%;max-width: 470px;">
		<div class="login-box-body">
			<div class="row">
				<p class="login-box-msg">เข้าสู่ระบบด้วยอีเมล์ หรือบัญชี Facebook ของคุณ</p>
				<form action="callback/login.php" method="post">
					<input type="hidden" name="modal" value="0">
					<div class="form-group has-feedback">
						<input type="email" name="email" class="form-control" placeholder="อีเมล์">
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span> </div>
					<div class="form-group has-feedback">
						<input type="password" name="password" class="form-control" placeholder="รหัสผ่าน">
						<span class="glyphicon glyphicon-lock form-control-feedback"></span> </div>
					<div class="row">
						<div class="col-xs-8">
							<div class="checkbox icheck hide">
								<label>
									<div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
									Remember Me </label>
							</div>
						</div>
						<!-- /.col -->
						<div class="col-xs-4">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
				<div class="social-auth-links text-center">
					<p>- OR -</p>
					<a href="javascript:void(0);" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> <span class="fb_text">Yotsawat Chotsamphanchareon (ล็อคอินทันที?)</span></a> </div>
				<!-- /.social-auth-links -->

				<!--<a href="#">I forgot my password</a><br>-->
								<a href="{$BASEURL}member/signup.html" class="text-center">สมัครสมาชิกใหม่</a>
							</div>

		</div>
		<!-- /.login-box-body -->
	</div>
