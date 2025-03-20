const nationalitySelect = document.getElementById("nationality");
const duiField = document.getElementById("dui");
const documentField = document.getElementById("document");
const countryField = document.getElementById("country_data");
const nextStep = document.getElementById("next-step");
const backStep = document.getElementById("back-step");
const sponsor = document.getElementById("sponsor");
const registerForm = document.getElementById("register-form");
const firstURL = document.getElementById("first");
const secondURL = document.getElementById("second");

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
    duiField.querySelector("input").value = "";
    documentField.querySelector("input").value = "";
    countryField.querySelector("select").selectedIndex = -1;
});

nextStep.addEventListener("click", async () => {
    try {
        const form = new FormData(registerForm);
        const payload = {};
        form.forEach((value, key) => {
            payload[key] = value;
        });
        fetch(firstURL.value, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": registerForm.querySelector(
                    'input[name="_token"]'
                ).value,
            },
            body: JSON.stringify(payload),
        })
            .then((response) => response.json())
            .then((response) => {
                const firstStepInputs = registerForm.querySelectorAll(
                    "#personal-info [name]"
                );
                // Reset validation indicator
                clean(firstStepInputs);
                // All validated, next step
                if (response?.step == 2) {
                    sponsor.classList.add("second-step-sponsor");
                    registerForm.action = response.route;
                    return;
                }
                // Show validation messages
                setError(firstStepInputs, response.errors)
            });
    } catch (error) {
        console.error(error);
    }
});

backStep.addEventListener("click", () => {
    sponsor.classList.remove("second-step-sponsor");
});

registerForm.addEventListener("submit", (e) => {
    try {
        e.preventDefault();
        const form = new FormData(registerForm);
        const payload = {};
        form.forEach((value, key) => {
            payload[key] = value;
        });
        fetch(secondURL.value, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": registerForm.querySelector(
                    'input[name="_token"]'
                ).value,
            },
            body: JSON.stringify(payload),
        })
            .then((response) => response.json())
            .then((response) => {
                const secondStepInputs = registerForm.querySelectorAll(
                    "#contact-info [name]"
                );
                // Reset indicators
                clean(secondStepInputs);
                // All validated
                if (response?.step == 3) {
                    registerForm.action = response.route;
                    registerForm.submit();
                    return;
                }
                // Show validation messages
                setError(secondStepInputs, response.errors);
            });
    } catch (error) {
        console.error(error);
    }
});

const setError = (inputObject, errors) => {
    Object.keys(errors).forEach((key) => {
        const input = Object.values(inputObject).find(
            (field) => field.name == key
        ).parentElement;
        const errorList = document.createElement("ul");
        errorList.classList.add("error-message-list");
        errors[key].forEach((value) => {
            const message = document.createElement("li");
            message.textContent = value;
            message.classList.add("error-message");
            errorList.appendChild(message);
        });
        input.appendChild(errorList);
        // Change border
        const borderItems = input.querySelectorAll("input, select, div");
        Object.values(borderItems).forEach((value) => {
            value.classList.add("error-border");
        });
        input.querySelector("input, select").classList.add("error-shadow");
    });
};

const clean = (inputObject) => {
    Object.values(inputObject).forEach((field) => {
        const list = field.parentElement.querySelector(".error-message-list");
        if (list) {
            list.remove();
        }
        // Clean border
        const parent = field.parentElement;
        const borderItems = parent.querySelectorAll("input, select, div");
        Object.values(borderItems).forEach((value) => {
            value.classList.remove("error-border");
        });
        parent.querySelector("input, select").classList.remove("error-shadow");
    });
};
