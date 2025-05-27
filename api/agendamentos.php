<?php
header('Content-Type: application/json');

$headers = getallheaders();
$tokenRecebido = isset($headers['Authorization']) ? trim($headers['Authorization']) : '';

try {
    $conn = new PDO('mysql:host=localhost;dbname=agenda_facil', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o token existe no banco
    $stmtToken = $conn->prepare("SELECT COUNT(*) FROM api_tokens WHERE token = :token");
    $stmtToken->bindParam(':token', $tokenRecebido);
    $stmtToken->execute();

    if ($stmtToken->fetchColumn() == 0) {
        http_response_code(401);
        echo json_encode(['erro' => 'Token inválido ou ausente']);
        exit;
    }

    // Se token ok, roda a query dos pacientes
    $query = "
        SELECT
            T1.id, 
            T1.nome,
            T1.cpf,
            T1.celular,
            T1.email,
            T1.data_nascimento,
            T1.sexo,
            T1.medico_id,
            T2.nome AS nome_medico
        FROM 
            pacientes T1
        INNER JOIN 
            medicos T2 ON T2.id = T1.medico_id
        ORDER BY 
            T1.id DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($dados);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro no servidor: ' . $e->getMessage()]);
}
