<?php  
require_once '../controller/Streaming.php';
$streamingPlatforms = streamingFullData();
?>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Week Anime</title>
    <link rel="stylesheet" type="text/css" href="/view/css/register.css">
    <link rel="stylesheet" type="text/css" href="/view/css/toast.css">
    <link rel="shortcut icon" href="/ram.ico">
    <link rel="icon" href="/ram.ico">
    <link href="https://fonts.googleapis.com/css2?family=Quintessential&display=swap" rel="stylesheet">

<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>
<div id="toast" class="toast">
    <span id="toast-message"></span>
</div>

<body>
<!-- Formulário para adicionar um anime à lista -->
<div class="container">
    <div class="form-card">
        <div class="title-container">
            <h1 id="form-title">Adicionar Anime</h1>
            <button onclick="clearForm()">Limpar</button>
        </div>
        <p class="subtitle" id="form-subtitle">Cadastre um novo anime na sua lista.</p>

        <form id="form-anime">

            <div class="form-group">
                <label for="name">Nome do Anime</label>
                <input 
                    id="name" 
                    name="name" 
                    placeholder="Ex: One Piece"
                    required
                >
            </div>

            <div class="form-group">
                <label for="day">Dia da Semana</label>
                <select id="day" name="day" required>
                    <option value="domingo">Domingo</option>
                    <option value="segunda">Segunda-feira</option>
                    <option value="terça">Terça-feira</option>
                    <option value="quarta">Quarta-feira</option>
                    <option value="quinta">Quinta-feira</option>
                    <option value="sexta">Sexta-feira</option>
                    <option value="sábado">Sábado</option>
                </select>
            </div>

            <div class="form-group">
                <label for="link">Link do Anime</label>
                <input 
                    type="url" 
                    id="link" 
                    name="link" 
                    placeholder="https://..."
                    required
                >
            </div>

            <div class="form-group">
                <label for="image_url">URL da Imagem</label>
                <input 
                    type="url" 
                    id="image_url" 
                    name="image_url"
                    placeholder="https://..."
                    required
                >
            </div>

            <div class="form-group">
                <label for="time">Horário de Lançamento <span>(opcional)</span></label>
                <input type="time" id="time" name="time">
            </div>

            <div class="form-group">
                <label>Plataformas de Streaming</label>

                <div class="streaming-options">
                    <?php foreach ($streamingPlatforms as $platform) { ?>
                        <label class="streaming-option">
                            <input
                                type="checkbox"
                                name="streaming[]"
                                value="<?= htmlspecialchars($platform['id']) ?>"
                            >

                            <span class="checkmark"></span>

                            <span class="platform-name">
                                <?= htmlspecialchars($platform['name']) ?>
                            </span>
                        </label>
                    <?php } ?>
                </div>
            </div>

            <button type="submit" class="submit-button" id="submit-button">
                Adicionar Anime
            </button>

        </form>
    </div>
</div>

<div class="container">
    <div class="form-card">
        <h1>Lista de Animes</h1>
        <p class="subtitle">Confira os animes cadastrados.</p>

            <div class="form-group">
                <input 
                    id="search-bar" 
                    name="search-bar"
                    placeholder="Escreva o nome do anime"
                    onkeyup="searchBar()"
                >
            </div>

        <div id="anime-list" class="anime-list">
            <!-- A lista de animes será carregada aqui via JavaScript, erei exibir a imagem em miniatura e o nome do anime -->
            <div class="anime-item">
                <img src="" alt="Imagem do Anime" class="anime-image">
                <span class="anime-name"></span>
            </div>
        </div>
    </div>
</div>
<script src="/view/js/toast.js"></script>
<script src="/view/js/register.js"></script>
</body>