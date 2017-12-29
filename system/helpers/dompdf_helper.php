<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html) 
{
    require_once("dompdf/autoload.inc.php");

    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    // if ($stream) {
    //     $dompdf->stream($filename.".pdf");
    // } else {
    //     return $dompdf->output();
    // }
    //echo base64_encode($dompdf->output());
    return $dompdf->output();
}
?>