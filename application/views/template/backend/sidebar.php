<nav class="pcoded-navbar menu-light ">
	<div class="navbar-wrapper  ">
		<div class="navbar-content scroll-div ">
			<div class="">
				<div class="main-menu-header">
					<?php if (!$this->session->userdata('image')){ $profile = $this->session->userdata('image'); ?>
						<img class="img-radius" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRoyY5b_1yBKpIHqBpE1IOslAL3VOdtNbuCj0PZXGo6-HGUetscjNK6hbbnLaLJw7Y1aVI&usqp=CAU">
						<!-- <img class="img-radius" src="<?php echo base_url("assets/images/profile/"."$profile"); ?>"> -->
					<?php }else{?>
						<img class="img-radius" src="<?php echo base_url("assets/images/profile/be505fc05352f527b24ad9504a3408f1.png"); ?>">
					<?php } ?>
					<div class="user-details">
						<div id="more-details"><?php echo $this->session->userdata('fullName');  ?></div>
					</div>
				</div>
			</div>

			<ul class="nav pcoded-inner-navbar mt-3">
				<li class="nav-item <?php if($this->uri->segment(2)==""){echo 'active';}?>">
					<a href="<?= base_url('dashboard'); ?>" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
				</li>
				<li class="nav-item <?php if($this->uri->segment(2)=="stream-room"){echo 'active';}?>">
					<a href="<?= base_url('dashboard/stream-room'); ?>" class="nav-link "><span class="pcoded-micon"><i class="feather icon-video"></i></span><span class="pcoded-mtext">Stream Room</span></a>
				</li>
				<li class="nav-item <?php if($this->uri->segment(2)=="quiz"){echo 'active';}?>">
					<a href="<?= base_url('dashboard/quiz'); ?>" class="nav-link "><span class="pcoded-micon"><i class="feather icon-book"></i></span><span class="pcoded-mtext">Quiz</span></a>
				</li>
				<li class="nav-item <?php if($this->uri->segment(2)=="leader-board"){echo 'active';}?>">
					<a href="<?= base_url('dashboard/leader-board'); ?>" class="nav-link "><span class="pcoded-micon"><i class="feather icon-clipboard"></i></span><span class="pcoded-mtext">Leaderboard</span></a>
				</li>
				<li class="nav-item <?php if($this->uri->segment(2)=="settings"){echo 'active';}?>">
					<a href="<?= base_url('dashboard/settings'); ?>" class="nav-link "><span class="pcoded-micon"><i class="feather icon-settings"></i></span><span class="pcoded-mtext">Settings</span></a>
				</li>
			</ul>
		</div>
	</div>
</nav>