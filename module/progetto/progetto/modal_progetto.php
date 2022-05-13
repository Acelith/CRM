        <!-- Modal -->
        
        <div class="modal fade" id="modal_progetto" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="titolo_modal_progetto" class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                        <!-- body -->
                        <span class="hidden" id="id_progetto"></span>
                        <span class="hidden" id="id_azienda"></span>
                        <h3>Dettagli progetto</h3>
                        <div class="row">
                            <div class="col">
                                <label for="nome">Nome</label>
                                <input type="text" id="nome" class="form-control" id="nome" placeholder="Nome">
                            </div>
                            <div class="col">
                                <label for="data_inizio">Data di inizio</label>
                                <input type="text" class="form-control" id="data_inizio">
                            </div>
                            <div class="col">
                                <label for="data_fine_target">Data fine target</label>
                                <input type="text" class="form-control" id="data_fine_target">
                            </div>
                            <div class="col">
                                <label for="data_fine_effettiva">Data fine effettiva</label>
                                <input type="text" class="form-control" id="data_fine_effettiva">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4"><br>
                                <label for="budget">Budget</label>
                                <input type="text" id="budget" class="form-control" placeholder="Budget">
                            </div>
                            <div class="col-4"><br>
                                <label for="budget_usato">Budget usato</label>
                                <input type="text" id="budget_usato" class="form-control" placeholder="Budget usato">
                            </div>
                            <div class="col-4"><br>
                                <label for="progresso">Progresso (%)</label>
                                <input type="text" id="progresso" class="form-control" placeholder="Progresso">
                            </div>
                            <div class="col-4"><br>
                                <label for="azienda">Azienda</label>
                                <input type="text" id="azienda" class="form-control" placeholder="Azienda" readonly>
                                <button class="btn btn-primary" id="selAzienda" onclick="openModalSelezionaAzienda()">Seleziona</button>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mr-auto" id="btn_cancella"
                            onclick="deleteProgetto()">Cancella</button>
                        <button type="button" class="btn btn-success" id="btn_modifica"
                            onclick="modificaProgetto()">Aggiorna</button>
                        <button type="button" class="btn btn-primary" id="btn_aggiungi"
                            onclick="creaProgetto()">Aggiungi</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
        </div>