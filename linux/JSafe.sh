#!/bin/bash

# definisco i parametri e prendo quelli passati dall'utente
remote_id_backup=$1                        # ID del backup remoto
local_path=$2                              # Percorso dove andare a prendere i dati da backuppare
remote_clt_id="1"                          # ID dell'azienda di connessione
remote_user="test"                         # Utente remoto per connessione SSH
remote_addr='out2.pingitoreinformatica.ch' # Indirizzo remoto dove effettuare la connessione

# Controllo se l'utente ha passato i parametri richiesti
if [ -z ${1} ] || [ -z ${2} ] 
then
    echo "non sono stati definiti tutti i parametri"
    exit
fi

# Funzione per eseguire un comando ssh
function executeSSHcommand () {
    comando=$1
    # opzione -T per disabilitare la richiesta da parte del client di un terminale sul server
    cmd=$(ssh -T $remote_user@$remote_addr "${comando}" < /dev/null)
}

# Definisco la funzione per eseguire le query
function doQuery () {
    cmd="mysql --defaults-file=/script/pwd.txt  --skip-column-names -e \"$query\""  
    executeSSHcommand "$cmd"
}

# Eseguo la query
query="SELECT abilitata FROM schedulazione where id=$remote_id_backup and id_cliente=$remote_clt_id;"
doQuery 

# Controllo se   il backup è abilitato
if  [[ "${cmd}" == 0 ]]
then
    echo "Non sei abilitato ad eseguire questo backup"
    exit
fi

# Prendo dal DB il percorso di destinazione
query="SELECT percorso_backup FROM schedulazione WHERE id=$remote_id_backup and id_cliente=$remote_clt_id;"
doQuery 
dest_path=$cmd

# Aggiorno lo stato del backup nel database
query="UPDATE schedulazione SET id_stato=1 WHERE id=$remote_id_backup and id_cliente=$remote_clt_id;"
doQuery 

# Eseguo il backup e mi salvo l'output degli errori nel file error.log 
backup=$(rsync -azvq $local_path $remote_user@$remote_addr:$dest_path 2> error.log) 

# Salvo la data e l'ora corrente
data=$(date '+%Y-%m-%d %H:%M:%S')

# Controllo se il file error.log è vuoto
if [ -s error.log ]; 
then 
echo
    # Aggiorno lo stato nel DB 
    query="UPDATE schedulazione SET id_stato=3, dt_last_run='$data' WHERE id=$remote_id_backup and id_cliente=$remote_clt_id;"
    doQuery 
    
    # Mi salvo il contenuto di error.log
    err=$(<error.log)

    # Salvo il messaggio di errore del DB 
    query="INSERT INTO log_schedulazione (id_schedulazione, messaggio) VALUES($remote_id_backup, '$err');"
    doQuery 
    
    # Cancello il file error.log
    rm error.log
    echo "err"
else
     # salvo lo stato nel DB 
    query="UPDATE schedulazione SET id_stato=2, dt_last_run='$data' WHERE id=$remote_id_backup and id_cliente=$remote_clt_id;"
    doQuery 
    echo "ok"
fi