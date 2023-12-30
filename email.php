<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário de Contato</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    .container {
      width: 80%;
      max-width: 600px;
      margin: 50px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
    }

    .input-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="email"],
    textarea {
      width: 100%;
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    button {
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Entre em Contato</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $mensagem = $_POST['mensagem'];

        $to = 'seu_email@example.com'; // Insira o seu endereço de e-mail aqui

        $subject = 'Novo contato pelo formulário';
        $message = "Nome: $nome\n";
        $message .= "Email: $email\n";
        $message .= "Mensagem:\n$mensagem";

        $headers = "From: $email";

        // Configuração do servidor SMTP
        $smtpServer = 'smtp.gmail.com';
        $smtpUser = 'jetad062@gmail.com';
        $smtpPass = '040507Meuc@belo';
        $smtpPort = 587; // Porta SMTP (pode variar conforme o provedor)

        // Envio de e-mail via SMTP
        $transport = (new Swift_SmtpTransport($smtpServer, $smtpPort))
            ->setUsername($smtpUser)
            ->setPassword($smtpPass);

        $mailer = new Swift_Mailer($transport);

        $messageObj = (new Swift_Message($subject))
            ->setFrom([$email])
            ->setTo([$to])
            ->setBody($message);

        if ($mailer->send($messageObj)) {
            echo "<p>Sua mensagem foi enviada com sucesso!</p>";
        } else {
            echo "<p>Ocorreu um erro ao enviar sua mensagem.</p>";
        }
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="input-group">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
      </div>
      <div class="input-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="input-group">
        <label for="mensagem">Mensagem:</label>
        <textarea id="mensagem" name="mensagem" required></textarea>
      </div>
      <div class="input-group">
        <button type="submit">Enviar</button>
      </div>
    </form>
  </div>
</body>
</html>
