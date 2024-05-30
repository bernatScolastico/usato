const openBtnPrezzo=document.getElementById("openModal-prezzo");
const closeBtnPrezzo=document.getElementById("closeModal-prezzo");
const modalPrezzo=document.getElementById("modal-offerta-prezzo");
openBtnPrezzo.addEventListener("click",()=>{
    modalPrezzo.classList.add("open");
});
closeBtnPrezzo.addEventListener("click",()=>{
    modalPrezzo.classList.remove("open");
});


const openBtnPrezzo1=document.getElementById("openModal-prezzo1");
const closeBtnPrezzo1=document.getElementById("closeModal-prezzo1");
const modalPrezzo1=document.getElementById("modal-offerta-prezzo1");
openBtnPrezzo1.addEventListener("click",()=>{
    modalPrezzo1.classList.add("open");
});
closeBtnPrezzo1.addEventListener("click",()=>{
    modalPrezzo1.classList.remove("open");
});