<div class="art-nav-outer">
	<ul class="art-hmenu">			
		<li><a href="#" class="<?php echo isset($menu1) ? $menu1 : ''; ?>">Pengguna</a>
			<ul>
				<li><a href="<?php echo site_url('adm/adminis'); ?>">Daftar</a></li>
				<li><a href="<?php echo site_url('adm/adminis/add'); ?>">Tambah</a></li>
				
			</ul>
		</li>
		<li><a href="<?php echo site_url('setting/settingan'); ?>" class="<?php echo isset($menu3) ? $menu3 : ''; ?>">Setting</a></li>
		<li><?php echo anchor('loginonline/logout','Logout',array('onclick'=>"return confirm('Anda Sudah Selesai ?')")); ?></li>	
	</ul>
</div>