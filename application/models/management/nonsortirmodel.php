<?php
class NonSortirModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function customer1()
	{
		$this->db->select('hargatipe1.*,nasabah.nasabah');
		$this->db->from('hargatipe1');
		$this->db->join('nasabah','hargatipe1.idnasabah = nasabah.idnasabah');
		$this->db->order_by('nasabah.nasabah','asc');
		return $this->db->get()->result();
	}
	
	function namanasabah($id)
	{
		return $this->db->get_where('nasabah',array('idnasabah'=>$id),1,0)->row();
	}
	
	function tablenonsort($id)
	{
		$this->db->select('*');
		$this->db->from('tbreport_uang_nonsort');
		$this->db->where('customer',$id);
		return $this->db->get()->result();
	}
	
	function nonsortirview($aw,$ak,$id)
	{
		$awal= date('Y-m-d',$aw);
		$akhir= date('Y-m-d',$ak);
		
		$this->db->select('tbreport_uang_nonsort.*,hargatipe1.hargapertrip,nasabah.nasabah');
		$this->db->from('tbreport_uang_nonsort');
		$this->db->join('hargatipe1','tbreport_uang_nonsort.customer = hargatipe1.idnasabah');
		$this->db->join('nasabah','tbreport_uang_nonsort.customer = nasabah.idnasabah');
		$this->db->where('tbreport_uang_nonsort.tanggal >=',$awal);
		$this->db->where('tbreport_uang_nonsort.tanggal <=',$akhir);
		$this->db->where('tbreport_uang_nonsort.customer',$id);
		return $this->db->get()->result();
	}
	
	function totaljln($aw,$ak,$id)
	{
		$awal= date('Y-m-d',$aw);
		$akhir= date('Y-m-d',$ak);
		
		$this->db->select('tbreport_uang_nonsort.*');
		$this->db->from('tbreport_uang_nonsort');
		$this->db->where('tbreport_uang_nonsort.tanggal >=',$awal);
		$this->db->where('tbreport_uang_nonsort.tanggal <=',$akhir);
		$this->db->where('tbreport_uang_nonsort.customer',$id);
		return $this->db->count_all_results();
	}
	
	function totaluang($aw,$ak,$id)
	{
		$awal= date('Y-m-d',$aw);
		$akhir= date('Y-m-d',$ak);
		
		//$sql="select sum(nominal) from tbreport_uang_nonsort where tanggal >= ? AND tanggal <= ? AND customer= ?";
		//return $this->db->query($sql,array($awal,$akhir,$id))->row();
		$this->db->select_sum('nominal');
		$this->db->from('tbreport_uang_nonsort');
		$this->db->where('customer',$id);
		$query= $this->db->get();
		return $query->row_array();
	}
	
	function cabangolah($idnasabah)
	{
		$this->db->select('olahnasabah.*,nasabah.nasabah,tbcabang.*');
		$this->db->from('olahnasabah');
		$this->db->join('nasabah','olahnasabah.idnasabah = nasabah.idnasabah');
		$this->db->join('tbcabang','olahnasabah.idcabang = tbcabang.idcabang');
		$this->db->where('olahnasabah.idnasabah',$idnasabah);
		return $this->db->get()->result();
	}
	
	function headername($idnasabah)
	{
		$this->db->select('olahnasabah.*,bank.singkatan,nasabah.nasabah,tbdivisi.divisi,tbcabang.cabang');
		$this->db->from('olahnasabah');
		$this->db->join('bank','olahnasabah.idbank = bank.idbank');
		$this->db->join('nasabah','olahnasabah.idnasabah = nasabah.idnasabah');
		$this->db->join('tbdivisi','olahnasabah.iddivisi = tbdivisi.iddivisi');
		$this->db->join('tbcabang','olahnasabah.idcabang = tbcabang.idcabang');
		$this->db->where('olahnasabah.idnasabah',$idnasabah);
		return $this->db->get()->row();
	}
	
	function tripharga($id)
	{
		return $this->db->select('hargapertrip')->from('hargatipe1')->where('idnasabah',$id)->get()->row();
	}
	
	function jlncab($awaldb,$akhirdb,$idcab,$idnasabah)
	{
		$this->db->select('*');
		$this->db->from('tbreport_uang_nonsort');
		$this->db->where('tbreport_uang_nonsort.tanggal >=',$awaldb);
		$this->db->where('tbreport_uang_nonsort.tanggal <=',$akhirdb);
		$this->db->where('tbreport_uang_nonsort.customer',$idnasabah);
		$this->db->where('tbreport_uang_nonsort.area',$idcab);
		return $this->db->count_all_results();
	}
	
	function tri_desimal($nominal)
	{
		$lkarakter= strlen($nominal);
		if($lkarakter > 3)
		{
			$balik=strrev($nominal);
			$sisamod= $lkarakter%3;
			
			if($sisamod > 0)
			{
				$hsl= ceil($lkarakter/3);
				$hsl= $hsl-1;
			}
			else{ $hsl= $lkarakter/3;}
		
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
			}
		
			if(($sisamod > 0))
			{
				$g= substr($balik,$k,$sisamod);
				$hasil= $hasil.'.' .$g;
			}
			$hasil= strrev($hasil);
		}
		else{ $hasil= $nominal;}
		
		return $hasil;
	}
	
	function removetag($sppu)
	{
		$removed= $this->db->get_where('tbreport_uang_nonsort',array('sppu'=>$sppu),1,0);
		
		if($removed > 0)
		{
			$data= array(
			'tanggal'=>$removed->row()->tanggal,
			'sppu'=>$removed->row()->sppu,
			'dari'=>$removed->row()->dari,
			'berangkat'=>$removed->row()->berangkat,
			'ke'=>$removed->row()->ke,
			'tiba'=>$removed->row()->tiba,
			'nominal'=>$removed->row()->nominal,
			'adhoc'=>$removed->row()->adhoc,
			'customer'=>$removed->row()->customer,
			'datekirim'=>$removed->row()->datekirim,
			'area'=>$removed->row()->area,
			'status'=>$removed->row()->status
			);
			
			$this->db->insert('dump_uang_nonsort',$data);
			//delete on tbreport_uang_nonsort
			$this->db->where('sppu',$sppu);
			$this->db->delete('tbreport_uang_nonsort');
			
			return TRUE;
		}
		else{return FALSE;}
	}
}
?>