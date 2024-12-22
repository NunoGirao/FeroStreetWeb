<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programa de Afiliados - Fero Street Wear</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #222;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            color: #333;
        }
        .container p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            background-color: #222;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            
            margin-right: 10px;
        }
        button:hover {
            background-color: #444;
        }
        .back-button {
            background-color: #555;
        }
        .back-button:hover {
            background-color: #777;
        }
    </style>
</head>
<body>

<header>
    <h1>Programa de Afiliados - Fero Street Wear</h1>
</header>

<div class="container">
    <h1>Junte-se ao Programa de Afiliados da Fero Street Wear</h1>
    <p>A Fero Street Wear é uma marca de roupa urbana que combina estilo, atitude e qualidade. Ao inscrever-se no nosso programa de afiliados, poderá beneficiar de um desconto exclusivo de 10% para partilhar com os seus seguidores. É a forma perfeita de ganhar ao mesmo tempo que divulga uma marca autêntica e inovadora!</p>

    <h2>Inscreva-se já!</h2>
    <form id="afiliadosForm">
        <div class="form-group">
            <label for="instagram">Instagram</label>
            <input type="text" id="instagram" name="instagram" placeholder="@instagram">
        </div>
        <div class="form-group">
            <label for="tiktok">TikTok</label>
            <input type="text" id="tiktok" name="tiktok" placeholder="@tiktok">
        </div>
        <button type="button" onclick="gravarDados()">Submeter</button>
        <button type="button" class="back-button" onclick="voltarParaIndex()">Voltar</button>
    </form>
</div>

<script>
    // Função para gravar os dados do afiliado
    function gravarDados() {
        const instagram = document.getElementById('instagram').value;
        const tiktok = document.getElementById('tiktok').value;

        if (!instagram || !tiktok) {
            alert('Por favor, preencha ambos os campos.');
            return;
        }

        // Cria o objeto com os dados do afiliado
        const dadosAfiliado = { instagram, tiktok };

        // Envia os dados ao PHP via fetch
        fetch('atualizar_afiliados.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dadosAfiliado)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Os seus dados foram gravados com sucesso! Aguardando validação.');
                document.getElementById('afiliadosForm').reset();
            } else {
                alert(`Erro: ${data.error}`);
            }
        })
        .catch(error => {
            console.error('Erro ao gravar os dados:', error);
            alert('Ocorreu um erro ao gravar os dados.');
        });
    }

    function voltarParaIndex() {
        // Redireciona para o index.php
        window.location.href = 'index.php';
    }
</script>

</body>
</html>
