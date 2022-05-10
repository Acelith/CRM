<?php

# Importo i file necessari
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "dependencies.php";

# Controllo se l'utente è loggato
if (!utente::isLogged()) {
    die();
}

declare(strict_types=1);

use Sprain\SwissQrBill as QrBill;

require ROOT_PATH . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

# Prende le informazioni necessarie per la creazione

# Informazioni sul creditore
$creditore = array(
    "QRIban" => Impostazioni::getSetting("qriban"),
    "nome" => Impostazioni::getSetting("nome"),
    "via" => Impostazioni::getSetting("via"),
    "via_n" => Impostazioni::getSetting("numero_via"),
    "cap" => Impostazioni::getSetting("cap"),
    "citta" => Impostazioni::getSetting("citta"),
);

# Informazioni sul debitore
$debitore = array(
    "nome" => $_POST["db_nome"],
    "via" => $_POST["db_via"],
    "via_n" => $_POST["db_via_n"],
    "cap" => $_POST["db_cap"],
    "citta" => $_POST["db_citta"]
);

$fattura_totale = $_POST['totale'];
$besrID = $_POST['besrID']; # Se post finance NULL
$numero_fattura = $_POST['numero_fattura']; # Numero interno per riconoscimento
$info_supp = $_POST['info_supp'];

$qrBill = QrBill\QrBill::create();

# Impostazione del creditore
$qrBill->setCreditor(
    QrBill\DataGroup\Element\StructuredAddress::create(
        $creditore["nome"],
        $creditore["via"],
        $creditore["via_n"],
        $creditore["cap"],
        $creditore["citta"],
        'CH'
    )
);

# Impostazione dell'iban QR del creditore
$qrBill->setCreditorInformation(
    QrBill\DataGroup\Element\CreditorInformation::create(
        $creditore["QRIban"]
    )
);


# Impostazione del debitore
$qrBill->setUltimateDebtor(
    QrBill\DataGroup\Element\StructuredAddress::createWithStreet(
        $debitore["nome"],
        $debitore["via"],
        $debitore["via_n"],
        $debitore["cap"],
        $debitore["citta"],
        'CH'
    )
);

# Totale fattura da pagare
$qrBill->setPaymentAmountInformation(
    QrBill\DataGroup\Element\PaymentAmountInformation::create(
        'CHF',
        $fattura_totale
    )
);

# Identificatore pagamento
$referenceNumber = QrBill\Reference\QrPaymentReferenceGenerator::generate(
    $besrID,  // You receive this number from your bank (BESR-ID). Unless your bank is PostFinance, in that case use NULL.
    $numero_fattura # Numero della fattura interno
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
        $info_supp
    )
);

// 2. Create a full payment part in HTML
$output = new QrBill\PaymentPart\Output\HtmlOutput\HtmlOutput($qrBill, 'it');

$html = $output
    ->setPrintable(false)
    ->getPaymentPart();

print $html;