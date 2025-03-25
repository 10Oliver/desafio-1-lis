const recuperationSwitch = document.getElementById("recuperation-code");
const authenticationField = document.getElementById("authentication-field");
const recuperationField = document.getElementById("recuperation-field");

recuperationSwitch.addEventListener("change", (e) => {
    if (e.target.checked) {
        recuperationField.style.opacity = 1;
        recuperationField.style.zIndex = 3;
        authenticationField.style.opacity = 0;
        authenticationField.style.zIndex = 0;
    } else {
        recuperationField.style.opacity = 0;
        recuperationField.style.zIndex = 1;
        authenticationField.style.opacity = 1;
        authenticationField.style.zIndex = 3;
    }
});