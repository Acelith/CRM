<!-- The Modal -->
<div class="modal fade" id="select_aziende">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Seleziona azienda</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <?php echo getAziendeSelect();?>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-success mr-auto" id="btn_sel_azienda"
                            onclick="selezioneAzienda()">Seleziona azienda</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
        </div>
        
      </div>
    </div>
  </div>
  
</div>