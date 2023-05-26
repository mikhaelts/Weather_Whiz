<!DOCTYPE html>
<html>

<head>
    <title>Weather App</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 88vh;
            font-family: Arial, sans-serif;
            
       
        }

        h1 {
            font-size: 36px;
            margin-bottom: 0px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-size: 18px;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 300px;
            height: 30px;
            font-size: 16px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        button[type="submit"] {
            width: 100px;
            height: 30px;
            font-size: 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .weather-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 20px;
            color: white;
            padding: 20px;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 26px;
            /* Tamanho grande da temperatura */
            margin-bottom: 5px;
        }

        .container-nome {
            display: flex;
            justify-content: center;
            margin-top: 0px;
            background-color: #173c51;
            color: white;
            /* Corrigido para adicionar unidade de medida */
        }

        .container-input {
            padding-right: 100px;
        }
    </style>
</head>

<body>
    <div class="container-nome">
        <h1>Weather Whiz</h1>
    </div>

    <main>
        <div class="container-input">
            <form method="GET" action="index.php">
                <label for="city">Digite o nome da cidade:</label>
                <input type="text" name="city" id="city" required>
                <button type="submit">Buscar</button>
            </form>
        </div>

        <?php
        // Verifique se o formulário foi enviado
        if (isset($_GET['city'])) {
            // Obtenha o nome da cidade fornecido pelo usuário
            $city = $_GET['city'];

            // Chame a API OpenWeatherMap para obter os dados da previsão do tempo
            $apiKey = '3f7dfdee722da59b783265d8695af24c';
            $url = "https://api.openweathermap.org/data/2.5/weather?q=$city&units=metric&appid=$apiKey";
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            // Verifique se os dados foram obtidos
        
            if ($data && $data['cod'] == 200) {
                $temperature = $data['main']['temp']; // Temperatura em Celsius
                $description = $data['weather'][0]['description'];
                $icon = $data['weather'][0]['icon'];
            
                // Mapeamento das descrições em inglês para português
                $descriptionMap = array(
                    'clear sky' => 'céu limpo',
                    'few clouds' => 'poucas nuvens',
                    'scattered clouds' => 'nuvens dispersas',
                    'broken clouds' => 'nuvens quebradas',
                    'shower rain' => 'chuva',
                    'rain' => 'chuva',
                    'thunderstorm' => 'tempestade',
                    'snow' => 'neve',
                    'mist' => 'névoa'
                );
            
                // Verifica se a descrição existe no mapeamento
                if (array_key_exists($description, $descriptionMap)) {
                    // Substitui a descrição em inglês pela tradução em português
                    $description = $descriptionMap[$description];
                }
            
                echo "<div class='weather-info'>";
                echo "<h3>Previsão do tempo para $city</h3>";
                echo "<p><span class='temperature'>$temperature °C</span></p>";
                echo "<p>$description</p>";
                echo "<img src='http://openweathermap.org/img/w/$icon.png' alt='Weather Icon'>";
                echo "</div>";
            } else {
                echo "<p>Erro ao obter dados da previsão do tempo.</p>";
            }
        }
        ?>
<?php
// ...

// Definir o caminho para os vídeos do clima
$videoPath = './videos';

// Obter o código do ícone do clima
$weatherIcon = $data['weather'][0]['icon'];

// Lógica para selecionar o vídeo com base no ícone do clima
if (strpos($weatherIcon, '01') !== false) {
    // Ícone representa sol
    $video = 'sol.mp4';
} else if (strpos($weatherIcon, '02') !== false || strpos($weatherIcon, '03') !== false) {
    // Ícone representa nuvens
    $video = 'nublado.mp4';
} else if (strpos($weatherIcon, '04') !== false || strpos($weatherIcon, '09') !== false || strpos($weatherIcon, '10') !== false) {
    // Ícone representa chuva
    $video = 'chuva.mp4';
} else {
    // Ícone desconhecido, usar um vídeo padrão
    $video = 'padrao.mp4';
}

// Exibir o vídeo correspondente ao clima como fundo no main
echo "<style>
    main {
        position: relative;
        overflow: hidden;
    }

    #background-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -1;
    }
</style>";

echo "<video autoplay loop muted playsinline id='background-video'>";
echo "<source src='$videoPath/$video' type='video/mp4'>";
echo "</video>";

// ...
?>




    </main>

    <script>
    // Script para alterar a cor do texto da temperatura com base no seu valor
    var temperatureElement = document.querySelector('.temperature');
    var temperature = parseFloat(temperatureElement.innerHTML);
    if (temperature > 25) {
        temperatureElement.style.color = 'red';
    } else if (temperature < 15) {
        temperatureElement.style.color = 'green';
    }
    </script>
</body>

</html>