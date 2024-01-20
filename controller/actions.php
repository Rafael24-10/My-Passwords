<?php


class Actions
{
    //checks if the user is authenticated and returns their id
    public static function isAuth()
    {
        session_start();
        if (!isset($_SESSION["user_id"])) {
            header("LOCATION: index.php");
        }

        return $_SESSION["user_id"];
    }




    public function Register($data, $conn)
    {
        $username = $data["username"];
        $email = $data["email"];
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('Username or email already exists!')</script>";
            echo '<script>
            setTimeout(function() {
                window.location.href = "/meuphp/password_manager/view/index.php";
            }, 1000);
          </script>';
            exit();
        }

        $stmt1 = $conn->prepare("INSERT INTO users (username, master_password, email) VALUES (?, ?, ?)");
        $stmt1->bind_param("sss", $data["username"], $data["master_password"], $data["email"]);

        if ($stmt1->execute()) {

            echo "<script>alert('Your new account has been created!')</script>";
            echo '<script>
            setTimeout(function() {
                window.location.href = "/meuphp/password_manager/view/index.php";
            }, 1000);
          </script>';
            exit();
        } else {
            echo "<script>alert('Something went wrong creating your new account" . $stmt->error . "')</script>";
        }

        $stmt->close();
        $stmt1->close();
    }




    public function login($data, $conn)
    {

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $data["username"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();

                if (password_verify($data["master_password"], $row["master_password"])) {

                    $_SESSION["user_id"] = $row["user_id"];
                    header("Location: passwords.php");
                    exit();
                }
            } else {
                echo "<script>alert('Username or password not correct!')</script>";
                echo '<script>
                setTimeout(function() {
                    window.location.href = "/meuphp/password_manager/view/index.php";
                }, 1000);
              </script>';
                exit();
            }
        } else {
            echo "Erro na execução da consulta: " . $stmt->error;
        }

        $stmt->close();
        $result->close();
        $conn->close();
    }




    //pulls data from db
    public function show($id, $conn)
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return null;
        }
    }



    public function showPass($id, $conn)
    {
        $sql = "SELECT * FROM passwords WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $passwords = array();

        while ($row = $result->fetch_assoc()) {
            $passwords[] = $row;
        }

        if (!empty($passwords)) {
            return $passwords;
        } else {
            return null;
        }
    }




    public function selectPass($name, $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM passwords WHERE password_name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }




    //edits data from db
    public function update($id, $newdata, $conn)
    {

        $update_string = "";

        foreach ($newdata as $key => $value) {
            // Certifique-se de que os valores estão devidamente escapados
            $escapedValue = mysqli_real_escape_string($conn, $value);

            // Adicione aspas ao redor dos valores de string
            if (is_string($value)) {
                $escapedValue = "'$escapedValue'";
            }

            $update_string .= "$key = $escapedValue, ";
        }

        // Remova a vírgula extra no final da string
        $update_string = rtrim($update_string, ', ');

        $sql = "UPDATE users SET $update_string WHERE user_id = $id";

        if ($conn->query($sql)) {
            echo "<script>alert('User data updated')</script>";
            echo '<script>
            setTimeout(function() {
                window.location.href = "/meuphp/password_manager/view/passwords.php";
            }, 1000);
          </script>';
            exit();
        } else {
            echo "error " . $conn->error;
        }
    }


    public function destroy($id, $conn)
    {
        $this->isAuth();
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->execute()) {
            session_destroy();
            header("LOCATION: ../index.html");
        } else {
            echo "error" . $conn->error;
        }
    }

   
}
