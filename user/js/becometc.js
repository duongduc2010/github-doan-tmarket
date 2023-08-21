const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const checkbox = $(".check");
const btn = $(".btn-register");





checkbox.addEventListener('change', (event) => {
    if (event.currentTarget.checked) {
        console.log(btn)    
        btn.style.backgroundColor = "#3c9b27";
        btn.style.cursor = "pointer";
    }else{
        btn.style.backgroundColor = "#6eb54d";
        btn.style.cursor = "text";
    }
  })
