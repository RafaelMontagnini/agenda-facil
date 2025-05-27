<style>
.modal {
    z-index: 10002; /* DEFINIDO ESSE VALOR PARA SOBREPOR O BATÃO DO MENU */
}
</style>

<div class="modal fade" id="modalExcluirAgendamento" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content rounded-3 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Confirmar Exclusão</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p>Tem certeza que deseja excluir este agendamento?</p>
        <input type="hidden" id="delete-id">
      </div>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-danger" onclick="confirmarExclusao()">Excluir</button>
      </div>
    </div>
  </div>
</div>