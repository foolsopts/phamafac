<div class="">
	<div class="login-box" style="margin: 0% auto;width:100%;max-width:470px;">
		<div class="row">
			<div class="login-box-body">
				<p class="login-box-msg">กรอกข้อมูลการล็อคอินของคุณในช่องด้านล่าง</p>
				<form action="{$BASEURL}member/signup" method="post">
					<div class="form-group has-feedback">
						<div class="parent">
							<input name="name" type="text" class="zervid-input1 form-control" id="name" data-container=".parent" placeholder="ชื่อ - สกุล" required>
							<span class="fa fa-user form-control-feedback"></span>
							<div class="help-block with-errors" style="display:none;"></div>
						</div>
					</div>
					<div class="form-group has-feedback">
						<div class="parent">
							<input name="email" type="email" class="zervid-input1 form-control" id="email" data-container=".parent" placeholder="อีเมล์" required>
							<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							<div class="help-block with-errors" style="display:none;"></div>
						</div>
					</div>
					<div class="form-group has-feedback">
						<div class="parent">
							<input name="pass" type="password" class="zervid-input1 form-control" id="pass" data-minlength="6" placeholder="ตั้งรหัสผ่าน" required>
							<span class="glyphicon glyphicon-lock form-control-feedback"></span>
							<div class="help-block with-errors" style="display:none;"></div>
						</div>
					</div>
					<div class="form-group has-feedback">
						<div class="parent">
							<input name="repass" type="password" class="zervid-input1 form-control" id="repass" equalto="#pass" data-minlength="6" data-match-error="Whoops, these don't match" placeholder="รหัสผ่านซ้ำอีกครั้ง" required>
							<span class="glyphicon glyphicon-repeat form-control-feedback"></span>
							<div class="help-block with-errors" style="display:none;"></div>
						</div>
					</div>
					<div class="row">

						<!-- /.col -->
						<div class="col-xs-4">
							<button type="submit" class="btn btn-primary btn-block btn-flat">ลงทะเบียน</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
				<div class="social-auth-links text-center">
					<p>- OR -</p>
					<a href="javascript:void(0);" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> <span class="fb_text">Sign in using Facebook</span></a></div>
				<!-- /.social-auth-links -->

				<!--<a href="#">ลืมรหัสผ่าน</a><br>-->
				<a href="?step=1" class="text-center">เป็นสมาชิกอยู่แล้ว ล็อคอินทันที</a> </div>
		</div>
		<!-- /.login-box-body -->
	</div>
	<!-- /.login-box -->
</div>
