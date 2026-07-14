<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Garante boa exibição em dispositivos móveis -->
    <title>Grupos PET da UFF</title> <!-- Título da página -->
    <link rel="stylesheet" href="style.css"> <!-- Importa o arquivo CSS -->
</head>
<body>

    <!-- Cabeçalho da página -->
    <header>
        <div class="container">
            <h1>Grupos PET da UFF</h1>
        </div>
    </header>

    <!-- Menu de navegação -->
    <nav>
        <div class="container">
            <ul>
                <li><a href="#">Principal</a></li>
                <li><a href="#">PET</a></li>
                <li><a href="#">Integrantes</a></li>
                <li><a href="#">Atividades</a></li>
                <li><a href="#">Downloads</a></li>
                <li><a href="#">Fotos</a></li>
                <li><a href="#">Contatos</a></li>
                <li><a href="#">Links</a></li>
            </ul>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <main class="container">
    
    <!-- Seção com informações gerais -->
    <section class="info-geral">
        <h2>Contatos: Grupos PET da UFF</h2>
        <p class="subinfo">
            <strong>(Total:</strong> 21 grupos)
        </p>
        <hr>
        <h3>Informações gerais</h3>
        <p>
            A UFF conta com <strong>21 grupos PET</strong>, distribuídos da seguinte forma:
        </p>
        <ul>
            <li>8 grupos de <strong>curso único</strong> do programa federal PET do MEC;</li>
            <li>4 grupos de <strong>conexão de saberes</strong> do programa federal PET do MEC;</li>
            <li>8 grupos de <strong>curso único</strong> do programa institucional ProPET da UFF;</li>
            <li>1 grupo de <strong>conexão de saberes</strong> do programa institucional ProPET da UFF.</li>
        </ul>
    </section>
    
    <?php
    // Define as categorias e os arquivos JSON correspondentes
    $categorias = [
        "MEC - PET - Grupos de curso único" => "dados/Pet_CursoU.json",
        "MEC - PET - Conexão de Saberes" => "dados/Pet_Conex.json",
        "UFF - ProPET - Grupos de curso único" => "dados/ProPet_CursoU.json",
        "UFF - ProPET - Conexão de Saberes" => "dados/ProPet_Conex.json",
    ];

    // Percorre todas as categorias
    foreach ($categorias as $titulo => $arquivo) {

        echo "<details class='gaveta'>"; // Cria uma gaveta (seção expansível)
        echo "<summary>" . htmlspecialchars($titulo) . "</summary>"; // Título da gaveta

        // Verifica se o arquivo existe
        if (file_exists($arquivo)) {
            $jsonData = file_get_contents($arquivo); // Lê o conteúdo do arquivo
            $grupos = json_decode($jsonData, true);  // Converte o JSON para array PHP

            // Verifica se o JSON foi lido corretamente e não está vazio
            if (is_array($grupos) && !empty($grupos)) {

                // Percorre cada grupo dentro da categoria
                foreach ($grupos as $grupo) {

                    echo "<div class='bloco-grupo'>"; // Bloco de informações de um grupo
                        
                    // Exibe o nome do grupo ou "Grupo sem nome" se não existir
                    $nome = !empty($grupo['nome']) ? htmlspecialchars($grupo['nome']) : "Grupo sem nome";
                    echo "<h3 class='grupo-nome'>$nome</h3>";

                    // Lista de informações gerais do grupo
                    echo "<ul class='info-grupo'>";
                    
                    //Data de criação do grupo
                    if (!empty($grupo['criacao'])) {
                        echo "<li><strong>Criado em:</strong> " . htmlspecialchars($grupo['criacao']) . "</li>";
                    }


                    // Website do grupo
                    if (!empty($grupo['website'])) {
                        $url = (strpos($grupo['website'], 'http') === 0) ? $grupo['website'] : 'https://' . $grupo['website'];
                        echo "<li><strong>Website:</strong> <a href='" . htmlspecialchars($url) . "' target='_blank'>Acessar site</a></li>";
                    }

                    // Instagram
                    if (!empty($grupo['instagram'])) {
                        $handle = ltrim($grupo['instagram'], '@');
                        $url = "https://instagram.com/" . htmlspecialchars($handle);
                        echo "<li><strong>Instagram:</strong> <a href='$url' target='_blank'>@" . htmlspecialchars($handle) . "</a></li>";
                    }

                    // Facebook
                    if (!empty($grupo['facebook'])) {
                        echo "<li><strong>Facebook:</strong> <a href='" . htmlspecialchars($grupo['facebook']) . "' target='_blank'>Acessar</a></li>";
                    }

                    // YouTube
                    if (!empty($grupo['youtube'])) {
                        $url = (strpos($grupo['youtube'], 'http') === 0) ? $grupo['youtube'] : 'https://' . $grupo['youtube'];
                        echo "<li><strong>YouTube:</strong> <a href='" . htmlspecialchars($url) . "' target='_blank'>Acessar canal</a></li>";
                    }

                    // Outros
                    if (!empty($grupo['outros'])) {
                        $url = (strpos($grupo['outros'], 'http') === 0) ? $grupo['outros'] : 'https://' . $grupo['outros'];
                        echo "<li><strong>Outros:</strong> <a href='" . htmlspecialchars($url) . "' target='_blank'>Acessar</a></li>";
                    }

                    // Email
                    if (!empty($grupo['email'])) {
                        echo "<li><strong>Email:</strong> <a href='mailto:" . htmlspecialchars($grupo['email']) . "'>" . htmlspecialchars($grupo['email']) . "</a></li>";
                    }

                    // Localização
                    if (!empty($grupo['localizacao'])) {
                        echo "<li><strong>Localização:</strong> " . htmlspecialchars($grupo['localizacao']) . "</li>";
                    }

                    echo "</ul>";

                    // Informações do tutor
                    echo "<h4>Informações do Tutor</h4>";
                    echo "<ul class='info-tutor'>";

                    if (!empty($grupo['tutor'])) {
                        echo "<li><strong>Tutor:</strong> " . htmlspecialchars($grupo['tutor']) . "</li>";
                    }
                    if (!empty($grupo['lattes'])) {
                        $url = (strpos($grupo['website'], 'http') === 0) ? $grupo['lattes'] : 'https://' . $grupo['lattes'];
                        echo "<li><strong>Lattes:</strong> <a href='" . htmlspecialchars($url) . "' target='_blank'>Acessar site</a></li>";
                    }
                    if (!empty($grupo['webpage_tutor'])) {
                        echo "<li><strong>Webpage:</strong> " . htmlspecialchars($grupo['webpage_tutor']) . "</li>";
                    }
                    if (!empty($grupo['emaiL_tutor'])) {
                        echo "<li><strong>Email:</strong> <a href='mailto:" . htmlspecialchars($grupo['emaiL_tutor']) . "'>" . htmlspecialchars($grupo['emaiL_tutor']) . "</a></li>";
                    }
                    if (!empty($grupo['localizacao_tutor'])) {
                        echo "<li><strong>Localização:</strong> " . htmlspecialchars($grupo['localizacao_tutor']) . "</li>";
                    }

                    echo "</ul>";
                    echo "</div>"; // Fim de um grupo
                    echo "<hr class='grupo-separador'>"; 
                }
            }
        }
        echo "</details>"; // Fecha a gaveta da categoria
    }
    ?>
    </main>
</body>
</html>
