<?php

declare(strict_types=1);

/**
 * fattura.php file per la creazione della fattura
 * 
 * @author Joël Moix  
 */
# Controllo se l'utente è loggato
if (!utente::isLogged()) {
    die();
}

use Sprain\SwissQrBill as QrBill;


/* Crea la fattura. */

class Fattura
{

    private $debitore;                  # Array con i dati del debitore
    private $creditore;                 # Array con i dati del creditore
    private $totale_netto;              # Totale conteggiando solo le prestazioni
    private $fattura_totale;            # Totale delle prestazioni + IVA
    private $besrID;                    # Besr ID
    private $numero_fattura;            # Numero della fattura (ID)
    private $identificativo_fattura;    # Identificativo interno della fattura
    private $info_supp;                 # Informazioni supplementari
    private $riga = array();            # array di rige
    private $fatturaQR;                 # Codice QR        

    /**
     * Costruttore
     * 
     * @param p_besrID besr ID
     * @param p_info_supp informazioni supplementari
     */
    function __construct($p_besrID, $p_info_supp)
    {
        $this->besrID = $p_besrID;
        $this->info_supp = $p_info_supp;

        $this->setCreditore();
    }

    /**
     * Calcolo il totale della fattura
     */
    function calcolaTotale()
    {
        $this->totale_iva =  (($this->totale_netto / 100) * Impostazioni::getSetting("iva"));
        $this->fattura_totale = $this->totale_iva + $this->totale_netto;
    }
    /**
     * imposta i valori del debitore
     * 
     * @param p_nome Nome debitore
     * @param p_via Via delle Rose, 1
     * @param p_citta "Milano"
     * @param p_cap "12345"
     */
    function setDebitore($p_nome, $p_via, $p_citta, $p_cap, $p_id)
    {
        $this->debitore = array(
            "nome" => $p_nome,
            "via" => $p_via,
            "citta" => $p_citta,
            "cap" => $p_cap,
            "id" => $p_id,
        );
    }

    /**
     * Imposta i valori del creditore
     */
    function setCreditore()
    {

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
     * Crea le riga della fattura per il progetto
     * 
     * @param p_id_progetto id del progetto
     * @param p_fattura_on_budget calcolare sul budget usato o sul totale delle ore dei task?
     */
    function setRigeFatturaProgetto($p_id_progetto, $p_fattura_on_budget = true)
    {
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

            $row = $sth->fetch(PDO::FETCH_OBJ);
            $riga = array(
                "prestazione" => $row->nome,
                "ore" => "forfait",
                "prezzo" => $row->budget_usato
            );

            $this->totale_netto = $row->budget_usato;
            array_push($this->riga, $riga);
        } else {
            $sqlStmt = "SELECT prj.nome, SUM(tsk.ore_lavorate) as ore_lavorate
            from progetto as prj
            inner join task_progetto as tsk on tsk.id_progetto = prj.id
            where prj.id=:id";

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

            $row = $sth->fetch(PDO::FETCH_OBJ);
            $ore = $row->ore_lavorate;
            $tariffa = Impostazioni::getSetting("tariffa_oraria");
            $this->totale_netto = $tariffa * $ore;

            $riga = array(
                "prestazione" => $row->nome,
                "ore" => $row->ore_lavorate,
                "prezzo" => $this->totale_netto
            );


            array_push($this->riga, $riga);
        }
    }

    /**
     * Crea le riga della fattura per il ticket
     * 
     * @param p_id_ticket id del/dei ticket
     */
    function setRigeFatturaTicket($p_id_ticket)
    {

        if (is_array($p_id_ticket)) {
            $id = "in (";
            foreach ($p_id_ticket as $key => $value) {
                if ($key == 0) {
                    $id .= "$value";
                } else {
                    $id .= ", $value";
                }
            }
            $id .= ")";
        } else {
            $id = "=" . $p_id_ticket;
        }
        $sqlStmt = "SELECT tk.*, az.nome as nome_azienda      
                    FROM ticket as tk 
                    inner join azienda as az on az.id = tk.id_azienda
                    where tk.id " . $id;
        try {
            # faccio la connessione al databse
            $dbConnect = DB::connect();
            $sth = $dbConnect->prepare($sqlStmt);
            # Eseguo la query;
            $sth->execute();
        } catch (PDOException $e) {
            echo "errore query: " . $e;
        }

        $tot = 0;
        while ($row = $sth->fetch(PDO::FETCH_OBJ)) {
            $prezzo = $row->ore * Impostazioni::getSetting("tariffa_oraria");
            $riga = array(
                "prestazione" => $row->titolo,
                "ore" => $row->ore,
                "prezzo" => $prezzo
            );
            array_push($this->riga, $riga);
            $tot = $tot + $row->ore;
        }

        $this->totale_netto = $tot * Impostazioni::getSetting("tariffa_oraria");
    }

    /**
     * Crea il PDF e poi lo fa scaricare al client
     */
    function getPdf()
    {
        $fatt = new TCPDF('P', 'mm', 'A4', true, 'ISO-8859-1');

        $fatt->AddPage();


        $fatt->Cell(105, 10, '', 0, 0);
        $fatt->image(IMG_PATH . Impostazioni::getSetting("immagine_azienda"), 10, 3, 50, 50);
        $fatt->Cell(59, 10, '', 0, 1);


        $fatt->Cell(71, 5, '', 0, 0);
        $fatt->Cell(59, 5, '', 0, 0);
        $fatt->Cell(59, 5, 'Dettagli', 0, 1);


        $fatt->Cell(130, 5, '', 0, 0);

        $fatt->Cell(130, 5, Impostazioni::getSetting("citta") . ", " . Impostazioni::getSetting("cap"), 0, 1);
        $fatt->Cell(130, 5, '', 0, 0);
        $fatt->Cell(34, 5, date("j F Y"), 0, 1);

        $fatt->Cell(130, 5, '', 0, 0);
        $fatt->Cell(20, 5, 'Fattura N. ', 0, 0);
        $fatt->Cell(34, 5, $this->numero_fattura, 0, 1);


        $fatt->SetFont('', 'B', 12);
        $fatt->Cell(60, 5, 'Indirizzo', 0, 1);
        $fatt->SetFont('', 12);
        $fatt->Cell(60, 5, $this->debitore["nome"], 0, 1);
        $fatt->Cell(60, 5, $this->debitore["via"], 0, 1);
        $fatt->Cell(60, 5, $this->debitore["cap"] . " " . $this->debitore["citta"], 0, 1);


        $fatt->Cell(50, 10, '', 0, 1);


        # Colonne tabella
        $fatt->Cell(15, 6, '', 0,);
        $fatt->SetFont('', 'B', 12);
        $fatt->Cell(80, 6, 'Descrizione', 1, 0, 'C');
        $fatt->SetFont('', 'B', 12);
        $fatt->Cell(30, 6, 'Ore di lavoro', 1, 0, 'C');
        $fatt->SetFont('', 'B', 12);
        $fatt->Cell(45, 6, 'Totale', 1, 1, 'C');


        foreach ($this->riga as $arr) {
            $fatt->SetFont('', 12);
            $fatt->Cell(15, 6, '', 0, 0);
            $fatt->Cell(80, 6, $arr["prestazione"], 1, 0);
            $fatt->Cell(30, 6, $arr["ore"], 1, 0, 'R');
            $fatt->Cell(45, 6, $arr["prezzo"] . " " . Impostazioni::getSetting("valuta"), 1, 1, 'R');
        }

        # spaziatore
        $fatt->Cell(95, 6, '', 0, 0);
        $fatt->Cell(30, 6, '', 0, 0);
        $fatt->Cell(45, 6, '', 0, 1, 'R');

        # cella totale netto
        $fatt->Cell(95, 6, '', 0, 0);
        $fatt->Cell(30, 6, 'Totale netto', 0, 0);
        $fatt->Cell(45, 6, $this->totale_netto . " " . Impostazioni::getSetting("valuta"), 1, 1, 'R');

        # cella IVA
        $fatt->Cell(95, 6, '', 0, 0);
        $fatt->Cell(30, 6, 'IVA ' . Impostazioni::getSetting("iva") . '%', 0, 0);
        $fatt->Cell(45, 6, $this->totale_iva . " " . Impostazioni::getSetting("valuta"), 1, 1, 'R');

        #cella totale fattura
        $fatt->Cell(95, 6, '', 0, 0);
        $fatt->Cell(30, 6, 'Totale fattura', 0, 0);
        $fatt->Cell(45, 6, $this->fattura_totale . " " . Impostazioni::getSetting("valuta"), 1, 1, 'R');



        $fatt->setPrintHeader(false);
        $fatt->setPrintFooter(false);

        $this->creaQr();

        # Appende al PDF la parte del QR
        $output = new QrBill\PaymentPart\Output\TcPdfOutput\TcPdfOutput($this->fatturaQR, 'it', $fatt);
        $output
            ->setPrintable(false)
            ->getPaymentPart();

        $fatt->Output("fattura.pdf", 'D');
    }

    /**
     *  Crea una fattura QR.
     */
    function creaQr()
    {
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
            $this->identificativo_fattura # Numero della fattura interno
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


        $this->fatturaQR = $qrBill;
    }

    /**
     * Aggiorna la tabella dei ticket con il numero della fattura
     * 
     * @param p_id_ticket id del/dei ticket
     */
    function salvaFatturaTicket($p_id_ticket)
    {
        $parArr = array(
            ":id_fattura" => $this->numero_fattura
        );

        $sqlStmt = "UPDATE ticket
                    SET id_fattura=:id_fattura 
                    WHERE id=:id";

        # Controllo se è un array o no
        if (is_array($p_id_ticket)) {

            # Aggiorno ogni ticket con il numero fattura rispettivo
            foreach ($p_id_ticket as $value) {
                $parArr[":id"] = $value;

                try {
                    # faccio la connessione al databse
                    $dbConnect = DB::connect();
                    $sth = $dbConnect->prepare($sqlStmt);

                    # Eseguo la query;
                    $sth->execute($parArr);
                } catch (PDOException $e) {
                    echo $e;
                    break;
                }
            }
        } else {

            $parArr[":id"] = $p_id_ticket;

            try {
                # faccio la connessione al databse
                $dbConnect = DB::connect();
                $sth = $dbConnect->prepare($sqlStmt);

                # Eseguo la query;
                $sth->execute($parArr);
            } catch (PDOException $e) {
                echo $e;
            }
        }
    }

    /**
     * Aggiorna il progetto con l'id della fattura
     * 
     * @param p_id_progetto id del progetto
     */
    function salvaFatturaProgetto($p_id_progetto)
    {
        $sqlStmt = "UPDATE progetto
                    SET id_fattura=:id_fattura 
                    WHERE id=:id";

        $parArr = array(
            ":id" => $p_id_progetto,
            ":id_fattura" => $this->numero_fattura
        );

        try {
            # faccio la connessione al databse
            $dbConnect = DB::connect();
            $sth = $dbConnect->prepare($sqlStmt);

            # Eseguo la query;
            $sth->execute($parArr);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /**
     * Ristampa la fattura selezionata
     * 
     * @param p_if_fattura  ID Della fattura da ristampare
     */
    function ristampaFattura($p_id_fattura)
    {
        $sqlStmt = "SELECT ft.id as n_fattura, ft.importo_totale, ft.identificativo_interno, ft.rige, az.* 
        from fattura as ft
        inner join azienda as az on az.id = ft.id_azienda
        where ft.id=:id";

        $parArr = array(
            ":id" => $p_id_fattura,
        );

        try {
            # faccio la connessione al databse
            $dbConnect = DB::connect();
            $sth = $dbConnect->prepare($sqlStmt);

            # Eseguo la query;
            $sth->execute($parArr);
        } catch (PDOException $e) {
            echo $e;
        }

        $row = $sth->fetch(PDO::FETCH_OBJ);
        $this->identificativo_fattura = $row->identificativo_interno;
        $this->numero_fattura = $row->n_fattura;
        $this->setDebitore($row->nome, $row->indirizzo, $row->citta, $row->cap, $row->id);
        $this->setCreditore();
        $this->totale_netto = (100 * $row->importo_totale) / (100 + Impostazioni::getSetting('iva'));
        $this->totale_iva =  $row->importo_totale - $this->totale_netto;
        $this->riga = unserialize($row->rige);
        $this->fattura_totale = floatval($row->importo_totale);
    }

    /**
     * Crea la nuova fattura nel database
     * 
     * @return int  ID della fattura
     */
    function creaFattura()
    {
        $sqlStmt = "INSERT INTO fattura 
                    (importo_totale, id_azienda, id_utente_emissione, rige)
                    VALUES(:importo_totale, :id_azienda, :id_utente, :rige)";

        $parArr = array(
            ":importo_totale" => $this->fattura_totale,
            ":id_azienda" => $this->debitore["id"],
            ":id_utente" => Utente::getCurrentUserId(),
            ":rige" => serialize($this->riga)
        );

        try {
            # faccio la connessione al databse
            $dbConnect = DB::connect();
            $sth = $dbConnect->prepare($sqlStmt);

            # Eseguo la query;
            $sth->execute($parArr);
            $this->numero_fattura = $dbConnect->lastInsertId();
        } catch (PDOException $e) {
            echo $e;
        }

        # Ora inserisco nel database il numero di riferimento
        $this->creaNumeroRiferimento();

        $sqlStmt = "UPDATE fattura
                    SET identificativo_interno=:identificativo
                    WHERE id=:id";

        $parArr = array(
            ":identificativo" => $this->identificativo_fattura,
            ":id" => $this->numero_fattura
        );

        try {
            # faccio la connessione al databse
            $dbConnect = DB::connect();
            $sth = $dbConnect->prepare($sqlStmt);

            # Eseguo la query;
            $sth->execute($parArr);
        } catch (PDOException $e) {
            echo $e;
        }
    }


    /**
     * Genera il numero di riferiemnto della fattura
     *
     */
    function creaNumeroRiferimento()
    {
        # Genero le prime 26 cifre del numero di riferimento 
        $riferimento = "0" . "0" . $this->debitore["id"] . "0" . "0" . $this->numero_fattura;
        for ($i = 0; $i < 25 - strlen($riferimento); $i++) {
            $riferimento .= "0";
        }

        # Genero il check digit 
        $tabella = [0, 9, 4, 6, 8, 2, 7, 1, 3, 5];

        $carry = 0;
        for ($i = 0; $i < strlen($riferimento); $i++) {
            $carry = $tabella[($carry + substr($riferimento, $i, 1)) % 10];
        }
        $digit = (10 - $carry) % 10;

        $riferimento .= $digit;

        $this->identificativo_fattura = $riferimento;
    }
}
