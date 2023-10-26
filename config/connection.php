<!-- Passo 3.1 - Começe a programar construindo o connection.php  -->
<?php

// Define as credenciais de conexão ao banco
$host = "localhost"; 
$doname = "agenda2";
$user = "root";
$pass = "";

try {

    // Cria uma nova conexão PDO (PHP Data Objects. É uma extensão do PHP que fornece uma interface para acessar diferentes sistemas de banco de dados.)
    $conn = new PDO("mysql:host=$host;doname=$dbnae", $user, $pass); 

    // Ativa o modo de erros para lançar excepções 
    $conn-> setAttribute(PDO:: ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOExcepetion $e) {

    // Captura erros na conexão e exibe a mensagem
    $error = $e->getMessage();
    echo "Erro: $error";

}






}
?>