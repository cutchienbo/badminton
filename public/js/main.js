document.addEventListener("DOMContentLoaded", function (event) {
    var scrollpos = localStorage.getItem("scrollpos");
    if (scrollpos) window.scrollTo(0, scrollpos);
});

window.onbeforeunload = function (e) {
    localStorage.setItem("scrollpos", window.scrollY);
};

document.querySelector("#image").onchange = function (e) {
    const reader = new FileReader();

    reader.readAsDataURL(e.target.files[0]);

    reader.onload = (e) => {
        document.querySelector(".show-image").src = e.target.result;
    };

    document.querySelector(".show-image").style.border = "2px solid #80bdff";

    document.querySelector(".show-image").style.boxShadow =
        " 0 0 0 0.2rem rgba(0,123,255,.25)";
};
