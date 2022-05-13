        <!-- Modal -->
        <div class="modal fade" id="modal_utente" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="titolo_modal_utente" class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                        <!-- body -->
                        <span class="hidden" id="id_azienda_assegna"></span>

                        <?php echo getListUtenti("listaUtenti"); ?>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn_assegna" onclick="assegnaUtente()">Assegna</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
        </div>