# Week Anime

Aplicação web simples para organizar os animes da temporada por dia da semana. Os títulos são cadastrados manualmente com o dia e o horário de lançamento, as plataformas de streaming, um link de referência e a URL da capa.

## Funcionalidades

- Exibe os animes organizados de domingo a sábado.
- Permite cadastrar e editar animes pela página de registro.
- Permite informar o nome, o dia de lançamento, o horário, o link de referência e a imagem de capa.
- Permite associar uma ou mais plataformas de streaming a cada anime.
- Filtra os animes cadastrados pelo nome na página de registro.
- O horário e as plataformas são opcionais.

## Tecnologias

- PHP com PDO
- MySQL
- HTML, CSS e JavaScript

## Requisitos

- PHP com as extensões PDO e PDO MySQL habilitadas
- MySQL
- Apache com `mod_rewrite` habilitado e suporte a arquivos `.htaccess`

## Instalação

1. Clone o repositório e configure o Apache para servir a pasta do projeto.
2. Crie o banco de dados e as tabelas necessárias. O SQL abaixo corresponde às colunas utilizadas pela aplicação:

   ```sql
   CREATE DATABASE week_anime
     CHARACTER SET utf8mb4
     COLLATE utf8mb4_unicode_ci;

   USE week_anime;

   CREATE TABLE anime (
     id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR(255) NOT NULL,
     day VARCHAR(20) NOT NULL,
     link TEXT NOT NULL,
     image_url TEXT NOT NULL,
     time TIME NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

   CREATE TABLE streaming (
     id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR(100) NOT NULL,
     image_url TEXT NOT NULL,
     color CHAR(6) NOT NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

   CREATE TABLE stream_week_link (
     anime_id INT UNSIGNED NOT NULL,
     streaming_id INT UNSIGNED NOT NULL,
     PRIMARY KEY (anime_id, streaming_id),
     CONSTRAINT fk_stream_week_link_anime
       FOREIGN KEY (anime_id) REFERENCES anime (id) ON DELETE CASCADE,
     CONSTRAINT fk_stream_week_link_streaming
       FOREIGN KEY (streaming_id) REFERENCES streaming (id) ON DELETE CASCADE
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
   ```

3. Cadastre as plataformas que estarão disponíveis no formulário. `image_url` deve apontar para o ícone da plataforma e `color` deve conter a cor hexadecimal sem `#`:

   ```sql
   INSERT INTO streaming (name, image_url, color)
   VALUES ('Nome da plataforma', 'https://exemplo.com/icone.png', '123456');
   ```

4. Copie `.env.example` para `.env` e preencha as credenciais do MySQL:

   ```dotenv
   DB_HOST=localhost
   DB_NAME=week_anime
   DB_USER=seu_usuario
   DB_PASSWORD=sua_senha
   ```

   O arquivo `.env` contém credenciais locais e não deve ser enviado ao GitHub. Ele já está listado no `.gitignore`.

5. Acesse a raiz do site para ver a programação semanal. A página de cadastro e edição fica em `/register`.

## Observação de segurança

A página de registro e o endpoint da API não possuem autenticação. Antes de publicar a aplicação em um servidor acessível pela internet, restrinja o acesso a essas rotas ou implemente autenticação.
