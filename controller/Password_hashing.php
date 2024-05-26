<?php

class Hashing
{

    //Hashes a given string using bcrypt

    public function bcrypt($password)
    {
        $options = [
            'cost' => 12
        ];

        $hashed = password_hash($password, PASSWORD_DEFAULT, $options);
        return $hashed;
    }


    //Encrypts a string with a given key

    public function encrypting($password, $key)
    {
        $iv = random_bytes(16);
        $encrypted = openssl_encrypt($password, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        $encryptedWithIv = base64_encode($iv . $encrypted);

        return $encryptedWithIv;
    }


    //Decrypts a string with its key

    public function decrypting($encrypted, $key)
    {
        $password = base64_decode($encrypted);
        $iv = substr($password, 0, 16);
        $encryptedPassword = substr($password, 16);
        return openssl_decrypt($encryptedPassword, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    }


    //Deletes a password

    public function passDestroy($name, $conn)
    {

        $sql = $conn->prepare("DELETE  FROM passwords WHERE password_name = ?");
        $sql->bind_param("s", $name);

        if ($sql->execute()) {
            echo "<script>alert('Password deleted!'); window.location.href = '../view/passwords.php';</script>";
            exit();
        } else {
            echo "error: " . $conn->error;
        }
    }


    //Edits a password

    public function passUpdate($name, $conn, $newdata)
    {

        $update_string = "";

        foreach ($newdata as $key => $value) {
            // Escaping values
            $escapedValue = mysqli_real_escape_string($conn, $value);

            // Add quotes around string values
            if (is_string($value)) {
                $escapedValue = "'$escapedValue'";
            }

            $update_string .= "$key = $escapedValue, ";
        }

        // Remove the extra comma at the end of the string
        $update_string = rtrim($update_string, ', ');

        $sql = "UPDATE passwords SET $update_string WHERE password_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $name);

        if ($stmt->execute()) {
            header("Location: ../view/passwords.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }




    public function passInsert($passwordName, $password, $id, $conn)
    {
        $stmt1 = $conn->prepare("SELECT * FROM passwords WHERE password_name = ? AND user_id = ?");
        $stmt1->bind_param("si", $passwordName, $id);
        $stmt1->execute();
        $stmt1->store_result();

        // Checks if a user or email already exists
        if ($stmt1->num_rows > 0) {
            echo "<script>alert('Você já tem uma senha com o mesmo nome!')</script>";
            echo '<script>
            setTimeout(function() {
                window.location.href = "/meuphp/password_manager/view/passwords.php";
            }, 1000);
          </script>';
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO passwords (user_id, password_name, password_value) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id, $passwordName, $password);

        if ($stmt->execute()) {
            //Avoid resubmitting the form when refreshing the page
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo $conn->error;
        }

        $stmt1->close();
        $stmt->close();
    }
}
