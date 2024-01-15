<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>login</title>
</head>

<body>
    <section>
        <div class="login-box">


            <form autocomplete="off" action="" method="POST">
                <h2>Login</h2>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>


                <button type="submit">Login</button>

                <div class="register-link">
                    <p>Don't have an account?<a href="./register.php"> Register</a></p>
                </div>
                <h3><a href="../">My Passwords</a></h3>

            </form>

        </div>
    </section>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>

<?php
include("../controller/database/db_connection.php");
include("../controller/actions.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $actions = new Actions;
    $username = $_POST["username"];
    $password = $_POST["password"];

    $data = [
        'username' => $username,
        'master_password' => $password,
    ];

    $actions -> login($data, $conn);

}











// if ($_SERVER["REQUEST_METHOD"] == "POST") {

//     $username = $_POST["username"];
//     $password = $_POST["password"];

//     // Use instruções preparadas para evitar injeção de SQL
//     $sql = "SELECT * FROM users WHERE username = ?";
//     $stmt = $conn->prepare($sql);

//     // Verifique se a preparação da instrução foi bem-sucedida
//     if ($stmt) {
//         // Faça o bind dos parâmetros e execute a consulta
//         $stmt->bind_param("s", $username);
//         $stmt->execute();

//         // Obtenha o resultado
//         $result = $stmt->get_result();

//         // Verifique se a execução foi bem-sucedida
//         if ($result) {
//             // Verifique se encontrou exatamente um usuário
//             if ($result->num_rows == 1) {
//                 $row = $result->fetch_assoc();

//                 if(password_verify($password, $row["master_password"])){

//                 $_SESSION["user_id"] = $row["user_id"];
//                 header("Location: homepage.php");
//                 exit();

//                 }
//             } else {
//                 echo "<script>alert('Usuário ou senha incorretos!')</script>";
//             }
//         } else {
//             echo "Erro na execução da consulta: " . $stmt->error;
//         }

//         // Feche o resultado
//         $result->close();

//         // Feche a instrução preparada
//         $stmt->close();
//     } else {
//         // Se a preparação da instrução falhar
//         echo "Erro na preparação da instrução: " . $conn->error;
//     }

//     // Feche a conexão
//     $conn->close();
// }
?>