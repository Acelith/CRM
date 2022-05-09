<?php declare(strict_types=1);

use Sprain\SwissQrBill as QrBill;

require ROOT_PATH . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

// This is an example how to create a typical qr bill:
// - with reference number
// - with known debtor
// - with specified amount
// - with human-readable additional information
// - using your QR-IBAN
//
// Likely the most common use-case in the business world.

// Create a new instance of QrBill, containing default headers with fixed values
$qrBill = QrBill\QrBill::create();

// Add creditor information
// Who will receive the payment and to which bank account?
$qrBill->setCreditor(
    QrBill\DataGroup\Element\CombinedAddress::create(
        'Robert Schneider AG',
        'Rue du Lac 1268',
        '2501 Biel',
        'CH'
    ));

$qrBill->setCreditorInformation(
    QrBill\DataGroup\Element\CreditorInformation::create(
        'CH4431999123000889012' // This is a special QR-IBAN. Classic IBANs will not be valid here.
    ));

// Add debtor information
// Who has to pay the invoice? This part is optional.
//
// Notice how you can use two different styles of addresses: CombinedAddress or StructuredAddress.
// They are interchangeable for creditor as well as debtor.
$qrBill->setUltimateDebtor(
    QrBill\DataGroup\Element\StructuredAddress::createWithStreet(
        'Pia-Maria Rutschmann-Schnyder',
        'Grosse Marktgasse',
        '28',
        '9400',
        'Rorschach',
        'CH'
    ));

// Add payment amount information
// What amount is to be paid?
$qrBill->setPaymentAmountInformation(
    QrBill\DataGroup\Element\PaymentAmountInformation::create(
        'CHF',
        2500.25
    ));

// Add payment reference
// This is what you will need to identify incoming payments.
$referenceNumber = QrBill\Reference\QrPaymentReferenceGenerator::generate(
    '210000',  // You receive this number from your bank (BESR-ID). Unless your bank is PostFinance, in that case use NULL.
    '313947143000901' // A number to match the payment with your internal data, e.g. an invoice number
);

$qrBill->setPaymentReference(
    QrBill\DataGroup\Element\PaymentReference::create(
        QrBill\DataGroup\Element\PaymentReference::TYPE_QR,
        $referenceNumber
    ));

// Optionally, add some human-readable information about what the bill is for.
$qrBill->setAdditionalInformation(
    QrBill\DataGroup\Element\AdditionalInformation::create(
        'Invoice 123456, Gardening work'
    )
);

// Now get the QR code image and save it as a file.
try {
    $qrBill->getQrCode()->writeFile(ROOT_PATH . '/qr.png');
    $qrBill->getQrCode()->writeFile(ROOT_PATH . '/qr.svg');
    print "done";
} catch (Exception $e) {
	foreach($qrBill->getViolations() as $violation) {
		print $violation->getMessage()."\n";
	}
	exit;
}

// Next: Output full payment parts, depending on the format you want to use:
//
// - FpdfOutput/fpdf-example.php
// - HtmlOutput/html-example.php
// - TcPdfOutput/tcpdf-example.php
?>
    <!-- other stuff -->
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 210 110" id="swissqr">
      <g class="cut">
        <line style="fill:none;stroke:#000000;stroke-width:0.176389;stroke-dasharray:3.043478261,3.043478261;" x1="0" y1="5" x2="210" y2="5" />
        <line style="fill:none;stroke:#000000;stroke-width:0.176389;stroke-dasharray:3.043478261,3.043478261;" x1="62" y1="5" x2="62" y2="110" />
        <g transform="scale(-.25) translate(-772 -20)">
          <rect style="fill:#ffffff;stroke:none;" x="0" y="-7" width="21" height="14" />
          <path transform="scale(.01) translate(75 -927)" style="fill:#000000;stroke:none;" d="M1905 1218q-47 44 -93.5 64t-101.5 20q-80 0 -280.5 -65t-567.5 -211q-128 55 -262.5 81.5t-134.5 38.5q0 4 0.5 6t1.5 3q18 34 26.5 64t8.5 59q0 83 -61.5 138.5t-155.5 55.5q-96 0 -156.5 -59t-60.5 -152q0 -98 76.5 -150.5t220.5 -52.5h81q134 0 193.5 -29t83.5 -102 q-23 -72 -83.5 -101.5t-193.5 -29.5h-81q-144 0 -220.5 -52t-76.5 -150q0 -93 60.5 -152t156.5 -59q94 0 155.5 55.5t61.5 138.5q0 29 -8.5 59t-26.5 64q-1 2 -1.5 4t-0.5 4q0 13 134.5 39.5t262.5 81.5q380 -150 574.5 -213t273.5 -63q54 0 101.5 20t93.5 64l-779 290z M436 589q0 -60 -43 -100.5t-108 -40.5q-67 0 -108.5 38.5t-41.5 98.5q0 63 44 103.5t114 40.5q64 0 103.5 -39t39.5 -101zM436 1265q0 -61 -40 -100t-103 -39q-68 0 -113 41t-45 102t41.5 99.5t108.5 38.5q65 0 108 -40.5t43 -101.5z" />
        </g>
        <g transform="scale(-.25) translate(-248 -402) rotate(90)">
          <rect style="fill:#ffffff;stroke:none;" x="0" y="-7" width="21" height="14" />
          <path transform="scale(.01) translate(75 -927)" style="fill:#000000;stroke:none;" d="M1905 1218q-47 44 -93.5 64t-101.5 20q-80 0 -280.5 -65t-567.5 -211q-128 55 -262.5 81.5t-134.5 38.5q0 4 0.5 6t1.5 3q18 34 26.5 64t8.5 59q0 83 -61.5 138.5t-155.5 55.5q-96 0 -156.5 -59t-60.5 -152q0 -98 76.5 -150.5t220.5 -52.5h81q134 0 193.5 -29t83.5 -102 q-23 -72 -83.5 -101.5t-193.5 -29.5h-81q-144 0 -220.5 -52t-76.5 -150q0 -93 60.5 -152t156.5 -59q94 0 155.5 55.5t61.5 138.5q0 29 -8.5 59t-26.5 64q-1 2 -1.5 4t-0.5 4q0 13 134.5 39.5t262.5 81.5q380 -150 574.5 -213t273.5 -63q54 0 101.5 20t93.5 64l-779 290z M436 589q0 -60 -43 -100.5t-108 -40.5q-67 0 -108.5 38.5t-41.5 98.5q0 63 44 103.5t114 40.5q64 0 103.5 -39t39.5 -101zM436 1265q0 -61 -40 -100t-103 -39q-68 0 -113 41t-45 102t41.5 99.5t108.5 38.5q65 0 108 -40.5t43 -101.5z" />
        </g>
      </g>

      <symbol id="cornermark" width="3" height="3" viewBox="0 0 3 3"><!-- x pt * 127 / 360 = y mm -->
        <polygon points="0,0 0,3 0.264583333,3 0.264583333,0.264583333 3,0.264583333 3,0" style="fill:#000000;stroke:none;" />
      </symbol>
      <g class="blankamt" style="display:none;">
        <use href="#cornermark" x="27" y="73.765844727" />
        <use href="#cornermark" x="57" y="73.765844727" transform="rotate(90 57 73.765844727)" />
        <use href="#cornermark" x="27" y="83.765844727" transform="rotate(270 27 83.765844727)" />
        <use href="#cornermark" x="57" y="83.765844727" transform="rotate(180 57 83.765844727)" />
        <use href="#cornermark" x="78" y="77.804185655" />
        <use href="#cornermark" x="118" y="77.804185655" transform="rotate(90 118 77.804185655)" />
        <use href="#cornermark" x="78" y="92.804185655" transform="rotate(270 78 92.804185655)" />
        <use href="#cornermark" x="118" y="92.804185655" transform="rotate(180 118 92.804185655)" />
      </g>
    </svg>
    <div id="qr_bill" class="qr_bill">
      <div id="qr_bill_receipt" class="qr_bill receipt">
        <div id="qr_bill_receipt_title" class="qr_bill receipt title">
          <h2 class="de">Empfangsschein</h2>
          <h2 class="fr">Récépissé</h2>
          <h2 class="it">Ricevuta</h2>
          <h2 class="en">Receipt</h2>
        </div>
        <div id="qr_bill_receipt_information" class="qr_bill receipt information">
          <div>
            <h3 class="de">Konto / Zahlbar an</h3>
            <h3 class="fr">Compte / Payable à</h3>
            <h3 class="it">Conto / Pagabile a</h3>
            <h3 class="en">Account / Payable to</h3>
            <p class="the_cdtr"></p>
          </div>
          <div id="qr_bill_receipt_information_reference" class="qr_bill receipt information reference">
            <h3 class="de">Referenz</h3>
            <h3 class="fr">Référence</h3>
            <h3 class="it">Riferimento</h3>
            <h3 class="en">Reference</h3>
            <p class="the_rmtinf"></p>
          </div>
          <div>
            <h3 class="de">Zahlbar durch<span class="blankdbtr"> (Name/Adresse)</span></h3>
            <h3 class="fr">Payable par<span class="blankdbtr"> (nom/adresse)</span></h3>
            <h3 class="it">Pagabile da<span class="blankdbtr"> (nome/indirizzo)</span></h3>
            <h3 class="en">Payable by<span class="blankdbtr"> (name/address)</span></h3>
            <p class="the_ultmtdbtr"></p>
          </div>
        </div>
        <div id="qr_bill_receipt_amount" class="qr_bill receipt amount">
          <div>
            <h3 class="de">Währung</h3>
            <h3 class="fr">Monnaie</h3>
            <h3 class="it">Valuta</h3>
            <h3 class="en">Currency</h3>
            <p class="the_ccyamt_ccy">CHF</p>
          </div>
          <div>
            <h3 class="de">Betrag</h3>
            <h3 class="fr">Montant</h3>
            <h3 class="it">Importo</h3>
            <h3 class="en">Amount</h3>
            <p class="the_ccyamt_amt"></p>
          </div>
        </div>
        <div id="qr_bill_receipt_acceptancepoint" class="qr_bill receipt acceptancepoint">
          <div>
            <h3 class="de">Annahmestelle</h3>
            <h3 class="fr">Point de dépôt</h3>
            <h3 class="it">Punto di accettazione</h3>
            <h3 class="en">Acceptance point</h3>
          </div>
        </div>
      </div>
      <div id="qr_bill_paymentpart" class="qr_bill paymentpart">
        <div id="qr_bill_paymentpart_title" class="qr_bill paymentpart title">
          <h2 class="de">Zahlteil</h2>
          <h2 class="fr">Section paiement</h2>
          <h2 class="it">Sezione pagamento</h2>
          <h2 class="en">Payment part</h2>
        </div>
        <div id="qr_bill_paymentpart_qrcode" class="qr_bill paymentpart qrcode">
        </div>
        <div id="qr_bill_paymentpart_amount" class="qr_bill paymentpart amount">
          <div>
            <h3 class="de">Währung</h3>
            <h3 class="fr">Monnaie</h3>
            <h3 class="it">Valuta</h3>
            <h3 class="en">Currency</h3>
            <p class="the_ccyamt_ccy">CHF</p>
          </div>
          <div>
            <h3 class="de">Betrag</h3>
            <h3 class="fr">Montant</h3>
            <h3 class="it">Importo</h3>
            <h3 class="en">Amount</h3>
            <p class="the_ccyamt_amt"></p>
          </div>
        </div>
        <div id="qr_bill_paymentpart_information" class="qr_bill paymentpart information">
          <div>
            <h3 class="de">Konto / Zahlbar an</h3>
            <h3 class="fr">Compte / Payable à</h3>
            <h3 class="it">Conto / Pagabile a</h3>
            <h3 class="en">Account / Payable to</h3>
            <p class="the_cdtr"></p>
          </div>
          <div id="qr_bill_paymentpart_information_reference" class="qr_bill paymentpart information reference">
            <h3 class="de">Referenz</h3>
            <h3 class="fr">Référence</h3>
            <h3 class="it">Riferimento</h3>
            <h3 class="en">Reference</h3>
            <p class="the_rmtinf"></p>
          </div>
          <div id="qr_bill_paymentpart_information_addinf" class="qr_bill paymentpart information addinf">
            <h3 class="de">Zusätzliche Informationen</h3>
            <h3 class="fr">Informations additionnelles</h3>
            <h3 class="it">Informazioni aggiuntive</h3>
            <h3 class="en">Additional information</h3>
            <p class="the_addinf"></p>
          </div>
          <div>
            <h3 class="de">Zahlbar durch<span class="blankdbtr"> (Name/Adresse)</span></h3>
            <h3 class="fr">Payable par<span class="blankdbtr"> (nom/adresse)</span></h3>
            <h3 class="it">Pagabile da<span class="blankdbtr"> (nome/indirizzo)</span></h3>
            <h3 class="en">Payable by<span class="blankdbtr"> (name/address)</span></h3>
            <p class="the_ultmtdbtr"></p>
          </div>
        </div>
        <div id="qr_bill_paymentpart_furtherinformation" class="qr_bill paymentpart furtherinformation">
        </div>
      </div>
    </div>


    