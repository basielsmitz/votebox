(function() {

    //Select the hamburger icon and store it into the hamburger variable.
    let hamburger = document.querySelector('#hamburger');

    //When the hamburger icon is clicked, open the navbar.
    hamburger.addEventListener('click', function(){
        let nav = document.querySelector("#mobile-nav");
        nav.classList.remove("is-closed");
        nav.classList.add("is-open");
    })

    let cross = document.querySelector('#cross');

    cross.addEventListener('click', function(){
        let nav = document.querySelector("#mobile-nav");
        nav.classList.remove("is-open");
        nav.classList.add("is-closed");
    })
})();