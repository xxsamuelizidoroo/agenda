<!-- Passo 3.2 - Começe a programar construindo o process.php  -->

<!-- Passo 3.2 - Comece a programar construindo o process.php -->

<?php

// Inicia a sessão 
session_start();

// Inclui arquivos de conexão ao banco e funcionalidades 
include_once("connection.php");
include_once("url.php");

// Recebe dados do formulário via Post
$data = $_POST;

// NOTIFICAÇÕES NO BANCO (CRUD - CREATE, READ, UPDATE, DELETE)
if (!empty($data)) {

    // Criar contato (CREATE)
    if ($data["type"] == "create") {

        $name = $data["name"];
        $phone = $data["phone"];
        $observations = $data["observations"];

        // Query de inserção com placeholders 
        $query = "INSERT INTO contacts (name, phone, observations) VALUES (:name, :phone, :observations";

        // Prepara a query 
        $stmt = $conn->prepare($query);

        // Substitui placeholders
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":observations", $observations);

        try {
            // Executa a query
            $stmt->execute();

            // Mensagem de sucesso 
            $_SESSION["msg"] = "Contato criado com sucesso";

        } catch (PDOException $e) {
            // Captura erros
            $error = $e->getMessage();
            echo "Erro: $error";
        }
    }

    // Código para atualizar (UPDATE)
    else if ($data["type"] === "edit") {

        $name = $data["name"];
        $phone = $data["phone"];
        $observations = $data["observations"];
        $id = $data["id"];

        // Query de atualização 
        $query = "UPDATE contacts SET name = :name, phone = :phone, observations = :observations WHERE id = :id";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":observations", $observations);
        $stmt->bindParam(":id", $id);

        try {

            $stmt->execute();
            $_SESSION["msg"] = "Contato atualizado com sucesso!";

        } catch (PDOException $e) {
            // erro na conexão 
            $error = $e->getMessage();
            echo "Erro: $error";
        }
    }

    // Código para deletar (DELETE)
    else if ($data["type"] == "delete") {

        $id = $data["id"];

        // Query de remoção 
        $query = "DELETE FROM contacts WHERE id = :id";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":id", $id);

        try {

            $stmt->execute();
            $_SESSION["msg"] = "Contato removido com sucesso!";

        } catch (PDOException $e) {
            // erro na conexão 
            $error = $e->getMessage();
            echo "Erro: $error";
        }

        // Redireciona para a página inicial (HOME)
        header("location: " . $BASE_URL . "../index.php");
    }
} else {

    $id;

    // Código para selecionar um contato 
    if (empty($_GET)) {
        $id = $_GET["id"];
    }

    // Retorna o dado de um contato 
    if (!empty($id)) {

        // Query de seleção 
        $query = "SELECT * FROM contacts WHERE id = :id";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $contact = $stmt->fetch();
    } else {

        // Retorna todos os contatos 
        $contacts = [];

        // Query de seleção de todos os contatos 
        $query = "SELECT * FROM contacts";

        $stmt = $conn->prepare($query);

        $stmt->execute();

        $contacts = $stmt->fetchAll();
    }
}

// FECHAR CONEXÃO 
$conn = null;
