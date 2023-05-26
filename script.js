window.onload = () => {
    const modalButtons = document.querySelectorAll("[data-toggle=modal]");
    
for(let button of modalButtons){
    button.addEventListener("click", function(e){
        e.preventDefault();
        let target = this.dataset.target
        console.log(target)

        let modal = document.querySelector(target);
        modal.classList.add("show");

        const modalClose = modal.querySelectorAll("[data-dismiss=dialog]");

        for(let close of modalClose){
            close.addEventListener("click", () => {
               modal.classList.remove("show"); 
            });
         }
        
        modal.addEventListener("click", function(){
            this.classList.remove("show");
        }); 
        modal.children[0].addEventListener("click", function(e){
            e.stopPropagation();
        })
    });
}
}
const  modalDeleteTriggers = document.querySelectorAll(".sup")
let id = null

modalDeleteTriggers.forEach((Trigger) =>
  Trigger.addEventListener("click", () => {
    id = Trigger.getAttribute("data-id");
  })
);

const btn = document.querySelector(".btn")  
 btn.addEventListener("click", ()=> {     
    window.location.replace("delete.php?id=" + id)});