<div class="art-nav-outer">
	<ul class="art-hmenu">			
		<li><a href="#" class="<?php echo isset($menu1) ? $menu1 : ''; ?>">SPPU</a>
			<ul>
				<li><a href="<?php echo site_url('operator/uangclosed'); ?>">Uang</a></li>
				<li><a href="<?php echo site_url('operator/warkatclosed'); ?>">Warkat</a></li>
			</ul>
		</li>
		<li><a href="#" class="<?php echo isset($menu2) ? $menu2 : ''; ?>">Lokasi</a>
			<ul>
				<li><a href="<?php echo site_url('operator/asal/'); ?>">Asal</a></li>
				<li><a href="<?php echo site_url('operator/tujuan'); ?>">Tujuan</a></li>
			</ul>
		</li>
		<li><a href="#" class="<?php echo isset($menu4) ? $menu4 : ''; ?>">Laporan</a>
			<ul>
				<li><a href="<?php echo site_url('operator/uangreport'); ?>">Uang</a></li>
				<li><a href="<?php echo site_url('operator/warkatreport'); ?>">Warkat</a></li>
			</ul>
		</li>
		<li><a href="<?php echo site_url('setting/settingan'); ?>" class="<?php echo isset($menu3) ? $menu3 : ''; ?>">Setting</a></li>
		<li><?php echo anchor('loginonline/logout','Logout',array('onclick'=>"return confirm('Anda Sudah Selesai ?')")); ?></li>	
	</ul>
</div>