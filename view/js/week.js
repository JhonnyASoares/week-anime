function toggleDay(dayId, button) {
  const animeList = document.getElementById(dayId);

  const isHidden = animeList.classList.toggle("collapsed");

  console.log(button);

  button.textContent = isHidden ? "+" : "−";

  console.log(`Day ${dayId} is now ${isHidden ? "hidden" : "visible"}`);
}
