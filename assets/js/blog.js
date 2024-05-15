document.addEventListener("DOMContentLoaded", () => {
  const entries = Array.from(document.querySelectorAll(".blog"));
  function selectEntries(term) {
    if (term === "all") {
      entries.forEach((entry) =>{
        entry.classList.remove("hidden");
      })
    } 
    //term = "blog-item";
    else {
      term = "category-" + term;
      const termCa = term + "-2";
      console.log(termCa);
    entries.forEach((entry) => {
      if (entry.classList.contains(term) || entry.classList.contains(termCa) ) {
        entry.classList.remove("hidden");
      } else {
        entry.classList.add("hidden");
      }
    });
    } 
  }

  Array.from(document.querySelectorAll(".archive-blog__filter")).forEach((filter) => {
    const term = filter.dataset.term;
    filter.addEventListener("click", () => selectEntries(term));
  });

  selectEntries("all");
});
