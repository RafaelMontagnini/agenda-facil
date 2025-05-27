<style>
.modal {
    z-index: 10002; /* DEFINIDO ESSE VALOR PARA SOBREPOR O BATÃO DO MENU */
}
</style>

<div class="modal fade" id="modalEditarAgendamento" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content rounded-3 shadow">
      <div style="background-color: #10303d;" class="modal-header text-dark">
        <h5 style="color: white;" class="modal-title">Editar Agendamento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="modelAgendamento.php">
        <div class="modal-body">
          <input type="hidden" name="edit_id" id="edit-id">
          <input type="text" class="form-control mb-3" name="edit_nome" id="edit-nome" placeholder="Nome do Paciente" readonly>
          <input type="date" class="form-control mb-3" name="edit_data" id="edit-data">
          <input type="time" class="form-control mb-3" name="edit_hora" id="edit-horario">
          <input type="text" class="form-control mb-3" name="edit_telefone" id="edit-telefone" readonly>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" name="salvar_edicao" class="btn btn-primary text-white">Salvar Alterações</button>
        </div>
      </form>
    </div>
  </div>
</div>
