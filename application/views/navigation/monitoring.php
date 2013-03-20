<!--<ul id="navigation">
	<li><a href="#"><span>Laporan<b></b></span></a>
		<ul>
			<li><a href="<?php echo site_url('monitor/monitoring/index'); ?>">SPPU</a></li>
			<li><a href="<?php echo site_url('monitor/monitoring/warkat'); ?>">Warkat</a></li>
			<li><a href="#">Sortir</a></li>
		</ul>
	</li>
	
	<li><a href="#">Setting</a></li>
	<li><?php echo anchor('loginonline/logout','Logout',array('onclick'=>"return confirm('Anda Sudah Selesai ?')")); ?></li>
</ul>-->

<div class="art-nav-outer">
	<ul class="art-hmenu">			
		<li><a href="#" class="<?php echo isset($menu1) ? $menu1 : ''; ?>">Laporan</a>
			<ul>
				<li><a href="<?php echo site_url('monitor/monitoring/index'); ?>">SPPU</a></li>
				<li><a href="<?php echo site_url('monitor/monitoring/warkat'); ?>">Warkat</a></li>
				<li><a href="#">Sortir</a></li>
			</ul>
		</li>
		<li><a href="<?php echo site_url('setting/settingan'); ?>" id="<?php echo isset($menu3) ? $menu3 : ''; ?>">Setting</a></li>
		<li><?php echo anchor('loginonline/logout','Logout',array('onclick'=>"return confirm('Anda Sudah Selesai ?')")); ?></li>	
	</ul>
</div>