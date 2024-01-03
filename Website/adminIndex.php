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
            <th>Name</th>
            <th>Username</th>
            <th>Load Name</th>
            <th>Actions</th>
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

    <div class="logout-btn">
        <form method="post" action="logout.php">
            <button type="submit">Logout</button>
        </form>
    </div>

</div>

</body>
</html>

<?php
$conn->close();
?>