<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FeroStreetWear</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/css2.css">

    <style>

    </style>
</head>

<body>

    <!-- Navbar -->
    <?php include 'includes/navbar.php';  ?>

    <!-- Vídeo banner com texto sobreposto -->
    <div class="videobanner">
        <div class="video-dark-overlay"></div>
        <video autoplay muted loop playsinline>
            <source src="vid/videofero2.mp4" type="video/mp4">
        </video>
        <div class="video-overlay">
            <h2 class="text-impacto">Novidades em Breve</h2>
            <p class="subtext">Não perca</p>
            <a href="camisas.php" class="btn btn-custom">Saiba Mais</a>
        </div>
    </div>

    <!-- Artigos em Destaque -->
    <div class="mt-2 mb-0">
        <div class="text-dark p-3 mb-5 text-center fs-2" style="background-color: #ffffff; border-bottom: 2px solid black; border-top: 2px solid black;">
            Artigos em Destaque
        </div>
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-12 d-flex flex-wrap gap-5 justify-content-center" id="featured-products-container">
                    <!-- Os produtos em destaque serão carregados aqui dinamicamente -->
                </div>
            </div>
        </div>
    </div>

    <!-- Seção sobre a empresa -->
    <div id="sobre" class="mt-2 mb-0">
        <div class="text-dark p-3 mb-5 text-center fs-2" style="background-color: #ffffff; border-bottom: 2px solid black; border-top: 2px solid black;">
            Sobre a Fero StreetWear
        </div>
        <div class="d-flex justify-content-center p-3">
            <div class="card-container">
                <div class="row align-items-center">
                    <!-- Texto sobre a empresa -->
                    <div class="col-md-6 mb-4 mb-0">
                        <h2 style="color: #000000; font-family: 'Brush Script MT', cursive; font-size: 50px;">
                            Conheça a Fero StreetWear
                        </h2>
                        <p style="text-align: justify;">
                            A Fero StreetWear é muito mais do que uma marca de moda urbana — somos uma referência para aqueles que valorizam estilo, autenticidade e uma conexão com a cultura de rua. As nossas coleções capturam a energia vibrante das cidades e a expressão única de cada indivíduo, transformando-a em peças modernas e confortáveis.
                            Com uma estética ousada e uma qualidade premium, criamos produtos que representam um estilo de vida para quem deseja afirmar a sua personalidade com originalidade e confiança. A nossa missão é oferecer roupas que unam conforto e design arrojado, mantendo-se sempre alinhadas às tendências contemporâneas e à essência da moda urbana.
                            Descubra o mundo Fero StreetWear e junte-se à nossa comunidade de pessoas que fazem da moda uma extensão da sua identidade.
                        </p>
                    </div>

                    <!-- vídeo -->
                    <div class="col-md-6">
                        <video class="w-100" autoplay muted loop playsinline>
                            <source src="vid/videofero.mp4" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <?php include 'includes/footer.php';  ?>


    <script src="js/bootstrap.bundle.min.js"></script>


    <script>
        // Carregar os produtos do ficheiro json
        let produtos = [];

        document.addEventListener("DOMContentLoaded", () => {
            fetch('produtos.json')
                .then(response => response.json())
                .then(data => {
                    produtos = data; // Armazenar os produtos carregados
                    displayFeaturedProducts(); // Chamar a função para mostrar os produtos em destaque
                })
                .catch(error => console.error("Erro ao carregar os produtos:", error));
        });

        // Função para exibir os artigos em destaque
        function displayFeaturedProducts() {
            const container = document.getElementById('featured-products-container');
            container.innerHTML = ''; // Limpar qualquer conteúdo existente

            // Filtrar produtos com destaque: true
            const featuredProducts = produtos.filter(produto => produto.destaque === true);

            // Gerar HTML para cada produto em destaque
            featuredProducts.forEach(produto => {
                const card = document.createElement('div');
                card.classList.add('card', 'card-square');

                card.innerHTML = `
                <img src="${produto.foto}" class="card-img-top" alt="${produto.nome}" onclick="redirectToProduct(${produto.id})">
            `;
                container.appendChild(card);
            });
        }

        // Função para redirecionar para a página do produto ao clicar
        function redirectToProduct(productId) {
            // Redirecionar para a página do produto com base no ID
            window.location.href = `pagprod.php?id=${productId}`;
        }
    </script>

    <?php
    // script barra pesquisa
    include 'scripts/scriptbarrapesquisa.php';
    ?>

    <script>
        function redirectTo(url) {
            window.location.href = url;
        }
    </script>




</body>

</html>