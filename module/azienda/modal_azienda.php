        <!-- Modal -->
        <div class="modal fade" id="modal_azienda" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="titolo_modal_log" class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                        <!-- body -->
                        <span class="hidden" id="id_azienda"></span>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" id="nome" placeholder="Nome">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Last name">
                            </div>
                        </div>
                        <div class='form-group col-sm'>
                            <span class="badge bg-primary p-1">Telefono</span>
                            <input class='form-control' type="text" id="num_telefono">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mr-auto" id="btn_cancella"
                            onclick="deleteAzienda()">Cancella</button>
                        <button type="button" class="btn btn-success" id="btn_modifica"
                            onclick="modificaAzienda()">Aggiorna</button>
                        <button type="button" class="btn btn-primary" id="btn_aggiungi"
                            onclick="addAzienda()">Aggiungi</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
        </div>