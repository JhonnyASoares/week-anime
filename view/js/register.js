document.addEventListener("DOMContentLoaded", function () {
  getAnimes();
});

const form = document.getElementById("form-anime");
const animeList = document.getElementById("anime-list");
var selectedAnimeId = null;
var animeData = [];

form.addEventListener("submit", async function (event) {
  event.preventDefault();

  const formData = new FormData(form);

  if (selectedAnimeId != null) {
    formData.append("id", selectedAnimeId);
  }

  for (const [key, value] of formData.entries()) {
    console.log(key, value);
  }

  try {
    const requisicao = await fetch("/api/Anime.php", {
      method: "POST",
      body: formData,
    });

    const resposta_api = await requisicao.json();

    if (resposta_api.success) {
      showToast(resposta_api.message, "success");
      form.reset();
      getAnimes();
      clearForm();
    } else {
      showToast(resposta_api.message, "error");
    }
  } catch (erro) {
    console.error("Erro ao conectar com a API:", erro);
    showToast("Não foi possível conectar com a API.", "error");
  }
});

function getAnimes() {
  fetch("/api/Anime.php?animes=true")
    .then((response) => response.json())
    .then((data) => {
      animeData = data;
      searchBar();
    })
    .catch((error) => {
      console.error("Erro ao buscar animes:", error);
    });
}

function searchBar() {
  const search = document
    .querySelector("#search-bar")
    .value.toLowerCase()
    .trim();

  const filteredAnimes = animeData.filter((anime) =>
    anime.name.toLowerCase().includes(search),
  );

  listAnimes(filteredAnimes);
}

function listAnimes(data) {
  animeList.innerHTML = "";

  data.forEach((anime) => {
    const animeItem = document.createElement("div");
    animeItem.classList.add("anime-item");
    animeItem.dataset.animeId = anime.id;
    animeItem.addEventListener("click", () => {
      updateFormWithAnimeData(anime);

      // Remove a seleção dos outros cards
      document.querySelectorAll(".anime-item").forEach((item) => {
        item.classList.remove("anime-selected");
      });

      // Seleciona o card clicado
      if (anime.id == selectedAnimeId) {
        animeItem.classList.add("anime-selected");
      }
    });

    const animeImage = document.createElement("img");
    animeImage.src = anime.image_url;
    animeImage.alt = anime.name;

    const animeName = document.createElement("span");
    animeName.classList.add("anime-name");
    animeName.textContent = anime.name;

    animeItem.appendChild(animeImage);
    animeItem.appendChild(animeName);

    animeList.appendChild(animeItem);
  });
}

function updateFormWithAnimeData(anime) {
  selectedAnimeId = anime.id;
  updateDisplayText();
  form.elements["name"].value = anime.name;
  form.elements["day"].value = anime.day;
  form.elements["link"].value = anime.link;
  form.elements["image_url"].value = anime.image_url;
  form.elements["time"].value = anime.time;

  // Atualiza os checkboxes de streaming
  const streamingCheckboxes = form.querySelectorAll(
    'input[name="streaming[]"]',
  );

  streamingCheckboxes.forEach((checkbox) => {
    checkbox.checked = anime.streaming.includes(Number(checkbox.value));
  });
}

function updateDisplayText() {
  const formTitle = document.getElementById("form-title");
  const formSubtitle = document.getElementById("form-subtitle");
  const submitButton = document.getElementById("submit-button");

  if (selectedAnimeId) {
    formTitle.textContent = "Editar Anime";
    formSubtitle.textContent = "Edite os detalhes do anime selecionado.";
    submitButton.textContent = "Salvar Alterações";
  } else {
    formTitle.textContent = "Adicionar Anime";
    formSubtitle.textContent = "Cadastre um novo anime na sua lista.";
    submitButton.textContent = "Adicionar Anime";
  }
}

function clearForm() {
  var searchBar = document.getElementById("search-bar");
  searchBar.value = "";

  selectedAnimeId = null;
  updateDisplayText();

  var $day = form.elements["day"].value;
  form.reset();
  form.elements["day"].value = $day;

  // Limpa os checkboxes de streaming
  const streamingCheckboxes = form.querySelectorAll(
    'input[name="streaming[]"]',
  );
  streamingCheckboxes.forEach((checkbox) => {
    checkbox.checked = false;
  });
}
