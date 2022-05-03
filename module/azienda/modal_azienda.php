        <!-- Modal -->
        <div class="modal fade" id="modal_azienda" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="titolo_modal_azienda" class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                        <!-- body -->
                        <span class="hidden" id="id_azienda"></span>
                        <div class="row">
                            <div class="col">
                                <input type="text" id="nome" class="form-control" id="nome" placeholder="Nome">
                            </div>
                            <div class="col">
                                <input type="text" id="telefono" class="form-control" placeholder="Telefono">
                            </div>
                            <div class="col">
                                <input type="text" id="sito" class="form-control" placeholder="Sito Web">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                        <div class="col">
                                <input type="text" id="indirizzo" class="form-control" placeholder="Indirizzo">
                            </div>
                            <div class="col">
                                <input type="text" id="citta" class="form-control" placeholder="Città">
                            </div>
                            <div class="col">
                                <input type="text" id="cap" class="form-control" placeholder="Cap">
                            </div>
                            <div class="col">
                                <input type="text" id="provincia" class="form-control" placeholder="Provincia">
                            </div>
                            <div class="col">
                                <input type="text" id="nazione" class="form-control" placeholder="Nazione">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mr-auto" id="btn_cancella"
                            onclick="deleteAzienda()">Cancella</button>
                        <button type="button" class="btn btn-success" id="btn_modifica"
                            onclick="modificaAzienda()">Aggiorna</button>
                        <button type="button" class="btn btn-primary" id="btn_aggiungi"
                            onclick="creaAzienda()">Aggiungi</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
        </div>