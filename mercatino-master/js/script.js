const openBtn=document.getElementById("openModal");
const closeBtn=document.getElementById("closeModal");
const modal=document.getElementById("modal");

openBtn.addEventListener("click",()=>{
    modal.classList.add("open");
});
closeBtn.addEventListener("click",()=>{
    modal.classList.remove("open");
});


function preview() {
    var files = document.querySelector('input[type=file]').files;
    var images = document.getElementById('images');
    var num_of_files = document.getElementById('num-of-files');
    images.innerHTML = '';
    if(num_of_files.innerHTML==1)
        num_of_files.innerHTML = files.length + ' foto selezionata';
    else
        num_of_files.innerHTML = files.length + ' foto selezionate';
    for (var i = 0; i < files.length; i++) {
        var image = document.createElement('img');
        image.src = URL.createObjectURL(files[i]);
        image.style.width = '50%';
        image.style.height = '50%';
        image.style.margin = '10px';
        images.appendChild(image);
    }
}


/*
function preview_carousel() {.
    var files = document.getElementById('file-input').files;
    var carousel = document.getElementById('carouselExample');
    var carouselInner = carousel.getElementsByClassName('carousel-inner')[0];
    var num_of_files = document.getElementById('num-of-files');
    num_of_files.innerHTML = files.length + ' foto selezionate';
    carouselInner.innerHTML = '';

    for (var i = 0; i < files.length; i++) {
        var carouselItem = document.createElement('div');
        carouselItem.classList.add('carousel-item');
        if (i === 0) carouselItem.classList.add('active');

        var image = document.createElement('img');
        image.src = URL.createObjectURL(files[i]);
        image.classList.add('d-block', 'w-100');
        image.alt = 'Image ' + (i + 1);
        carouselItem.appendChild(image);

        carouselInner.appendChild(carouselItem);
    }
}*/
