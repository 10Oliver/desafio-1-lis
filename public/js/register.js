const nationalitySelect = document.getElementById("nationality");
const duiField = document.getElementById("dui");
const documentField = document.getElementById("document");
const countryField = document.getElementById("country_data");
const nextStep = document.getElementById("next-step");
const backStep = document.getElementById("back-step");
const sponsor = document.getElementById("sponsor");

nationalitySelect.addEventListener("change", () => {
    if (nationalitySelect.value == 1) {
        duiField.classList.remove("hide");
        documentField.classList.add("hide");
        countryField.classList.add("hide");
    } else {
        duiField.classList.add("hide");
        documentField.classList.remove("hide");
        countryField.classList.remove("hide");
    }
});

nextStep.addEventListener("click", () => {
    sponsor.classList.add("second-step-sponsor");
});

backStep.addEventListener("click", () => {
    sponsor.classList.remove("second-step-sponsor");
});
