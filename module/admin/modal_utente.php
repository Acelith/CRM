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
                        <span class="hidden" id="id_utente"></span>

                        <div class="row">
                            <div class="col">
                                <label for="nome">Nome</label>
                                <input type="text" id="nome" class="form-control" id="nome" placeholder="Nome">
                            </div>
                            <div class="col">
                                <label for="cognome">Cognome</label>
                                <input type="text" id="cognome" class="form-control" placeholder="Cognome">
                            </div>
                            <div class="col">
                                <label for="email">Email</label>
                                <input type="text" id="email" class="form-control" placeholder="E-mail">
                            </div>
                            <div class="col">
                                <label for="admin">Admin</label>
                                <input type="checkbox" id="admin" class="form-control">
                            </div>
                        </div>
                        <br>
                        <hr>
                        <h6>Cambia password</h6>
                        <div class="row">

                            <div class="col">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control" placeholder="password">
                            </div>
                            <div class="col">
                                <label for="confPassword">Conferma password</label>
                                <input type="password" id="confPassword" class="form-control" placeholder="Conferma password">
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <label for="dt_last_login">Ultimo Login</label>
                                <input type="text" id="dt_last_login" class="form-control" placeholder="Ultimo login" readonly>
                            </div>
                            <div class="col">
                                <label for="dt_creazione">Data di creazione utente</label>
                                <input type="text" id="dt_creazione" class="form-control" placeholder="Data di creazione" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mr-auto" id="btn_cancella" onclick="deleteUtente()">Cancella</button>
                        <button type="button" class="btn btn-success" id="btn_modifica" onclick="modificaUtente()">Aggiorna</button>
                        <button type="button" class="btn btn-primary" id="btn_aggiungi" onclick="creaUtente()">Aggiungi</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
        </div>