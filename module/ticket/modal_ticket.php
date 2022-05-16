        <!-- Modal -->

        <div class="modal fade" id="modal_ticket" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="titolo_modal_ticket" class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                        <!-- body -->
                        <span class="hidden" id="id_ticket"></span>
                        <span class="hidden" id="id_azienda"></span>
                        <span class="hidden" id="id_operatore"></span>
                        <h3>Dettagli ticket</h3>
                        <div class="row">
                            <div class="col">
                                <label for="titolo">Titolo</label>
                                <input type="text" id="titolo" class="form-control" id="titolo" placeholder="Titolo">
                            </div>
                            <div class="col">
                                <label for="data_inizio">Data di inizio</label>
                                <input type="text" class="form-control" id="data_inizio">
                            </div>
                            <div class="col">
                                <label for="ore">Ore</label>
                                <input type="text" id="ore" class="form-control" placeholder="Ore">
                            </div>
                            <div class="col">
                                <label for="fatturare">Da fatturare</label>
                                <input type="checkbox" id="fatturare" class="form-control">
                            </div>
                            <div class="col">
                               <?php echo getStatoTicket()?>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col">
                                <label for="azienda">Azienda</label>
                                <input type="text" id="azienda" class="form-control" placeholder="Azienda" readonly>
                            </div>
                            <div class="col">
                                <br>
                                <button class="btn btn-primary" id="selAzienda" onclick="openModalSelezionaAzienda()">Seleziona</button>
                            </div>
                            <div class="col">
                                <label for="operatore">Operatore</label>
                                <input type="text" id="operatore" class="form-control" placeholder="Operatore" readonly>
                            </div>
                            <div class="col">
                                <br>
                                <button class="btn btn-primary" id="selOperatore" onclick="openModalSelOperatore()">Seleziona</button>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <h3>Descrizione</h3>
                        <div class="row">
                            <div class="col">
                                <textarea class="form-control" id="descrizione" rows="5"></textarea>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <h3>Soluzione</h3>
                        <div class="row">
                            <div class="col">
                                <textarea class="form-control" id="soluzione" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mr-auto" id="btn_cancella" onclick="deleteTicket()">Cancella</button>
                        <button type="button" class="btn btn-success" id="btn_modifica" onclick="modificaTicket()">Aggiorna</button>
                        <button type="button" class="btn btn-primary" id="btn_aggiungi" onclick="creaTicket()">Aggiungi</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
        </div>