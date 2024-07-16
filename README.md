# My Passwords

## Overview

"My Passwords" is a secure password manager that allows users to store and manage their passwords in a safe and encrypted environment. After creating an account, users can benefit from the following features:

- **Password Storage:** Store and organize your passwords securely.
- **Symmetric Encryption:** Passwords are encrypted using PHP's `openssl_encrypt` function with symmetrical encryption. This ensures that a single key is used for both encryption and decryption processes.
- **Key Generation:** The user's password is utilized as the key for symmetrical encryption.
- **Password Hashing:** Before storing in the database, the user's password is hashed using PHP's bcrypt algorithm for an additional layer of security.

## How it Works

1. **Account Creation:** Users create an account with a unique username, password, and email.
2. **Password Storage:** After logging in, users can add, edit, or delete passwords.
3. **Symmetric Encryption:** Passwords are encrypted using the user's password as the key.
4. **Hashing for Security:** The user's password is securely hashed before being stored in the database.
5. **Secure Access:** The system ensures secure access to stored passwords, requiring user authentication.

## Technologies Used

- PHP: Backend scripting language.
- OpenSSL: Used for symmetrical encryption.
- Bcrypt: Applied for secure password hashing.

## Getting Started

To run the project locally, follow these steps:

1. Clone the repository: `git clone https://github.com/your-username/my-passwords.git`.
2. You need to have composer intalled. It can be downloaded [here](https://getcomposer.org/download/)
3. Open the project in the terminal and run ``` composer install ```.
4. Jump into the Db.php file and set the credentials to your sql database.
5. A server is required to run the project such as APACHE or nginx.
6. Move the project inside your web server directory, '/var/www/html' in APACHE for example.
7. Once the project is in the correct place, start the server and access the project in your localhost. 






## Contribution

If you would like to contribute to the project, feel free to open an issue or submit a pull request. Keep in mind that I am a beginner still learning some of the basics.

## License

This project is licensed under the [MIT License](LICENSE) - see the [LICENSE](LICENSE) file for details.

