<?php
class RestoreRekapModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function rekapandump($aw,$ak,$id)
	{
		$awal= date('Y-m-d',$aw);
		$akhir= date('Y-m-d',$ak);
		
		$this->db->select('dump_uang_nonsort.*,hargatipe1.hargapertrip,nasabah.nasabah');
		$this->db->from('dump_uang_nonsort');
		$this->db->join('hargatipe1','dump_uang_nonsort.customer = hargatipe1.idnasabah');
		$this->db->join('nasabah','dump_uang_nonsort.customer = nasabah.idnasabah');
		$this->db->where('dump_uang_nonsort.tanggal >=',$awal);
		$this->db->where('dump_uang_nonsort.tanggal <=',$akhir);
		$this->db->where('dump_uang_nonsort.customer',$id);
		return $this->db->get()->result();
	}
	
	function restoredump($sppu)
	{
		$dump= $this->db->get_where('dump_uang_nonsort',array('sppu'=>$sppu),1,0)->row();
		
		if(!empty($dump))
		{
			$data= array(
			'tanggal'=>$dump->tanggal,
			'sppu'=>$dump->sppu,
			'dari'=>$dump->dari,
			'berangkat'=>$dump->berangkat,
			'ke'=>$dump->ke,
			'tiba'=>$dump->tiba,
			'nominal'=>$dump->nominal,
			'adhoc'=>$dump->adhoc,
			'customer'=>$dump->customer,
			'datekirim'=>$dump->datekirim,
			'area'=>$dump->area,
			'status'=>$dump->status
			);
			
			$this->db->insert('tbreport_uang_nonsort',$data);
			
			//delete on dump_uang_nonsort
			
			$this->db->where('sppu',$sppu);
			$this->db->delete('dump_uang_nonsort');
			
			return TRUE;
		}
		else{ return FALSE;}
		
	}
}
?>