<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FeroStreetWear</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="css/css2.css" />
    <link rel="stylesheet" href="css/navbarcss.css" />
  </head>

  <body>
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Container para os produtos -->
    <div class="container my-5">
      <div id="product-list" class="row g-4">
        <?php
        // Nome do arquivo JSON
        $jsonFile = 'produtos.json';

        // Verifica se o arquivo JSON existe
        if (file_exists($jsonFile)) {
          // Carrega os produtos do arquivo JSON
          $produtos = json_decode(file_get_contents($jsonFile), true);

          // Filtra os produtos que são apenas Sweats
          $camisas = array_filter($produtos, function ($produto) {
            return $produto['tipo'] === 'Sweat';
          });

          // Renderiza os produtos
          foreach ($camisas as $produto) {
            echo '
            <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="card product-card h-100" onclick="window.location.href=\'pagprod.php?id=' . $produto['id'] . '\'">
                <img src="' . htmlspecialchars($produto['foto'], ENT_QUOTES) . '" class="card-img-top" alt="' . htmlspecialchars($produto['nome'], ENT_QUOTES) . '">
                <div class="card-body text-center">
                  <h5 class="card-title">' . htmlspecialchars($produto['nome'], ENT_QUOTES) . '</h5>
                  <p class="card-text fw-bold">€' . htmlspecialchars($produto['preço'], ENT_QUOTES) . '</p>
                </div>
              </div>
            </div>';
          }
        } else {
          echo '<p class="text-danger">Erro: O arquivo de produtos não foi encontrado.</p>';
        }
        ?>
      </div>
    </div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <script src="js/bootstrap.bundle.min.js"></script>
    <?php include 'scripts/scriptbarrapesquisa.php'; ?>
  </body>
</html>
