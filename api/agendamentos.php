<?php
header('Content-Type: application/json');

// Token fixo
$token = 'rafael123'; 

$headers = getallheaders();
$tokenRecebido = isset($headers['Authorization']) ? trim($headers['Authorization']) : '';

if ($tokenRecebido !== $token) {
    http_response_code(401);
    echo json_encode(['erro' => 'Token inválido ou ausente']);
    exit;
}

try {
    $conn = new PDO('mysql:host=localhost;dbname=agenda_facil', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
