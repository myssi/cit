<div class="art-nav-outer">
	<ul class="art-hmenu">			
		<li><a href="#" class="<?php echo isset($menu1) ? $menu1 : ''; ?>">Parameter</a>
			<ul>
				<li><a href="<?php echo site_url('supervisor/customersuper/index'); ?>">Bank</a></li>
				<li><a href="<?php echo site_url('supervisor/customersuper/divisilist'); ?>">Divisi</a></li>
				<li><a href="<?php echo site_url('supervisor/senkas/index'); ?>">Cabang</a></li>
				<li><a href="<?php echo site_url('supervisor/nasabah/'); ?>">Nasabah</a></li>
				<li><a href="#">Pegawai</a>
					<ul>
						<li><a href="<?php echo site_url('supervisor/pegawai/'); ?>">Daftar</a></li>
						<li><a href="<?php echo site_url('supervisor/pegawai/non'); ?>">Non Aktif</a></li>
					</ul>
				</li>
				<li><a href="<?php echo site_url('supervisor/vehicle/'); ?>">Kendaraan</a></li>
			</ul>
		</li>
		<li><a href="#" class="<?php echo isset($menu4) ? $menu4 : ''; ?>">Nasabah</a>
			<ul>
				<li><a href="<?php echo site_url('supervisor/olah/'); ?>">Paket</a></li>
				<li><a href="<?php echo site_url('supervisor/lokasi'); ?>">Perjalanan</a></li>
			</ul>
		</li>
		<li><a href="#" class="<?php echo isset($menu2) ? $menu2 : ''; ?>">Harga</a>
			<ul>
				<li><a href="<?php echo site_url('supervisor/hargatipe'); ?>">Paket</a></li>
				<li><a href="<?php echo site_url('supervisor/hargatrip'); ?>">Perjalanan</a></li>
				<li><a href="#">Bulanan</a></li>
			</ul>
		</li>
		<li><a href="<?php echo site_url('setting/settingan'); ?>" class="<?php echo isset($menu3) ? $menu3 : ''; ?>">Setting</a></li>
		<li><?php echo anchor('loginonline/logout','Logout',array('onclick'=>"return confirm('Anda Sudah Selesai ?')")); ?></li>	
	</ul>
</div>