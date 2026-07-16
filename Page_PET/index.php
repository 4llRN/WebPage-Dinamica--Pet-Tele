<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Grupos PET da UFF</title> <link rel="stylesheet" href="style.css"> </head>
<body>

    <header>
        <div class="container">
            <h1>Grupos PET da UFF</h1>
        </div>
    </header>

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

    <main class="container">
    
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
    // Define as categorias e os ficheiros JSON correspondentes
    $categorias = [
    "MEC - PET - Grupos de curso único" => "dados/grupos_pet_mec_curso_uff_2026_07_16.json",
    "MEC - PET - Conexão de Saberes" => "dados/grupos_pet_mec_conexao_uff_2026_07_16.json",
    "UFF - ProPET - Grupos de curso único" => "dados/grupos_propet_curso_uff_2026_07_16.json",
    "UFF - ProPET - Conexão de Saberes" => "dados/grupos_propet_conexao_uff_2026_07_16.json",
];

    // Percorre todas as categorias
    foreach ($categorias as $titulo => $arquivo) {

        echo "<details class='gaveta'>"; // Cria uma gaveta (seção expansível)
        echo "<summary>" . htmlspecialchars($titulo) . "</summary>"; // Título da gaveta

        // Verifica se o arquivo existe
        if (file_exists($arquivo)) {
            $jsonData = file_get_contents($arquivo); // Lê o conteúdo do arquivo
            $dados_arquivo = json_decode($jsonData, true);  // Converte o JSON para array PHP

            // Verifica se o JSON foi lido corretamente e não está vazio
            if (is_array($dados_arquivo) && !empty($dados_arquivo)) {

                // Como cada arquivo JSON possui uma chave raiz diferente, pegamos o primeiro elemento do array (a lista de grupos)
                $lista_grupos = reset($dados_arquivo);

                if (is_array($lista_grupos)) {

                    // Percorre cada registro dentro da lista
                    foreach ($lista_grupos as $registro) {
                        
                        $g = $registro['grupo'] ?? [];
                        $t = $registro['tutor'] ?? [];

                        echo "<div class='bloco-grupo'>"; // Bloco de informações de um grupo
                        
                        // Exibe o nome do grupo ou "Grupo sem nome" se não existir
                        $nome = !empty($g['nome']) ? htmlspecialchars($g['nome']) : "Grupo sem nome";
                        echo "<h3 class='grupo-nome'>$nome</h3>";

                        // Lista de informações gerais do grupo
                        echo "<ul class='info-grupo'>";
                        
                        // Data de criação do grupo no formato [mês, ano]
                        if (!empty($g['criacao']) && is_array($g['criacao'])) {
                            $mes = !empty($g['criacao'][0]) ? htmlspecialchars($g['criacao'][0]) . "/" : "";
                            $ano = !empty($g['criacao'][1]) ? htmlspecialchars($g['criacao'][1]) : "";
                            if ($ano !== "") {
                                echo "<li><strong>Criado em:</strong> " . $mes . $ano . "</li>";
                            }
                        }

                        // Campus do grupo
                        if (!empty($g['campus'])) {
                            echo "<li><strong>Campus:</strong> " . htmlspecialchars($g['campus']) . "</li>";
                        }

                        // Website do grupo
                        if (!empty($g['website'])) {
                            $url = (strpos($g['website'], 'http') === 0) ? $g['website'] : 'https://' . $g['website'];
                            echo "<li><strong>Website:</strong> <a href='" . htmlspecialchars($url) . "' target='_blank'>Acessar site</a></li>";
                        }

                        // Instagram (Trata a URL completa e extrai o handle para exibir "@nome_do_perfil")
                        if (!empty($g['instagram'])) {
                            $url = (strpos($g['instagram'], 'http') === 0) ? $g['instagram'] : 'https://instagram.com/' . ltrim($g['instagram'], '@');
                            $path = parse_url($url, PHP_URL_PATH);
                            $handle = $path ? trim($path, '/') : 'Instagram';
                            echo "<li><strong>Instagram:</strong> <a href='" . htmlspecialchars($url) . "' target='_blank'>@" . htmlspecialchars($handle) . "</a></li>";
                        }

                        // Facebook
                        if (!empty($g['facebook'])) {
                            echo "<li><strong>Facebook:</strong> <a href='" . htmlspecialchars($g['facebook']) . "' target='_blank'>Acessar</a></li>";
                        }

                        // YouTube
                        if (!empty($g['youtube'])) {
                            $url = (strpos($g['youtube'], 'http') === 0) ? $g['youtube'] : 'https://' . $g['youtube'];
                            echo "<li><strong>YouTube:</strong> <a href='" . htmlspecialchars($url) . "' target='_blank'>Acessar canal</a></li>";
                        }

                        // Outros links
                        if (!empty($g['outros'])) {
                            $url = (strpos($g['outros'], 'http') === 0) ? $g['outros'] : 'https://' . $g['outros'];
                            echo "<li><strong>Outros:</strong> <a href='" . htmlspecialchars($url) . "' target='_blank'>Acessar</a></li>";
                        }

                        // Email do grupo
                        if (!empty($g['email'])) {
                            echo "<li><strong>Email:</strong> <a href='mailto:" . htmlspecialchars($g['email']) . "'>" . htmlspecialchars($g['email']) . "</a></li>";
                        }

                        // Localização do grupo (Rua/Sala)
                        if (!empty($g['local'])) {
                            echo "<li><strong>Localização:</strong> " . htmlspecialchars($g['local']) . "</li>";
                        }

                        echo "</ul>";

                        if (!empty($t['nome'])) {
                            echo "<h4>Informações do Tutor</h4>";
                            echo "<ul class='info-tutor'>";

                            echo "<li><strong>Tutor:</strong> " . htmlspecialchars($t['nome']) . "</li>";

                            if (!empty($t['lattes'])) {
                                $url = (strpos($t['lattes'], 'http') === 0) ? $t['lattes'] : 'https://' . $t['lattes'];
                                echo "<li><strong>Lattes:</strong> <a href='" . htmlspecialchars($url) . "' target='_blank'>Acessar currículo</a></li>";
                            }
                            if (!empty($t['webpage'])) {
                                $url = (strpos($t['webpage'], 'http') === 0) ? $t['webpage'] : 'https://' . $t['webpage'];
                                echo "<li><strong>Webpage:</strong> <a href='" . htmlspecialchars($url) . "' target='_blank'>Acessar site</a></li>";
                            }
                            if (!empty($t['email'])) {
                                echo "<li><strong>Email:</strong> <a href='mailto:" . htmlspecialchars($t['email']) . "'>" . htmlspecialchars($t['email']) . "</a></li>";
                            }
                            if (!empty($t['local'])) {
                                echo "<li><strong>Localização:</strong> " . htmlspecialchars($t['local']) . "</li>";
                            }

                            echo "</ul>";
                        }

                        echo "</div>"; 
                        echo "<hr class='grupo-separador'>"; 
                    }
                }
            }
        }
        echo "</details>"; // Fecha a gaveta da categoria
    }
    ?>
    </main>
</body>
</html>
