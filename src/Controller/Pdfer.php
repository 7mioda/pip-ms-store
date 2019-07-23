<?php


namespace App\Controller;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Dompdf\Dompdf;
use Dompdf\Options;


class Pdfer
{

    private $dompdf;
    private $templating;


    public function __construct(Environment $templating)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $this->dompdf = new Dompdf($pdfOptions);;
        $this->templating = $templating;
    }


    /**
     * @param $template
     * @param array $option
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function setTemplate($template, array $option)
    {
        return $this->templating->render($template, $option);

    }

    /**
     * @param array $data
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function  generatePdf(array $data)
    {
        $html = $this->setTemplate(
            'Pdfer/pdf_template.html.twig',
            ['identifier' => 'test']);
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        $this->dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }

}

