<?php declare(strict_types=1);

/**
 * fattura.php file per la creazione della fattura
 * 
 * @author Joël Moix  
 */
# Controllo se l'utente è loggato
if (!utente::isLogged()) {
    die();
}

require ROOT_PATH . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

use Sprain\SwissQrBill as QrBill;


/* Crea la fattura. */
class Fattura {

    public $debitore;
    public $creditore;
    public $testa;
    public $corpo;
    public $totale;
    public $fattura_totale;
    public $besrID;
    public $numero_fattura;
    public $info_supp;
    public $rige;
    public $fatturaQR;

    /**
     * Costruttore
     * 
     * @param p_totale totale fattura senza iva
     * @param p_besrID besr ID
     * @param p_numero_fattura Numero fattura (identificatore interno)
     * @param p_info_supp informazioni supplementari
     */
    function __construct($p_totale, $p_besrID, $p_numero_fattura, $p_info_supp) {
         $this->totale = $p_totale;
         $this->besrID = $p_besrID;
         $this->numero_fattura = $p_numero_fattura;
         $this->info_supp = $p_info_supp;    

         $this->setCreditore();
    }

    function getTesta(){
        return $this->testa;
    }

    function getCorpo() {
        return $this->corpo;
    }
    function calcolaTotale(){
        $this->totale_iva =  (($this->totale/100)*Impostazioni::getSetting("iva"));
        $this->fattura_totale = $this->totale_iva + $this->totale;
    }
    /**
     * imposta i valori del debitore
     * 
     * @param p_nome Nome debitore
     * @param p_via Via delle Rose, 1
     * @param p_citta "Milano"
     * @param p_cap "12345"
     */
    function setDebitore($p_nome, $p_via, $p_citta, $p_cap) {
        $this->debitore = array(
            "nome" => $p_nome,
            "via" => $p_via,
            "citta" => $p_citta,
            "cap" => $p_cap
        );
    }

    /**
     * Imposta i valori del creditore
     */
    function setCreditore() {
        
        $this->creditore = array(
            "QRIban" => Impostazioni::getSetting("qriban"),
            "nome" => Impostazioni::getSetting("nome"),
            "via" => Impostazioni::getSetting("via"),
            "via_n" => Impostazioni::getSetting("numero_via"),
            "cap" => Impostazioni::getSetting("cap"),
            "citta" => Impostazioni::getSetting("citta"),
        );
    }

    /**
     * Crea le righe della fattura
     * 
     * @param p_id_progetto id del progetto
     * @param p_fattura_on_budget calcolare sul budget usato o sul totale delle ore dei task?
     */
    function setRigeFattura($p_id_progetto, $p_fattura_on_budget = true) {
        if ($p_fattura_on_budget) {
            $sqlStmt = "SELECT * from progetto where id=:id";
            $parArr = array(
                ":id" => $p_id_progetto
            );
    
            try {
                # faccio la connessione al databse
                $dbConnect = DB::connect();
                $sth = $dbConnect->prepare($sqlStmt);
                # Eseguo la query;
                $sth->execute($parArr);
            } catch (PDOException $e) {
                echo "errore query: " . $e;
            }
        }
    
        while($row= $sth->fetch(PDO::FETCH_OBJ)) {
            $this->rige .= "
            <tr class='item'>
            <td>$row->nome</td>
    
            <td>$row->budget_usato</td>
        </tr>";
        }
    }

    function getPdf(){
        $tcPdf = new TCPDF('P', 'mm', 'A4', true, 'ISO-8859-1');
        $tcPdf->setPrintHeader(false);
        $tcPdf->setPrintFooter(false);
        $tcPdf->AddPage();
        $tcPdf->writeHtml($this->testa);
    
        
        // 3. Create a full payment part for TcPDF
        $output = new QrBill\PaymentPart\Output\TcPdfOutput\TcPdfOutput($this->fatturaQR, 'it', $tcPdf);
        $output
            ->setPrintable(false)
            ->getPaymentPart();
        
        // 4. For demo purposes, let's save the generated example in a file
        $examplePath = __DIR__ . "/test.pdf";
        $tcPdf->Output($examplePath, 'F');
    }

    /**
     * Ritorna la testa della fattuzra
     */
    function setTestaFattura() {
       $this->testa .= "
       <style>
            body {
                font-family: 'Helvetica', Helvetica, Arial, sans-serif;
                text-align: center;
                color: #777;
            }
        
            body h1 {
                font-weight: 300;
                margin-bottom: 0px;
                padding-bottom: 0px;
                color: #000;
            }
        
            body h3 {
                font-weight: 300;
                margin-top: 10px;
                margin-bottom: 20px;
                font-style: italic;
                color: #555;
            }
        
            body a {
                color: #06f;
            }
        
            .fattura-box {
                max-width: 800px;
                margin: auto;
                padding: 30px;
                border: 1px solid #eee;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
                font-size: 16px;
                line-height: 24px;
                font-family: 'Helvetica', Helvetica, Arial, sans-serif;
                color: #555;
            }
        
            .fattura-box table {
                width: 100%;
                line-height: inherit;
                text-align: left;
                border-collapse: collapse;
            }
        
            .fattura-box table td {
                padding: 5px;
                vertical-align: top;
            }
        
            .fattura-box table tr td:nth-child(2) {
                text-align: right;
            }
        
            .fattura-box table tr.top table td {
                padding-bottom: 20px;
            }
        
            .fattura-box table tr.top table td.title {
                font-size: 45px;
                line-height: 45px;
                color: #333;
            }
        
            .fattura-box table tr.information table td {
                padding-bottom: 40px;
            }
        
            .fattura-box table tr.heading td {
                background: #eee;
                border-bottom: 1px solid #ddd;
                font-weight: bold;
            }
        
            .fattura-box table tr.details td {
                padding-bottom: 20px;
            }
        
            .fattura-box table tr.item td {
                border-bottom: 1px solid #eee;
            }
        
            .fattura-box table tr.item.last td {
                border-bottom: none;
            }
        
            .fattura-box table tr.total td:nth-child(2) {
                border-top: 2px solid #eee;
                font-weight: bold;
            }
        
            #qr-bill{
                
            }
       </style>
       
           <div class='fattura-box'>
           <table>
                <tr class='top'>
                    <td colspan='2'>
                        <table>
                            <tr>
                                <td class='title'>
                                   
                                </td>
        
                                <td>
                                    
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
        
                <tr class='information'>
                    <td colspan='2'>
                        <table>
                            <tr>
                                <td>
                                
                                </td>
        
                                <td>
                                    " . $this->debitore["nome"] . "<br>
                                    " . $this->debitore["cap"] . "&nbsp;" . $this->debitore["citta"] . " <br>
                                    <br>
                                    <br>
                                    " . Impostazioni::getSetting("citta") . ", " . date("j F Y") . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
        
                <tr class='heading'>
                    <td>Prestazione</td>
        
                    <td>Prezzo</td>
                </tr>
                    " . $this->rige . "
                <tr class='total'>
                    <td>Totale netto</td>
                    <td> " . $this->totale . " " . Impostazioni::getSetting("valuta") . "</td>
                </tr>
                <tr class='total'>
                    <td>IVA del " . Impostazioni::getSetting("iva") . "</td>
                    <td>" . $this->totale_iva . " " . Impostazioni::getSetting("valuta") . "</td>
                </tr>
                <tr class='total'>
                    <td>Totale fattura</td>
                    <td>" . $this->fattura_totale . " " . Impostazioni::getSetting("valuta") . "</td>
                </tr>
           </table>
       </div>
       ";  
    }  
        
    /**
     * It creates a QR code for a bill.
     */
    function setCorpoFattura() {
            $qrBill = QrBill\QrBill::create();

            # Impostazione del creditore
            $qrBill->setCreditor(
                QrBill\DataGroup\Element\CombinedAddress::create(
                    $this->creditore["nome"],
                    $this->creditore["via"] . " " . $this->creditore["via_n"],
                    $this->creditore["cap"] . " " . $this->creditore["citta"],                    
                    'CH'
                )
            );

            # Impostazione dell'iban QR del creditore
            $qrBill->setCreditorInformation(
                QrBill\DataGroup\Element\CreditorInformation::create(
                    $this->creditore["QRIban"]
                )
            );


            # Impostazione del debitore
            $qrBill->setUltimateDebtor(
                QrBill\DataGroup\Element\CombinedAddress::create(
                    $this->debitore["nome"],
                    $this->debitore["via"],
                    $this->debitore["cap"] . " " . $this->debitore["citta"],
                    'CH'
                )
            );

            # Totale fattura da pagare
            $qrBill->setPaymentAmountInformation(
                QrBill\DataGroup\Element\PaymentAmountInformation::create(
                    'CHF',
                    $this->fattura_totale
                )
            );

            # Identificatore pagamento
            $referenceNumber = QrBill\Reference\QrPaymentReferenceGenerator::generate(
                $this->besrID,  // You receive this number from your bank (BESR-ID). Unless your bank is PostFinance, in that case use NULL.
                $this->numero_fattura # Numero della fattura interno
            );

            $qrBill->setPaymentReference(
                QrBill\DataGroup\Element\PaymentReference::create(
                    QrBill\DataGroup\Element\PaymentReference::TYPE_QR,
                    $referenceNumber
                )
            );

            # Informazioni supplementari da inserire nella fattura
            $qrBill->setAdditionalInformation(
                QrBill\DataGroup\Element\AdditionalInformation::create(
                    $this->info_supp
                )
            );

            // 2. Create a full payment part in HTML
           /* $output = new QrBill\PaymentPart\Output\HtmlOutput\HtmlOutput($qrBill, 'it');

            $html = $output
                ->setPrintable(false)
                ->getPaymentPart();

                $this->corpo = $html;*/
            $this->fatturaQR = $qrBill;
    }
}   