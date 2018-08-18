<?php

namespace Vokuro\Controllers;

// require '../../vendor/autoload.php';
use \Vokuro\Models\Pegawai;
use \Vokuro\Models\PegawaiStatus;
use \Vokuro\Models\UnitKerja;
use \Vokuro\Models\View1;
use \Vokuro\Models\View2;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Helper\Sample;
use \PhpOffice\PhpSpreadsheet\Style\Alignment;


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

    $query = View2::find();
    $i = 1;
    $j = 1;
    foreach ($query as $q) {
      $q_status = $this->modelsManager->executeQuery("
                    SELECT ps.status status, ps.id status_id, count(*) jumlah
                    from \Vokuro\Models\Pegawai p
                    left join \Vokuro\Models\PegawaiStatus ps on ps.id=p.status
                    left join \Vokuro\Models\UnitKerja uk on uk.kode_uker=p.kode_uker
                    where uk.id = :uker_id:
                    group by status",
                  ["uker_id"=>$q->uker_id]);
      $kontrak = 0;
      $tetap = 0;
      foreach ($q_status as $qs) {
        // kontrak
        if ($qs->status_id == 3 OR $qs->status == 4) {
          $kontrak += $qs->jumlah;
        }
        // tetap
        if ($qs->status_id == 6 OR $qs->status == 7) {
          $tetap += $qs->jumlah;
        }
      }
      $jumlah = $tetap+$kontrak;
      $kurang_lebih = $jumlah - $q->formasi_ao;

      // ROW KANCA
      if ($i > 1 && $q->uker == $q->kanca) {
        $spreadsheet->setActiveSheetIndex(0)
        ->mergeCells('A'.($i+5).':B'.($i+5))
        ->setCellValue('A'.($i+5), "TOTAL")
        ->setCellValue('C'.($i+5), $r_total_formasi)
        ->setCellValue('D'.($i+5), $r_total_tetap) // PT
        ->setCellValue('E'.($i+5), $r_total_kontrak) // KONTRAK
        ->setCellValue('F'.($i+5), $r_total_jumlah) // JUMLAH
        ->setCellValue('G'.($i+5), $r_total_kurang_lebih) // -/+
        ;
        $i+=2;
        $r_total_formasi = 0;
        $r_total_tetap = 0;
        $r_total_kontrak = 0;
        $r_total_jumlah = 0;
        $r_total_kurang_lebih = 0;


        // Styling
        $style = array(
          'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => TRUE
          )
        );
        $spreadsheet->getDefaultStyle()->applyFromArray($style);
        $spreadsheet->getActiveSheet()->getStyle('A'.($i+5).':G'.($i+5))->getFont()->setSize('10')->setName('Arial');
        $spreadsheet->getActiveSheet()->getStyle('A'.($i+5).':G'.($i+5))->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFFFFF00');
      }

      $r_total_formasi += $q->formasi_ao;
      $r_total_tetap += $tetap;
      $r_total_kontrak += $kontrak;
      $r_total_jumlah += $jumlah;
      $r_total_kurang_lebih += $kurang_lebih;

      if ($q->uker == $q->kanca) {
        // Styling
        $style = array(
          'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => TRUE
          )
        );
        $spreadsheet->getDefaultStyle()->applyFromArray($style);
        $spreadsheet->getActiveSheet()->getStyle('A'.($i+5).':G'.($i+5))->getFont()->setSize('10')->setName('Arial');
        $spreadsheet->getActiveSheet()->getStyle('A'.($i+5).':G'.($i+5))->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFFFFF00');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.($i+5), $j);
        $j++;
      }

      $spreadsheet->setActiveSheetIndex(0)
      // ->setCellValue('A'.($i+5), $i)
      ->setCellValue('B'.($i+5), $q->uker)
      ->setCellValue('C'.($i+5), $q->formasi_ao)
      ->setCellValue('D'.($i+5), $tetap) // PT
      ->setCellValue('E'.($i+5), $kontrak) // KONTRAK
      ->setCellValue('F'.($i+5), $jumlah) // JUMLAH
      ->setCellValue('G'.($i+5), $jumlah - $q->formasi_ao) // -/+

      // ->setCellValue('I'.($i+5), $r_total_formasi) // cobak2
      ;

      $i++;
    }

    // $spreadsheet->setActiveSheetIndex(0)
    // ->mergeCells('A'.($i+6).':B'.($i+6))
    // ->setCellValue('A'.($i+6), "TOTAL JUMLAH AO KCP")
    // ->setCellValue('B'.($i+6), "TOTAL JUMLAH AO KCP")
    // ;

    $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('B'.($i+5), "KETERANGAN :")
    ->setCellValue('B'.($i+6), "- PIC NPL TERMASUK DI PEMENUHAN RITEL")
    ->setCellValue('B'.($i+7), "- PEMENUHAN AO NPL TIDAK TERMASUK PIC NPL HANYA AO NPL & AO PPS");

    $i+=2;
    $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A'.($i+5), $i)
    ->setCellValue('B'.($i+5), $q->uker)
    ->setCellValue('C'.($i+5), $q->formasi_ao)
    ->setCellValue('D'.($i+5), $tetap) // PT
    ->setCellValue('E'.($i+5), $kontrak) // KONTRAK
    ->setCellValue('F'.($i+5), $jumlah) // JUMLAH
    ->setCellValue('G'.($i+5), $jumlah - $q->formasi_ao) // -/+
    ;

    // Styling
    $style = array(
      'alignment' => array(
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
        'wrapText' => TRUE
      )
    );
    $spreadsheet->getDefaultStyle()->applyFromArray($style);
    // Font
    $spreadsheet->getDefaultStyle()->getFont()->setSize('10')->setName('Arial');
    $spreadsheet->getActiveSheet()->getStyle('A1:G5')->getFont()->setSize('11')->setName('Calibri');
    $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
    // cell bakground color
    $spreadsheet->getActiveSheet()->getStyle('A2:G5')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFAAAAAA');
    $spreadsheet->getActiveSheet()->getStyle('C2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FF55CC55');






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