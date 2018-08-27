<?php

namespace Vokuro\Controllers;

// require '../../vendor/autoload.php';
use \Vokuro\Models\Pegawai;
use \Vokuro\Models\PegawaiStatus;
use \Vokuro\Models\UnitKerja;
use \Vokuro\Models\View1;
use \Vokuro\Models\View2;
use \Vokuro\Models\ViewLaporan;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Helper\Sample;
use \PhpOffice\PhpSpreadsheet\Style\Alignment;
use \PhpOffice\PhpSpreadsheet\Style\Fill;


/**
 * Export Controller
 */
class ExportController extends ControllerBase
{
	public function indexAction()
	{

		// Define some names //
		$filename = "a.xls";
		$sheetname = "Simple";
		$green = "FF93D14F";
		$yellow = "FFFFFF00";
		$gray = "FFC1C1C1";
		$gray_blue = "FF8FB6E4";
		$orange = "FFFFC100";
		$pink = "FFDA9795";
		$ocean_blue = "FF00B2F1";

		// Create new Spreadsheet object
		$spreadsheet = new Spreadsheet();

		// Set document properties
		$spreadsheet->getProperties()->setCreator('Andi Praja')
		->setLastModifiedBy('Andi Praja')
		->setTitle('Office 2007 XLSX Test Document')
		->setSubject('Office 2007 XLSX Test Document')
		->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
		->setKeywords('office 2007 openxml php')
		->setCategory('Test result file');




		// Set columns width
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(6);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(28);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(14);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(12);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);

		// Header
		$spreadsheet->setActiveSheetIndex(0)
		->mergeCells('A1:G1')
		->setCellValue('A1', 'DATA FORMASI PEMENUHAN AO KANWIL BRI MALANG BERDASARKAN SURAT NOKEP. 107 DIR/CDS/02/2017')
		->mergeCells('A2:A5')
		->setCellValue('A2', 'NO')
		->mergeCells('B2:B5')
		->setCellValue('B2', 'KANCA')
		->mergeCells('C2:G2')
		->setCellValue('C2', 'AO RITEL KOMERSIAL')
		->mergeCells('C3:F3')
		->setCellValue('C3', 'POSISI 31-5-2018')
		->mergeCells('C4:C5')
		->setCellValue('C4', 'FORMASI')
		->mergeCells('D4:F4')
		->setCellValue('D4', 'PEMENUHAN')
		->setCellValue('D5', 'PT')
		->setCellValue('E5', 'KONTRAK')
		->setCellValue('F5', 'JUMLAH')
		->mergeCells('G3:G5')
		->setCellValue('G3', 'KURANG/LEBIH');



		
		// $spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal(Alignment::CENTER);
		$styleArray = [
		    'alignment' => [
		        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
		        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
		    ],
		    'borders' => [
		        'top' => [
			        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			    ],
		        'bottom' => [
			        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			    ],
		        'left' => [
			        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			    ],
		        'right' => [
			        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			    ],
		    ],
		];
		$spreadsheet->getDefaultStyle()->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('A2:G5')
		->getFill()->setFillType(Fill::FILL_SOLID)
		->getStartColor()->setARGB($gray);
		$spreadsheet->getActiveSheet()->getStyle('C2')
		->getFill()->setFillType(Fill::FILL_SOLID)
		->getStartColor()->setARGB($green);



		$i = 6; // iterasi row
		$j = 1; // nomor kanca
		$k = 0; // penanda TOTAL kanca
		$t_formasi_ao_kanwil = 0;
		$t_tetap_ao_kanwil = 0;
		$t_kontrak_ao_kanwil = 0;
		$t_jumlah_ao_kanwil = 0;
		$t_kurleb_ao_kanwil = 0;

		$t_formasi_ao_kcp = 0;
		$t_tetap_ao_kcp = 0;
		$t_kontrak_ao_kcp = 0;
		$t_jumlah_ao_kcp = 0;
		$t_kurleb_ao_kcp = 0;

		$t_formasi_ao_kanca = 0;
		$t_tetap_ao_kanca = 0;
		$t_kontrak_ao_kanca = 0;
		$t_jumlah_ao_kanca = 0;
		$t_kurleb_ao_kanca = 0;

		$view_laporan = ViewLaporan::find();

		foreach ($view_laporan as $vl) {
			// TOTAL KANCA
			if ($i > 6 AND $vl->kode_uker == $vl->kode_kanca) {
				if ($k > 1) {
					$spreadsheet->setActiveSheetIndex(0)
					->mergeCells('A'.($i).':B'.($i))
					->setCellValue('A'.($i), "TOTAL")
					->setCellValue('C'.($i), $r_total_formasi)
					->setCellValue('D'.($i), $r_total_tetap) // PT
					->setCellValue('E'.($i), $r_total_kontrak) // KONTRAK
					->setCellValue('F'.($i), $r_total_jumlah) // JUMLAH
					->setCellValue('G'.($i), $r_total_kurang_lebih) // -/+
					;
					$spreadsheet->getActiveSheet()->getStyle('A'.$i.':G'.$i)
					->getFill()->setFillType(Fill::FILL_SOLID)
					->getStartColor()->setARGB($green);
				}
				$r_total_formasi = 0;
				$r_total_tetap = 0;
				$r_total_kontrak = 0;
				$r_total_jumlah = 0;
				$r_total_kurang_lebih = 0;
				$i+=2;
				$k=0;
			} 
			// KANCA
			if ($vl->kode_uker == $vl->kode_kanca) {
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$i, $j);
				$spreadsheet->getActiveSheet()->getStyle('A'.$i.':G'.$i)
				->getFill()->setFillType(Fill::FILL_SOLID)
				->getStartColor()->setARGB($yellow);
				$spreadsheet->getActiveSheet()->getStyle('A'.($i-1))
				    ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
				$spreadsheet->getActiveSheet()->getStyle('A'.($i-1))
				    ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
				$spreadsheet->getActiveSheet()->getStyle('B'.($i-1))
				    ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
				$spreadsheet->getActiveSheet()->getStyle('B'.($i-1))
				    ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
				$spreadsheet->getActiveSheet()->getStyle('C'.($i-1))
				    ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
				$spreadsheet->getActiveSheet()->getStyle('C'.($i-1))
				    ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
				$spreadsheet->getActiveSheet()->getStyle('D'.($i-1))
				    ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
				$spreadsheet->getActiveSheet()->getStyle('D'.($i-1))
				    ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
				$spreadsheet->getActiveSheet()->getStyle('E'.($i-1))
				    ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
				$spreadsheet->getActiveSheet()->getStyle('E'.($i-1))
				    ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
				$spreadsheet->getActiveSheet()->getStyle('F'.($i-1))
				    ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
				$spreadsheet->getActiveSheet()->getStyle('F'.($i-1))
				    ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
				$spreadsheet->getActiveSheet()->getStyle('G'.($i-1))
				    ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
				$spreadsheet->getActiveSheet()->getStyle('G'.($i-1))
				    ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
				$j++;
			}

			$r_total_formasi += $vl->formasi_ao;
			$r_total_tetap += $vl->tetap;
			$r_total_kontrak += $vl->kontrak;
			$r_total_jumlah += $vl->jumlah;
			$r_total_kurang_lebih += $vl->kurleb;

			$spreadsheet->setActiveSheetIndex(0)
			// ->setCellValue('A'.($i+5), $i)
			->setCellValue('B'.($i), $vl->nama_uker)
			->setCellValue('C'.($i), $vl->formasi_ao)
			->setCellValue('D'.($i), $vl->tetap) // PT
			->setCellValue('E'.($i), $vl->kontrak) // KONTRAK
			->setCellValue('F'.($i), $vl->jumlah) // JUMLAH
			->setCellValue('G'.($i), $vl->kurleb) // -/+
			;

			if ($vl->kode_uker != $vl->kode_kanca) {
				$t_formasi_ao_kcp += $vl->formasi_ao;
				$t_tetap_ao_kcp += $vl->tetap;
				$t_kontrak_ao_kcp += $vl->kontrak;
				$t_jumlah_ao_kcp += $vl->jumlah;
				$t_kurleb_ao_kcp += $vl->kurleb;
			} else {
				$t_formasi_ao_kanca += $vl->formasi_ao;
				$t_tetap_ao_kanca += $vl->tetap;
				$t_kontrak_ao_kanca += $vl->kontrak;
				$t_jumlah_ao_kanca += $vl->jumlah;
				$t_kurleb_ao_kanca += $vl->kurleb;
			}

			$spreadsheet->getActiveSheet()->getStyle('B'.$i)
    		->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
			$i++;
			$k+=1;
		}

		$spreadsheet->setActiveSheetIndex(0)
		->mergeCells('A'.($i).':B'.($i))
		->setCellValue('A'.($i), "TOTAL")
		->setCellValue('C'.($i), $r_total_formasi)
		->setCellValue('D'.($i), $r_total_tetap) // PT
		->setCellValue('E'.($i), $r_total_kontrak) // KONTRAK
		->setCellValue('F'.($i), $r_total_jumlah) // JUMLAH
		->setCellValue('G'.($i), $r_total_kurang_lebih) // -/+
		;


		$spreadsheet->getActiveSheet()->getStyle('A'.($i+1).':B'.($i+6))
    	->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);


		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue(('A').($i+=1), "TOTAL JUMLAH AO KCP")
		->setCellValue(('C').($i), $t_formasi_ao_kcp)
		->setCellValue(('D').($i), $t_tetap_ao_kcp)
		->setCellValue(('E').($i), $t_kontrak_ao_kcp)
		->setCellValue(('F').($i), $t_jumlah_ao_kcp)
		->setCellValue(('G').($i), $t_kurleb_ao_kcp);
		$spreadsheet->getActiveSheet()->getStyle('A'.($i).':G'.($i))
		->getFill()->setFillType(Fill::FILL_SOLID)
		->getStartColor()->setARGB($gray_blue);
		$spreadsheet->getActiveSheet()->getStyle('A'.($i))
		->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
		$spreadsheet->getActiveSheet()->getStyle('B'.($i))
		->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);

		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue(('A').($i+=1), "TOTAL JUMLAH AO KANCA")
		->setCellValue(('C').($i), $t_formasi_ao_kanca)
		->setCellValue(('D').($i), $t_tetap_ao_kanca)
		->setCellValue(('E').($i), $t_kontrak_ao_kanca)
		->setCellValue(('F').($i), $t_jumlah_ao_kanca)
		->setCellValue(('G').($i), $t_kurleb_ao_kanca);
		$spreadsheet->getActiveSheet()->getStyle('A'.($i).':G'.($i))
		->getFill()->setFillType(Fill::FILL_SOLID)
		->getStartColor()->setARGB($yellow);
		$spreadsheet->getActiveSheet()->getStyle('A'.($i))
		->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
		$spreadsheet->getActiveSheet()->getStyle('B'.($i))
		->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);

		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue(('A').($i+=1), "TOTAL JUMLAH AO")
		->setCellValue(('C').($i), $t_formasi_ao_kanca + $t_formasi_ao_kanca)
		->setCellValue(('D').($i), $t_tetap_ao_kanca + $t_tetap_ao_kanca)
		->setCellValue(('E').($i), $t_kontrak_ao_kcp + $t_kontrak_ao_kanca)
		->setCellValue(('F').($i), $t_jumlah_ao_kcp + $t_jumlah_ao_kanca)
		->setCellValue(('G').($i), $t_kurleb_ao_kcp + $t_kurleb_ao_kanca);
		$spreadsheet->getActiveSheet()->getStyle('A'.($i).':G'.($i))
		->getFill()->setFillType(Fill::FILL_SOLID)
		->getStartColor()->setARGB($green);
		$spreadsheet->getActiveSheet()->getStyle('A'.($i))
		->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
		$spreadsheet->getActiveSheet()->getStyle('B'.($i))
		->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);

		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue(('B').($i+=1), "KETERANGAN :")
		->setCellValue(('B').($i+=1), "- PIC NPL TERMASUK DI PEMENUHAN RITEL")
		->setCellValue(('B').($i+=1), "- PEMENUHAN AO NPL TIDAK TERMASUK PIC NPL HANYA AO NPL & AO PPS");

		$spreadsheet->setActiveSheetIndex(0)
		->mergeCells(('B').($i+=2).':B'.($i+1))
		->setCellValue(('B').($i), "KESIMPULAN");
		$spreadsheet->getActiveSheet()->getStyle('B'.($i))
		->getFill()->setFillType(Fill::FILL_SOLID)
		->getStartColor()->setARGB($orange);
		$styleArray2 = [
		    'borders' => [
		        'top' => [
			        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
			    ],
		        'bottom' => [
			        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
			    ],
		        'left' => [
			        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
			    ],
		        'right' => [
			        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
			    ],
		    ],
		];
		$spreadsheet->getActiveSheet()->getStyle('B'.$i.':E'.($i+5))->applyFromArray($styleArray2);

		$spreadsheet->setActiveSheetIndex(0)
		->mergeCells(('C'.$i.':E'.$i))
		->setCellValue(('C'.$i), "AO RITEL KOMERSIAL")
		->setCellValue(('C'.$i+=1), "FORMASI")
		->setCellValue(('D'.$i), "PEMENUHAN")
		->setCellValue(('E'.$i), "KURANG / LEBIH AO");
		$spreadsheet->getActiveSheet()->getStyle('C'.($i-1).':E'.($i))
		->getFill()->setFillType(Fill::FILL_SOLID)
		->getStartColor()->setARGB($green);
		$spreadsheet->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setWrapText(true);

		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue(('B'.$i+=1), "TOTAL KANWIL")
		->setCellValue(('C'.$i), $t_formasi_ao_kanwil)
		->setCellValue(('D'.$i), $t_jumlah_ao_kanwil)
		->setCellValue(('E'.$i), $t_kurleb_ao_kanwil);
		$spreadsheet->getActiveSheet()->getStyle('B'.($i))
		->getFill()->setFillType(Fill::FILL_SOLID)
		->getStartColor()->setARGB($pink);

		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue(('B'.$i+=1), "TOTAL KANCA")
		->setCellValue(('C'.$i), $t_formasi_ao_kanca)
		 ->setCellValue(('D'.$i), $t_jumlah_ao_kanca)
		->setCellValue(('E'.$i), $t_kurleb_ao_kanca);
		$spreadsheet->getActiveSheet()->getStyle('B'.($i))
		->getFill()->setFillType(Fill::FILL_SOLID)
		->getStartColor()->setARGB($yellow);

		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue(('B'.$i+=1), "TOTAL KCP")
		->setCellValue(('C'.$i), $t_formasi_ao_kcp)
		->setCellValue(('D'.$i), $t_jumlah_ao_kcp)
		->setCellValue(('E'.$i), $t_kurleb_ao_kcp);
		$spreadsheet->getActiveSheet()->getStyle('B'.($i))
		->getFill()->setFillType(Fill::FILL_SOLID)
		->getStartColor()->setARGB($gray_blue);

		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue(('B'.$i+=1), "TOTAL KESELURUHAN")
		->setCellValue(('C'.$i), $t_formasi_ao_kanwil + $t_formasi_ao_kcp + $t_formasi_ao_kanca)
		->setCellValue(('D'.$i), $t_jumlah_ao_kanwil + $t_jumlah_ao_kcp + $t_jumlah_ao_kanca)
		->setCellValue(('E'.$i), $t_kurleb_ao_kanwil + $t_kurleb_ao_kanca + $t_kurleb_ao_kcp);
		$spreadsheet->getActiveSheet()->getStyle('B'.($i))
		->getFill()->setFillType(Fill::FILL_SOLID)
		->getStartColor()->setARGB($ocean_blue);






		// Rename worksheet
		$spreadsheet->getActiveSheet()->setTitle($sheetname);

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$spreadsheet->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Xls)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$writer = IOFactory::createWriter($spreadsheet, 'Xls');
		$writer->save('php://output');
		exit;
	}

}