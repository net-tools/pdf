# net-tools/pdf


## Composer library for creating PDF files through TCPDF lib

### Setup instructions 

To install net-tools/pdf package, just require it through composer : `require net-tools/pdf:^1.0.0`


### How to use ?

The package has an only helper class, `PdfHelper` ; you have to create an object of that class before using it.

The class constructor requires the following parameters :

parameter   |  mandatory/default value | description
------------|--------------------------|---------------
configfile  | mandatory                | the path to an external config file for TCPDF library (which is a composer dependancy)
orientation | mandatory                | provide either L or P (landscape or portrait)
author      | mandatory                | author of the document (will appear in the PDF document properties)
title       | mandatory                | title of the document (will appear in the PDF document properties)
subject     | empty string             | subject of the document (will appear in the PDF document properties)
fontsize    | 10                       | base font size to use
fontname    | helvetica                | default font to use

By default, PDF files created don't have any header/footer, but the header may be specified with `setHeader` method.

To create the document, just use HTML tags and simple CSS formatting (with `addHTMLPage`), and get the PDF file by calling `output` method.


### Sample 

```php
$pdfh = new \Nettools\Pdf\PdfHelper($cfgfile, 'P', 'Me', 'Dummy title');
$pdfh->addHTMLPage("<p><strong>This is a simple PDF file</strong></p><p>with two lines. First is bold, the second is in normal print.</p>");
$pdfh->output($path_to_file_to_be_created);
```

You can also create a blank page, and then output several strings to it :
```php
$pdfh->addPage();
$pdfh->writeHTML("<p>first line</p>");
$pdfh->writeHTML("<p>second line</p>");
$pdfh->output($path_to_file_to_be_created);
```
