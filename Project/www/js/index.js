const nameInput = document.getElementById("name");
const lastNameInput = document.getElementById("lastName");
const emailInput = document.getElementById("email");
const buttonSubmit = document.getElementById("btn");
const form = document.getElementById("login");
const nameError = document.getElementsByClassName("nameError")[0];
const lastNameError = document.getElementsByClassName("lastNameError")[0];
const emailError = document.getElementsByClassName("emailError")[0];

//define and declare and empty errors object
let error = {};

/* This is a JavaScript event listener. It is a way to listen for an event. In this case, it is
listening for the form to be submitted. */
form.addEventListener("submit", function (e) {
    e.preventDefault();
//function to validate the form fields before submitting
    checkEmpty();
});

// validate empty fields and set error object
function checkEmpty() {
    //loop and remove all key and value fields in the errors object
    for (let key in error) {
        delete error[key];
    }
    //set all in firstname, lastname, email spans to display none
    nameError.style.display = "none";
    lastNameError.style.display = "none";
    emailError.style.display = "none";

    //remove all the error class "border-red-500 classes"
    nameInput.classList.remove("border-red-500");
    lastNameInput.classList.remove("border-red-500");
    emailInput.classList.remove("border-red-500");

//remove white spaces from every input Field
    const nameValue = nameInput.value.trim();
    const lastNameValue = lastNameInput.value.trim();
    const emailValue = emailInput.value.trim();

    //check if all inputs are empty then add new new error keys to the defined error object
    if (nameValue === "") {
        error.name = "Name is required";
    }
    if (lastNameValue === "") {
        error.lastName = "Last Name is required";
    }
    if (emailValue === "") {
        error.email = "Email is required";
    }

    //validate the inputs name and lastName
    if (nameValue !== "") {
        if (!nameValue.match(/^[a-zA-Z0-9]+$/)) {
            error.name = "Name must be letters only";
        }
    }
    if (lastNameValue !== "") {
        if (!lastNameValue.match(/^[a-zA-Z0-9]+$/)) {
            error.lastName = "Last Name must be letters only";
        }
    }
    if (emailValue !== "") {
        //validating an email
        if (!emailValue.match(/^[a-zA-Z0-9.]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/)) {
            error.email = "Email must be a valid email";
        }
    }

    //if we have error add the error to the error message
    if (Object.keys(error).length > 0) {
        displayError();
    } else {
        //submit the form with a delay of 2 seconds
        //change the button innerText to submitting and add no-cursor class and disabled attribute to it
        buttonSubmit.value = "Submitting...";
        buttonSubmit.setAttribute("disabled", "disabled");
    }
}
//display errors respectivey to the span html classes
function displayError() {
    //set all errors to their respectivey and also changing hidden
    //error containers to be a block.
    if (error.name) {
        nameInput.classList.add("border-red-500");
        nameError.style.display = "block";
        nameError.innerHTML = error.name;
    }
    if (error.lastName) {
        lastNameInput.classList.add("border-red-500");
        lastNameError.style.display = "block";
        lastNameError.innerHTML = error.lastName;
    }
    if (error.email) {
        //loop over the classes and add other classes
        emailInput.classList.add("border-red-500");
        emailError.style.display = "block";
        emailError.innerHTML = error.email;
    }
}

