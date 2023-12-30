<?php
// Função para encontrar e substituir a palavra nos nomes dos arquivos
function findAndReplaceInFiles($directory, $oldWord, $newWord, &$totalChanged) {
    $changes = ''; // Variável para armazenar as alterações

    $files = scandir($directory);

    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $filePath = $directory . '/' . $file;

            if (is_dir($filePath)) {
                $changes .= findAndReplaceInFiles($filePath, $oldWord, $newWord, $totalChanged); // Adiciona as alterações recursivamente
            } else {
                $oldFileName = $file;
                $newFileName = str_replace($oldWord, $newWord, $file);

                if ($oldFileName !== $newFileName) {
                    rename($filePath, $directory . '/' . $newFileName);
                    $changes .= "<span class='changed'>Nome do arquivo alterado: $oldFileName -> $newFileName</span><br>";
                    $totalChanged++;
                }
            }
        }
    }

    return $changes; // Retorna as alterações encontradas
}

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $directory = $_POST['directory']; // Diretório a ser percorrido
    $oldWord = $_POST['old_word']; // Palavra a ser substituída
    $newWord = $_POST['new_word']; // Nova palavra
    $totalChanged = 0; // Inicializa o contador de alterações

    // Executa a função para encontrar e substituir a palavra nos nomes dos arquivos
    $changes = findAndReplaceInFiles($directory, $oldWord, $newWord, $totalChanged);
    $totalChangedMessage = "<span class='total-changed'>Total de arquivos alterados: $totalChanged</span><br>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Encontrar e Substituir Palavra nos Nomes de Arquivos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="submit"],
        input[type="button"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .result-panel {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: 14px;
            max-height: 200px;
            overflow-y: auto;
        }

        .changed {
            color: green;
            font-weight: bold;
        }

        .total-changed {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .clear-btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 3px;
            cursor: pointer;
            display: block;
            margin-top: 20px;
            margin-left: auto;
        }

        .clear-btn:hover {
            background-color: #bd2130;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Encontrar e Substituir Palavra nos Nomes de Arquivos</h1>
        <form method="post" action="">
            <label for="directory">Diretório:</label>
            <input type="text" name="directory" id="directory" placeholder="Caminho da pasta" required><br><br>
            
            <label for="old_word">Palavra a ser substituída:</label>
            <input type="text" name="old_word" id="old_word" placeholder="Palavra a ser substituída" required><br><br>
            
            <label for="new_word">Nova palavra:</label>
            <input type="text" name="new_word" id="new_word" placeholder="Nova palavra" required><br><br>
            
            <input type="submit" value="Substituir">
        </form>

        <div class="result-panel">
            <?php
            if (isset($changes)) {
                echo $totalChangedMessage . $changes;
            }
            ?>
        </div>

        <button class="clear-btn" onclick="clearPanel()">Limpar Tela</button>
    </div>

    <script>
        function clearPanel() {
            document.querySelector('.result-panel').innerHTML = '';
        }
    </script>
</body>
</html>


