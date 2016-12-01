<?php

// namespace
namespace Nettools\Pdf;



// helper class to create PDF files with TCPDF lib 
class PdfHelper{
	
	protected $_pdf = NULL;
	protected $_encoding = NULL;
	

	// constants
	const ORIENTATION_PORTRAIT = 'P';
	const ORIENTATION_LANDSCAPE = 'L';	
	

	// constructor
	public function __construct($configfile, $orientation, $author, $title, $subject = '', $fontsize = 10, $fontname = 'helvetica')
	{
		// tcpdf being installed through composer, the config file must be included here
		if ( file_exists($configfile) )
			require_once($configfile);

		$this->_encoding = mb_internal_encoding();


		$this->_pdf = new \TCPDF($orientation, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$this->_pdf->SetCreator(PDF_CREATOR);
		$this->_pdf->SetAuthor($author);
		$this->_pdf->SetTitle($title);
		$this->_pdf->SetSubject($subject);

		//set default margins
		$this->_pdf->SetMargins(14, 14, 14);
		$this->_pdf->SetHeaderMargin(0);
		$this->_pdf->SetFooterMargin(0);
		$this->_pdf->setPrintHeader(false);
		
		// set default monospaced font
		$this->_pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set image scale factor
		$this->_pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
		
		//set auto page breaks
		$this->_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set font
		$this->_pdf->SetFont($fontname, '', $fontsize);
	}
	
	
	// get TCPDF instance
	public function getPdf()
	{
		return $this->_pdf;
	}
	

	// set header (logo and two lines)
	public function setHeader($logo, $header1, $header2)
	{
		// set default header data
		$this->_pdf->SetHeaderData($logo, 15, $header1, $header2);
		
		// set header and footer fonts
		$this->_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		//set margins
		$this->_pdf->SetTopMargin(20);
		$this->_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		$this->_pdf->setPrintHeader(true);
	}
	
	
	// page break auto ?
	public function setAutoPageBreak($b)
	{
		if ( $b )
			$this->_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		else
			$this->_pdf->SetAutoPageBreak(FALSE);
	}
	
	
	// new page (blank), must be followed by writeHTML
	public function addPage()
	{
		$this->_pdf->addPage();
	}
	
	
	// create a new page with html content
	public function addHTMLPage($html)
	{
		$this->addPage();
		$this->writeHTML($html);
	}
	
	
	// write html in the current page
	public function writeHTML($html)
	{
		// output the HTML content
		$this->_pdf->writeHTML($html, true, 0, true, 0);
		
		// reset pointer to the last page
		$this->_pdf->lastPage();
	}
	
	
	// output PDF file ; dest=F (file), I (inline), D (download) 
	public function output($filename, $dest = 'F')
	{
		//Close and output PDF document
		$this->_pdf->Output($filename, $dest);
		
		// restore internal encoding (changed internally by TCPDF to USASCII, and not restored ; so we set it back here)
		$this->_pdf = NULL;
		if ( $this->_encoding )
			mb_internal_encoding($this->_encoding);
	}
	
	
}

?>