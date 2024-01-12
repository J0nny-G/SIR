<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está autenticado
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

// Conectar ao banco de dados (substitua com suas próprias credenciais)
$conn = new mysqli("localhost", "root", "", "movitime");

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtém todos os nomes de idLoads
$sqlLoads = "SELECT idLoads, name FROM loads";
$resultLoads = $conn->query($sqlLoads);

$loads = array();
while ($row = $resultLoads->fetch_assoc()) {
    $loads[] = $row;
}

// Função para escapar caracteres especiais e evitar SQL injection
function sanitize($conn, $value)
{
    return $conn->real_escape_string($value);
}

// Função para obter todos os usuários com os nomes correspondentes a idLoads
function getAllUsersWithLoadNames($conn)
{
    $sql = "SELECT u.idUser, u.username, u.nameUser, l.name FROM users u JOIN loads l ON u.idLoads = l.idLoads";
    $result = $conn->query($sql);

    $users = array();
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    return $users;
}

function getEvents($conn)
{
    $sql = "SELECT id,title,start_date,description FROM events";
    $result = $conn->query($sql);

    $event = array();
    while ($row = $result->fetch_assoc()) {
        $event[] = $row;
    }

    return $event;
}

// Função para atualizar informações do usuário
function updateUser($conn, $id, $name, $username)
{
    $sql = "UPDATE users SET nameUser = ?, username = ? WHERE idUser = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $username, $id);
    $stmt->execute();
    $stmt->close();
}

// Função para atualizar o valor de idLoads do usuário
function updateIdLoads($conn, $id, $idLoads)
{
    $sql = "UPDATE users SET idLoads = ? WHERE idUser = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idLoads, $id);
    $stmt->execute();
    $stmt->close();
}

// Função para excluir um usuário
function deleteUser($conn, $id)
{
    $sql = "DELETE FROM users WHERE idUser = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Verificação do formulário de atualização
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['edit'])) {
        $id = sanitize($conn, $_POST['edit_id']);
        $name = sanitize($conn, $_POST['edit_name']);
        $username = sanitize($conn, $_POST['edit_username']);
        updateUser($conn, $id, $name, $username);
    } elseif (isset($_POST['update_idloads'])) {
        $id = sanitize($conn, $_POST['idloads_id']);
        $idLoads = sanitize($conn, $_POST['new_idloads']);
        updateIdLoads($conn, $id, $idLoads);
    } elseif (isset($_POST['delete'])) {
        $id = sanitize($conn, $_POST['delete_id']);
        deleteUser($conn, $id);
    }
}

$users = getAllUsersWithLoadNames($conn);
$events = getEvents($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="container">

    <h2>Admin Panel</h2>

    <table>
        <tr>
            <th>Nome</th>
            <th>Username</th>
            <th>Função</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['nameUser']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="idloads_id" value="<?php echo $user['idUser']; ?>">
                        <select name="new_idloads">
                            <?php foreach ($loads as $load): ?>
                                <option value="<?php echo $load['idLoads']; ?>"><?php echo $load['name']; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit" name="update_idloads">Update Loads</button>
                    </form>
                    <form method="post" action="">
                        <input type="hidden" name="delete_id" value="<?php echo $user['idUser']; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="estreias">
        <div class="header">
            <h2>Proximas Estreias</h2>
            <button onclick="mostrarFormulario()" class="novo">Novo Lançamento</button>
        </div>
        <div class="novoFilme">
            <form id="formEdicao" style="display: none;" action="events.php" method="post">
                <label for="novoNome">Nome Filme/Série:</label>
                <input type="text" id="novoNome" name="novoNome" required>

                <label for="dataLancamento">Data de Estreia:</label>
                <input type="date" id="dataLancamento" name="dataLancamento"  required>

                <label for="descricao">Breve descrição:</label>
                <input type="text" id="descricao" name="descricao" required>

                <button type="submit">Criar nova Estreia</button>
            </form>
        </div>
        <table>
            <tr>
                <th>Titulo do Filme/Série</th>
                <th>Data de Estreia</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?php echo $event['title']; ?></td>
                    <td><?php echo $event['start_date']; ?></td>
                    <td><?php echo $event['description']; ?></td>
                    <td>
                        <button onclick="abrirJanela(
                            '<?php echo $event['title']; ?>',
                            '<?php echo $event['start_date']; ?>',
                            '<?php echo $event['description']; ?>',
                            <?php echo $event['id']; ?>
                        )">Editar</button>
                        <form action="deleteEstreia.php" method="post" >
                            <input type="hidden" name="delete_event_id" value="<?php echo $event['id']; ?>">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="logout-btn">
        <form method="post" action="logout.php">
            <button type="submit">Logout</button>
        </form>
    </div>

    <div id="meuPopup">
        <h3>Editar Evento</h3>
        <form id="editForm" method="post" action="editarEstreia.php">
            <input type="hidden" id="editId" name="editId" value="">
            <label for="editTitulo">Título:</label>
            <input type="text" id="editTitulo" name="editTitulo" required>

            <label for="editData">Data de Estreia:</label>
            <input type="date" id="editData" name="editData" required>

            <label for="editDescricao">Breve descrição:</label>
            <input type="text" id="editDescricao" name="editDescricao" required>

            <button type="submit">Salvar Edição</button>
            <button type="button" onclick="fecharPopup()">Fechar</button>
        </form>
    </div>

</div>

<script>
    function mostrarFormulario() {
        document.getElementById("formEdicao").style.display = "block";
    }

    function abrirJanela(titulo, data, descricao, id) {
        // Preencher os campos do popup com os dados do evento selecionado
        document.getElementById('editId').value = id;
        document.getElementById('editTitulo').value = titulo;
        document.getElementById('editData').value = data;
        document.getElementById('editDescricao').value = descricao;

        // Exibir o popup
        document.getElementById('meuPopup').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }

    function fecharPopup() {
        document.getElementById('meuPopup').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
</script>

</body>
</html>

<?php
$conn->close();
?>