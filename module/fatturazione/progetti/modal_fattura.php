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
                        <form method="post" action="/module/fatturazione/download_fattura.php">
                            <input class="hidden" name="id_progetto" id="id_progetto"></input>
                            <input class="hidden" name="tipo_fatt" id="tipo_fatt"></input>
                            <div id="scelta_fatt">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ore" id="ore">
                                    <label class="form-check-label" for="ore">
                                        Fattura sulle ore totali dedicate (Attenzione: le ore vengono conteggite automaticamente dai task del progetto)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="budget" id="budget">
                                    <label class="form-check-label" for="budget">
                                        Fattura sul budget usato
                                    </label>
                                </div>

                            </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-success">Scarica fattura</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>