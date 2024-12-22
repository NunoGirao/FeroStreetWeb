<script>
    // Array para armazenar os produtos carregados do ficheiro JSON para pesquisa
    let produtosPesquisa = [];

    // Carrega os produtos a partir do ficheiro JSON quando a página é carregada
    document.addEventListener("DOMContentLoaded", () => {
        // Faz um pedido ao ficheiro 'produtos.json'
        fetch('produtos.json')
            .then(response => response.json()) // Converte a resposta para formato JSON
            .then(data => {
                produtosPesquisa = data; // Armazena os produtos para uso na pesquisa
            })
            .catch(error => console.error("Erro ao carregar os produtos:", error)); // Caso haja um erro, mostra uma mensagem na consola
    });

    // Função que realiza a pesquisa
    function performSearch() {
        // Obtém o valor inserido no campo de pesquisa e converte para minúsculas
        const query = document.getElementById('search-input').value.toLowerCase();
        // Obtém o elemento que mostrará os resultados da pesquisa
        const resultsDiv = document.getElementById('search-results');

        // Limpa os resultados anteriores antes de mostrar novos resultados
        resultsDiv.innerHTML = '';

        if (query) {
            // Filtra os produtos com base no termo de pesquisa inserido (nome ou tipo do produto)
            const resultados = produtosPesquisa.filter(produto =>
                produto.nome.toLowerCase().includes(query) || // Verifica se o nome do produto contém o termo pesquisado
                produto.tipo.toLowerCase().includes(query) // Verifica se o tipo do produto contém o termo pesquisado
            );

            // Exibe os resultados encontrados
            if (resultados.length > 0) {
                resultados.forEach(produto => {
                    // Cria um elemento para cada resultado encontrado
                    const resultItem = document.createElement('div');
                    resultItem.classList.add('result-item');
                    // Define o conteúdo HTML do item de resultado (imagem, nome e preço)
                    resultItem.innerHTML = `
                        <img src="${produto.foto}" alt="${produto.nome}" width="50" height="50" style="margin-right: 10px;">
                        <strong>${produto.nome}</strong> 
                    `;
                    // Define um evento para redirecionar para a página do produto ao clicar no item
                    resultItem.onclick = () => window.location.href = `pagprod.php?id=${produto.id}`;
                    // Adiciona o item de resultado à lista de resultados
                    resultsDiv.appendChild(resultItem);
                });
                // Torna a lista de resultados visível
                resultsDiv.style.display = 'block';
            } else {
                // Se não houver resultados, esconde a lista de resultados
                resultsDiv.style.display = 'none';
            }
        } else {
            // Se a pesquisa estiver vazia, esconde a lista de resultados
            resultsDiv.style.display = 'none';
        }
    }
</script>