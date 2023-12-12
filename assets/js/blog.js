document.addEventListener("DOMContentLoaded", () => {
  const entries = Array.from(document.querySelectorAll(".blog-item"));
  function selectEntries(term) {
    if (term === "all") term = "blog-item";
    else term = "category-" + term;
    entries.forEach((entry) => {
      if (entry.classList.contains(term)) {
        entry.classList.remove("hidden");
      } else {
        entry.classList.add("hidden");
      }
    });
  }

  Array.from(document.querySelectorAll(".archive-blog__filter")).forEach((filter) => {
    const term = filter.dataset.term;
    filter.addEventListener("click", () => selectEntries(term));
  });

  selectEntries("all");
});
