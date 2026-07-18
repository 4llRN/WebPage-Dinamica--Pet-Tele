<?php

$categorias = [
    "MEC - PET - Grupos de curso único" => "dados/grupos_pet_mec_curso_uff.json",
    "MEC - PET - Conexão de Saberes" => "dados/grupos_pet_mec_conexao_uff.json",
    "UFF - ProPET - Grupos de curso único" => "dados/grupos_propet_ies_curso_uff.json",
    "UFF - ProPET - Conexão de Saberes" => "dados/grupos_propet_ies_conexao_uff.json",
];

//Para evitar ler os arquivos novamente, guardo as infos dos grupos 
$dados_prontos = [];

// Total de cada grupo por arquivo
$totais = [];     

// Soma de todos os grupos 
$total_geral = 0;    

// Contador de grupos dinamico
foreach ($categorias as $titulo => $arquivo) {
    if (file_exists($arquivo)) {
        
        $json_obj  = file_get_contents($arquivo);
        $json_data = json_decode($json_obj, true);
        
        // Como a chave da raiz muda a cada arquivo, uso reset () para pegar a array principal diretamente
        $lista = reset($json_data);
        
        // Conta os grupos usando o sizeof() e soma
        $totais[$titulo] = sizeof($lista);
        $total_geral += sizeof($lista);
        

        $dados_prontos[$titulo] = $lista;
    } else {
        //Caso o arquivo nao exista
        $totais[$titulo] = 0; 
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Grupos PET da UFF</title> <link rel="stylesheet" href="style.css"> 
</head>
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
            <!-- Imprime as contagens geradas no topo -->
            <strong>(Total:</strong> <?php echo $total_geral; ?> grupos)
        </p>
        <hr>
        <h3>Informações gerais</h3>
        <p>
            A UFF conta com <strong><?php echo $total_geral; ?> grupos PET</strong>, distribuídos da seguinte forma:
        </p>
        <ul>
            <li><?php echo $totais["MEC - PET - Grupos de curso único"]; ?> grupos de <strong>curso único</strong> do programa federal PET do MEC;</li>
            <li><?php echo $totais["MEC - PET - Conexão de Saberes"]; ?> grupos de <strong>conexão de saberes</strong> do programa federal PET do MEC;</li>
            <li><?php echo $totais["UFF - ProPET - Grupos de curso único"]; ?> grupos de <strong>curso único</strong> do programa institucional ProPET da UFF;</li>
            <li><?php echo $totais["UFF - ProPET - Conexão de Saberes"]; ?> grupo(s) de <strong>conexão de saberes</strong> do programa institucional ProPET da UFF.</li>
        </ul>
    </section>
    
    <?php
    // Crio as "gavetas" usando os dados salvos anteriormente 
    foreach ($dados_prontos as $titulo => $lista_grupos) {

        echo "<details class='gaveta'>"; 
        echo "<summary>" . htmlspecialchars($titulo) . "</summary>"; 

        if (is_array($lista_grupos)) {
            foreach ($lista_grupos as $registro) {
                
                $g = $registro['grupo'] ?? [];
                $t = $registro['tutor'] ?? [];

                echo "<div class='bloco-grupo'>"; 
                
                $nome = !empty($g['nome']) ? htmlspecialchars($g['nome']) : "Grupo sem nome";
                echo "<h3 class='grupo-nome'>$nome</h3>";

                echo "<ul class='info-grupo'>";
                
                if (!empty($g['criacao']) && is_array($g['criacao'])) {
                    $mes = !empty($g['criacao'][0]) ? htmlspecialchars($g['criacao'][0]) . "/" : "";
                    $ano = !empty($g['criacao'][1]) ? htmlspecialchars($g['criacao'][1]) : "";
                    if ($ano !== "") {
                        echo "<li><strong>Criado em:</strong> " . $mes . $ano . "</li>";
                    }
                }

                if (!empty($g['campus'])) {
                    echo "<li><strong>Campus:</strong> " . htmlspecialchars($g['campus']) . "</li>";
                }

                if (!empty($g['website'])) {
                    $url = (strpos($g['website'], 'http') === 0) ? $g['website'] : 'https://' . $g['website'];
                    echo "<li><strong>Website:</strong> <a href='" . htmlspecialchars($url) . "' target='_blank'>Acessar site</a></li>";
                }

                if (!empty($g['instagram'])) {
                    $url = (strpos($g['instagram'], 'http') === 0) ? $g['instagram'] : 'https://instagram.com/' . ltrim($g['instagram'], '@');
                    $path = parse_url($url, PHP_URL_PATH);
                    $handle = $path ? trim($path, '/') : 'Instagram';
                    echo "<li><strong>Instagram:</strong> <a href='" . htmlspecialchars($url) . "' target='_blank'>@" . htmlspecialchars($handle) . "</a></li>";
                }

                if (!empty($g['facebook'])) {
                    echo "<li><strong>Facebook:</strong> <a href='" . htmlspecialchars($g['facebook']) . "' target='_blank'>Acessar</a></li>";
                }

                if (!empty($g['youtube'])) {
                    $url = (strpos($g['youtube'], 'http') === 0) ? $g['youtube'] : 'https://' . $g['youtube'];
                    echo "<li><strong>YouTube:</strong> <a href='" . htmlspecialchars($url) . "' target='_blank'>Acessar canal</a></li>";
                }

                if (!empty($g['outros'])) {
                    $url = (strpos($g['outros'], 'http') === 0) ? $g['outros'] : 'https://' . $g['outros'];
                    echo "<li><strong>Outros:</strong> <a href='" . htmlspecialchars($url) . "' target='_blank'>Acessar</a></li>";
                }

                if (!empty($g['email'])) {
                    echo "<li><strong>Email:</strong> <a href='mailto:" . htmlspecialchars($g['email']) . "'>" . htmlspecialchars($g['email']) . "</a></li>";
                }

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
        
        echo "</details>"; 
    }
    ?>
    </main>
</body>
</html>