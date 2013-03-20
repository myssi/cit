<?php 
class MonitoringModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function selectcabang()
	{
		$this->db->select('*');
		$this->db->from('tbcabang');
		$this->db->order_by('cabang','asc');
		return $this->db->get()->result();
	}
	
	function pilih_sppu_cabang($kode)
	{
		$this->db->select('*');
		$this->db->from('tbreport_uang_nonsort');
		$this->db->where('area',$kode);
		$this->db->order_by('tanggal','asc');
		return $this->db->get()->result();
	}
	
	function pilih_warkat_cabang($kode)
	{
		$this->db->select('*');
		$this->db->from('tbreport_warkat');
		$this->db->where('area',$kode);
		$this->db->order_by('tanggal_tempo','asc');
		return $this->db->get()->result();
	}
	
	function namacab($kode)
	{
		$this->db->select('tbcabang.cabang');
		$this->db->from('tbcabang');
		$this->db->where('idcabang',$kode);
		return $this->db->get()->row();
	}
	
	function tri_desimal($nominal)
	{
		//$nominal= 75000;
		$lkarakter= strlen($nominal);
		if($lkarakter > 3)
		{
			$balik=strrev($nominal);		
			//echo'panjang: '.$lkarakter;
			//echo br();
		
			$sisamod= $lkarakter%3;
			//echo 'sisa modulus: '.$sisamod;
			//echo br();
			if($sisamod > 0)
			{
				$hsl= ceil($lkarakter/3);
				$hsl= $hsl-1;
			}
			else{ $hsl= $lkarakter/3;}
		
			//echo'hsl: ' .$hsl;
			//echo br();
			$hasil='';
			$k=0;
			for($j=1;$j <= $hsl;++$j)
			{
				$d= substr($balik,$k,3);
				$k=$k+3;
				if($j == $hsl)
				{				
					$hasil= $hasil .$d;
				}
				else if($hsl == 1) {$hasil= $hasil .$d;}
				else{ $hasil= $hasil .$d.'.';}
			
				//echo 'j'.$j .': '.$hasil;
				//echo br();
			}
		
			if(($sisamod > 0))
			{
				//echo $balik;
				//echo br();
				$g= substr($balik,$k,$sisamod);
				//echo'k: '. $k;
				//echo br();
				//echo $g;
				//echo br();
			$hasil= $hasil.'.' .$g;
			}
			$hasil= strrev($hasil);
		}
		else{ $hasil= $nominal;}
		
		//echo $hasil;
		return $hasil;
		//exit();
	}
}
?>