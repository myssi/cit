<?php 
class HargaTipeModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function nasabahlist()
	{
		$this->db->select('idnasabah,nasabah');
		$this->db->from('nasabah');
		$this->db->order_by('nasabah','asc');
		return $this->db->get()->result();
	}
	
	function listprice()
	{
		$this->db->select('nasabah.idnasabah,nasabah.nasabah,hargatipe1.*');
		$this->db->from('nasabah');
		$this->db->join('hargatipe1','nasabah.idnasabah = hargatipe1.idnasabah');
		$this->db->order_by('nasabah.nasabah','asc');
		return $this->db->get()->result();
	}
	
	function checknas($id)
	{
		$query= $this->db->get_where('hargatipe1',array('idnasabah'=>$id),1,0);
		
		if($query->num_rows() > 0 ){return TRUE;}
		else{return FALSE;}
	}
	
	function saveharga($idnasabah,$harga,$tgl,$adhoc)
	{
		$tanggal= date('Y-m-d',strtotime($tgl));
		
		$data= array(
		'idnasabah'=>$idnasabah,
		'hargapertrip'=>$harga,
		'berlaku'=>$tanggal,
		'adhoc'=>$adhoc
		);
		
		$this->db->insert('hargatipe1',$data);
	}
	
	function hargaedit($id)
	{
		$this->db->select('hargatipe1.*,nasabah.nasabah');
		$this->db->from('hargatipe1');
		$this->db->join('nasabah','hargatipe1.idnasabah = nasabah.idnasabah');
		$this->db->where('idht1',$id);
		return $this->db->get()->row();
	}
	
	function nasabahname($id)
	{
		$this->db->select('nasabah.nasabah');
		$this->db->from('hargatipe1');
		$this->db->join('nasabah','hargatipe1.idnasabah = nasabah.idnasabah');
		$this->db->where('idht1',$id);
		return $this->db->get()->row();
	}
	
	function update_price($id,$hargapt,$tanggalpt,$adhoc)
	{
		$username= $this->session->userdata('username');
		
		// take all data in hargatipe1
		$get_all= $this->db->get_where('hargatipe1',array('idht1'=>$id),1,0)->row();
		
		$idnasabah= $get_all->idnasabah;
		$harga= $get_all->hargapertrip;
		$tanggal= $get_all->berlaku;
		
		$history= array(
		'idnasabah'=>$idnasabah,
		'harga'=>$harga,
		'tanggal'=>$tanggal,
		'username'=>$username
		);
		
		//save in history change price
		$this->db->insert('historytipe1',$history);
		
		//Then change in hargatipe1
		
		$berlaku= date('Y-m-d',strtotime($tanggalpt));
		
		$upprice= array(
		'hargapertrip'=>$hargapt,
		'adhoc'=>$adhoc,
		'berlaku'=>$berlaku
		);
		
		$this->db->where('idht1',$id);
		$this->db->update('hargatipe1',$upprice);
		
		return TRUE;
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