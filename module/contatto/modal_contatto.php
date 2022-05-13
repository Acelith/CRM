        <!-- Modal -->
        <div class="modal fade" id="modal_contatto" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="titolo_modal_contatto" class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                        <!-- body -->
                        <span class="hidden" id="id_contatto"></span>
                        <span class="hidden" id="id_azienda"></span>
                        <h3>Dettagli</h3>
                        <div class="row">
                            <div class="col">
                                <label for="nome">Nome</label>
                                <input type="text" id="nome" class="form-control" id="nome" placeholder="Nome">
                            </div>
                            <div class="col">
                                <label for="cognome">Cognome</label>
                                <input type="text" id="cognome" class="form-control" id="cognome" placeholder="Cognome">
                            </div>
                            <div class="col">
                                <label for="telefono">Numero di telefono</label>
                                <input type="text" id="telefono" class="form-control" placeholder="Telefono">
                            </div>


                        </div>
                        <div class="row">

                            <div class="col-4"><br>
                                <label for="azienda">Azienda</label>
                                <input type="text" id="azienda" class="form-control" placeholder="Azienda" readonly>
                                <button class="btn btn-primary" id="selAzienda" onclick="openModalSelezionaAzienda()">Seleziona</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mr-auto" id="btn_cancella" onclick="deleteContatto()">Cancella</button>
                        <button type="button" class="btn btn-success" id="btn_modifica" onclick="modificaContatto()">Aggiorna</button>
                        <button type="button" class="btn btn-primary" id="btn_aggiungi" onclick="creaContatto()">Aggiungi</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
        </div>