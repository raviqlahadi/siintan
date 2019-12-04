<div class="limiter">
	<div class="container-login100">
		<div class="wrap-login100">
			<form action="<?php echo site_url('auth/cek_user') ?>" method="post" class="login100-form validate-form" style="padding-top:50px;padding-bottom:20px">
				<span class="login100-form-title p-b-50">
					<a href="<?php echo site_url()?>"><strong style="color:#FF9800;font-size:5em">SIINTAN</strong></a>
					<p>Sistem Informasi Pertanahan</p>
					<p style="color:#FF9800;font-size:0.6em"><b>Kota Kendari</b></p>

				</span>


				<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
					<input class="input100" type="email" name="email">
					<span class="focus-input100"></span>
					<span class="label-input100">Email</span>
				</div>


				<div class="wrap-input100 validate-input" data-validate="Password is required">
					<input class="input100" type="password" name="password">
					<span class="focus-input100"></span>
					<span class="label-input100">Password</span>
				</div>

				<div class="">
					<?php
					if ($this->session->flashdata('alert')) {
						echo $this->session->flashdata('alert');
					} ?>
				</div>


				<div class="container-login100-form-btn">
					<button class="login100-form-btn" style="background-color:#FF9800!important">
						Login
					</button>
				</div>

			</form>

			<div class="login100-more" style="background-image: url('<?php echo base_url('assets/auth/'); ?>images/bg-02.jpg');">
				<img class="logo-img" src="<?php echo base_url('assets/kendari.png') ?>" style="margin-bottom:30px" alt="">
			</div>
		</div>
	</div>
</div>