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
        duiField.querySelector("input").required = true;
        documentField.classList.add("hide");
        countryField.classList.add("hide");
        documentField.querySelector("input").required = false;
        countryField.querySelector("select").required = false;
    } else {
        duiField.classList.add("hide");
        duiField.querySelector("input").required = false;
        documentField.classList.remove("hide");
        countryField.classList.remove("hide");
        documentField.querySelector("input").required = true;
        countryField.querySelector("select").required = true;
    }
});

nextStep.addEventListener("click", () => {
    const personalInfoRequired = document.querySelectorAll(
        "#personal-info [required]"
    );

    let valid = true;

    personalInfoRequired.forEach((field) => {
        if (field.value.trim() === "") {
            valid = false;
            field.classList.add("error");
        } else {
            field.classList.remove("error");
        }
    });
    if (!valid) {
        alert("Existen campos vacíos");
        return;
    }
    sponsor.classList.add("second-step-sponsor");
});

backStep.addEventListener("click", () => {
    sponsor.classList.remove("second-step-sponsor");
});
