        <!-- Modal -->
        
        <div class="modal fade" id="modal_task" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="titolo_modal_task" class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                        <!-- body -->
                        <span class="hidden" id="id_progetto"></span>
                        <h3>Dettagli Task</h3>
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
                                <label for="data_fine">Data fine</label>
                                <input type="text" class="form-control" id="data_fine">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4"><br>
                                <label for="ore">Ore dedicate</label>
                                <input type="text" id="ore" class="form-control" placeholder="Ore">
                            </div>
                            <div class="col-4"><br>
                                <label for="progresso">Progresso (%)</label>
                                <input type="text" id="progresso" class="form-control" placeholder="Progresso">
                            </div>
                            <div class="col-4"><br>
                                <label for="progetto">Progetto</label>
                                <input type="text" id="progetto" class="form-control" placeholder="Azienda" readonly>
                                <button class="btn btn-primary" onclick="openModalSelezionaProgetto()">Seleziona</button>
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
                            onclick="deleteTask()">Cancella</button>
                        <button type="button" class="btn btn-success" id="btn_modifica"
                            onclick="modificaTask()">Aggiorna</button>
                        <button type="button" class="btn btn-primary" id="btn_aggiungi"
                            onclick="creaTask()">Aggiungi</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
        </div>