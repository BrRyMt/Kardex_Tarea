<?php
require_once "../../vendor/autoload.php";
require_once '../../models/Kardex.php';


use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
  ob_start();
  $kardex = new Kardex();

  include './estilos.html';


  $producto = $_GET['producto'];
  $limit_n = $_GET['limit_n'];
  $datoskr = $kardex->filterMv(['producto'=>$producto,'limit_n'=>$limit_n]);

  //Plantilla
  include './contenido.php';
  
  $content = ob_get_clean();

  $html2pdf = new Html2Pdf('L', 'A4', 'es', true, 'UTF-8', array(15,15,15,15));
  
  $html2pdf->writeHTML($content);
  
  $html2pdf->output('PDF-Generado-PDF.pdf');
} catch (Html2PdfException $e) {
  $html2pdf->clean();

  $formatter = new ExceptionFormatter($e);
  echo $formatter->getHtmlMessage();
}
