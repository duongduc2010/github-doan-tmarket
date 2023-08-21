const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const tabs = $$(".card_detail-item");
const panes = $$(".tab-pane");

const tabActive = $(".card_detail-item.active");
const dong = $(".dong");
console.log(dong)

// SonDN fixed - Active size wrong size on first load.
// Original post: https://www.facebook.com/groups/649972919142215/?multi_permalinks=1175881616551340

requestIdleCallback(function () {
  dong.style.left = tabActive.offsetLeft + "px";
  dong.style.width = tabActive.offsetWidth + "px";
});

tabs.forEach((tab, index) => {
  const pane = panes[index];

  tab.onclick = function () {
    $(".card_detail-item.active").classList.remove("active");
    $(".tab-pane.active").classList.remove("active");

    dong.style.left = this.offsetLeft + "px";
    dong.style.width = this.offsetWidth + "px";

    this.classList.add("active");
    pane.classList.add("active");
  };
});
