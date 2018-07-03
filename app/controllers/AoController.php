<?php

namespace Vokuro\Controllers;

use Vokuro\Models\Pegawai;
use Vokuro\Models\PegawaiStatus;
use Vokuro\Models\UnitKerja;
use Vokuro\Models\View1;

/**
 * AO Controller
 */
class AoController extends ControllerBase
{

	public function initialize()
	{
		$this->view->setTemplateBefore('private');
	}


	public function indexAction()
	{
		$this->view->view1 = View1::find();
	}

	public function statusAction($pid)
	{
		$pegawai 										= Pegawai::findFirstById($pid);
		$this->view->pegawai 				= $pegawai;
		$this->view->pegawai_status = PegawaiStatus::find();

		if ($this->request->isPost()) {

			$status = $this->request->getPost("status");

			if ($pegawai->status != $status) {
				// ubah data
				$pegawai->status = $status;

				// simpan data yang telah diubah
				if ($pegawai->save()) {
					$this->sessionFlash->success("Ubah status, sukses.");
				} else {
					$this->sessionFlash->danger("Ubah status, gagal.");
				}
			}		
			
			$this->response->redirect('ao');
		}
	}

	public function mutasiAction($pid)
	{
		$pegawai 								= Pegawai::findFirstById($pid);
		$this->view->pegawai 		= $pegawai;
		$this->view->unit_kerja = UnitKerja::find();

		if ($this->request->isPost()) {

			$kode_uker = $this->request->getPost("kode_uker");

			if ($pegawai->kode_uker != $kode_uker) {
				// ubah data
				$pegawai->kode_uker = $kode_uker;

				// simpan data yang telah diubah
				if ($pegawai->save()) {
					$this->sessionFlash->success("Mutasi sukses.");
				} else {
					$this->sessionFlash->danger("Mutasi gagal.");
				}
			}		
			
			$this->response->redirect('ao');
		}

	}

	public function createAction()
	{
		$this->view->pegawai_status = PegawaiStatus::find();
		$this->view->unit_kerja 		= UnitKerja::find();

		if ($this->request->isPost()) {
			
			$nama 	 = $this->request->getPost("nama");
			$pegawai = new Pegawai();
			$pegawai->nama 			= $nama;
			$pegawai->kode_uker = $this->request->getPost("kode_uker");
			$pegawai->status 		= $this->request->getPost("status");

			if ($nama != null OR !isset($nama) OR $nama !== '') {
				if ($pegawai->save()) {
					$this->sessionFlash->success("Data pegawai berhasil disimpan.");
				} else {
					$this->sessionFlash->danger("Gagal menyimpan data pegawai.");
				}
			}

			$this->response->redirect('ao');
		}
	}

	public function editAction($pid)
	{
		$this->view->pegawai = Pegawai::findFirstById($pid);

		if ($this->request->isPost()) {
			
			$nama 	 				= $this->request->getPost("nama");
			$pegawai 				= Pegawai::findFirstById($pid);
			$pegawai->nama 	= $nama;

			if ($nama != null OR !isset($nama) OR $nama !== '') {
				if ($pegawai->save()) {
					$this->sessionFlash->success("Data pegawai berhasil disimpan.");
				} else {
					$this->sessionFlash->danger("Gagal menyimpan data pegawai.");
				}
			}

			$this->response->redirect('ao');
		}
	}

	public function deleteAction($pid)
	{
		$pegawai = Pegawai::findFirstById($pid);
		$nama = $pegawai->nama;
		if (!$pegawai) {

      $this->sessionFlash->error("Data pegawai tidak ditemukan.");

      $this->response->redirect('ao');
    }

    if (!$pegawai->delete()) {
       $this->sessionFlash->error($pegawai->getMessages());
    } else {
       $this->sessionFlash->success("Data pegawai ".$nama." berhasil dihapus.");
    }

  	$this->response->redirect('ao');
	}
}