<?php
session_start();

$palavras = [
    'PROGRAMACAO',
    'COMPUTADOR',
    'JAVASCRIPT',
    'DESENVOLVEDOR',
    'BANCO',
    'SISTEMA',
    'INTERNET',
    'TECLADO',
    'PYTHON',
    'DATABASE',
    'ALGORITMO',
    'FRAMEWORK',
    'SERVIDOR',
    'CLIENTE',
    'APLICACAO',
    'SOFTWARE',
    'HARDWARE',
    'MEMORIA',
    'PROCESSADOR',
    'MONITOR',
    'MOUSE',
    'MONITOR',
    'ARQUIVO',
    'PASTA',
    'DOCUMENTO',
    'SEGURANCA',
    'CRIPTOGRAFIA',
    'BROWSER',
    'NAVEGADOR',
    'CONEXAO',
    'LOCALHOST',
    'DOMINIO',
    'HOSPEDAGEM',
    'BACKUP',
    'SINCRONIZACAO',
    'AUTENTICACAO',
    'AUTORIZACAO',
    'VALIDACAO',
    'COMPILACAO',
    'DEPURACAO',
    'OTIMIZACAO'
];

function iniciarJogo($palavras) {
    $_SESSION['palavra'] = $palavras[array_rand($palavras)];
    $_SESSION['letras'] = [];
    $_SESSION['erros'] = 0;
    $_SESSION['maxErros'] = 6;
}

if (!isset($_SESSION['palavra']) || isset($_POST['reiniciar'])) {
    iniciarJogo($palavras);
}

if (isset($_POST['letra'])) {
    $letra = strtoupper(trim($_POST['letra']));

    if (strlen($letra) === 1 && ctype_alpha($letra) && !in_array($letra, $_SESSION['letras'])) {
        $_SESSION['letras'][] = $letra;

        if (strpos($_SESSION['palavra'], $letra) === false) {
            $_SESSION['erros']++;
        }
    }
}

$palavra = $_SESSION['palavra'];
$letras = $_SESSION['letras'];
$erros = $_SESSION['erros'];
$maxErros = $_SESSION['maxErros'];

$palavraExibida = '';
$venceu = true;

for ($i = 0; $i < strlen($palavra); $i++) {
    if (in_array($palavra[$i], $letras)) {
        $palavraExibida .= $palavra[$i] . ' ';
    } else {
        $palavraExibida .= '_ ';
        $venceu = false;
    }
}

$perdeu = $erros >= $maxErros;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogo da Forca - PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container">
        <h1>Jogo da Forca</h1>
        <p class="subtitulo">Projeto simples feito em PHP com sessão.</p>

        <section class="card">
            <div class="forca">
                <pre>
  +---+
  |   |
  <?= $erros > 0 ? 'O' : ' ' ?>   |
 <?= $erros > 2 ? '/' : ' ' ?><?= $erros > 1 ? '|' : ' ' ?><?= $erros > 3 ? '\\' : ' ' ?>  |
 <?= $erros > 4 ? '/' : ' ' ?> <?= $erros > 5 ? '\\' : ' ' ?>  |
      |
=========
                </pre>
            </div>

            <h2><?= trim($palavraExibida) ?></h2>
            <p>Erros: <?= $erros ?> de <?= $maxErros ?></p>
            <p>Letras usadas: <?= count($letras) ? implode(', ', $letras) : 'Nenhuma' ?></p>

            <?php if ($venceu): ?>
                <p class="mensagem sucesso">Parabéns! Você venceu!</p>
            <?php elseif ($perdeu): ?>
                <p class="mensagem erro">Você perdeu! A palavra era: <?= $palavra ?></p>
            <?php else: ?>
                <form method="POST" class="formulario">
                    <input type="text" name="letra" maxlength="1" placeholder="Digite uma letra" autofocus required>
                    <button type="submit">Tentar</button>
                </form>
            <?php endif; ?>

            <form method="POST">
                <button type="submit" name="reiniciar" class="secundario">Novo jogo</button>
            </form>
        </section>
    </main>
</body>
</html>
