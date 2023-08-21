const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const icondrops = $$(".tab-item");
const tabpanes= $$(".tab-pane_item")

icondrops.forEach((icondrop, index) => {
    const pane = tabpanes[index];
  
    icondrop.onclick = function () {        
        const pane1 = $(".tab-pane_item.active");
        if(pane1 == null){
            pane.classList.add("active");
        }
        else{
            if(pane1 == pane){
                $(".tab-pane_item.active").classList.remove("active");
            }
            else{
                $(".tab-pane_item.active").classList.remove("active");
                pane.classList.add("active");
            }
        }
    };
  });
