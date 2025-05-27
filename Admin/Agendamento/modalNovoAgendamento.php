<style>
.modal {
    z-index: 10002; /* DEFINIDO ESSE VALOR PARA SOBREPOR O BATÃO DO MENU */
}
</style>

<div class="modal fade" id="modalNovoAgendamento" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content rounded-3 shadow">
      <div style="background-color: #10303d;" class="modal-header  text-white">
        <h5 class="modal-title">Novo Agendamento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="modelAgendamento.php">
        <div class="modal-body">
          <select class="form-control mb-3" name="paciente_id" required>
            <option value="">Selecione um paciente</option>
            <?php
              $id_medico = $_SESSION['id'];
              $query = "SELECT id, nome FROM pacientes WHERE medico_id = :medico_id ORDER BY nome";
              $stmt = $conn->prepare($query);
              $stmt->bindParam(':medico_id', $id_medico);
              $stmt->execute();

              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  echo "<option value='{$row['id']}'>{$row['nome']}</option>";
              }
            ?>
          </select>
          <input type="date" class="form-control mb-3" name="data_agendamento" required>
          <input type="time" class="form-control mb-3" name="hora_agendamento" required>
          <div class="form-floating mb-3">
              <textarea class="form-control" name="observacao" style="height: 100px" placeholder="Observação"></textarea>
              <label>Observação</label>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" name="novo_agendamento" class="btn btn-primary">Salvar</button>
        </div>
      </form>

    </div>
  </div>
</div>