<div class="art-nav-outer">
	<ul class="art-hmenu">			
		<li><a href="#" class="<?php echo isset($menu1) ? $menu1 : ''; ?>">Rekap</a>
			<ul>
				<li><a href="<?php echo site_url('management/nonsortir'); ?>">Paket</a></li>
				<li><a href="#">Per Trip</a></li>
				
			</ul>
		</li>
		<li><a href="#" class="<?php echo isset($menu2) ? $menu2 : ''; ?>">Restore</a>
			<ul>
				<li><a href="<?php echo site_url('management/restorerekap'); ?>">Paket</a></li>
				<li><a href="#">Per Trip</a></li>
			</ul>
		</li>
		<li><a href="#" class="<?php echo isset($menu4) ? $menu4 : ''; ?>">Brangkas</a>
			<ul>
				<li><a href="<?php echo site_url('management/brangkas'); ?>">Pelanggan</a></li>
				<li><a href="<?php echo site_url('management/brangkas/cabang'); ?>">Cabang</a></li>
				
			</ul>
		</li>
		<li><a href="<?php echo site_url('setting/settingan'); ?>" class="<?php echo isset($menu3) ? $menu3 : ''; ?>">Setting</a></li>
		<li><?php echo anchor('loginonline/logout','Logout',array('onclick'=>"return confirm('Anda Sudah Selesai ?')")); ?></li>	
	</ul>
</div>