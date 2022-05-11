        <!-- Modal -->
        <div class="modal fade" id="modal_fattura" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="titolo_modal_fattura" class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                        <!-- body -->
                        <span class="hidden" id="id_progetto"></span>
                        <div id="scelta_fatt">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="ore" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Fattura sulle ore totali dedicate (Attenzione: le ore vengono conteggite automaticamente dai task del progetto)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="budget">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Fattura sul budget usato
                                </label>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="stampaFatturaProgetto()">Scarica fattura</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
        </div>