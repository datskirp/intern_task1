class FormValidator {
    constructor(form, fields) {
        this.form = form
        this.fields = fields
    }

    initialize() {
        this.validateOnEntry()
        this.validateOnSubmit()
    }

    validateOnSubmit() {
        let self = this

        this.form.addEventListener("submit", event => {
            event.preventDefault()
            self.fields.forEach((field) => {
                const input = document.querySelector(`#${field}`)
                self.validateFields(input)
            })
        })
    }

    validateOnEntry() {
        let self = this
        this.fields.forEach((field) => {
            const input = document.querySelector(`#${field}`)

            input.addEventListener("input", () => {
                self.validateFields(input)
            })
        })
    }

    validateFields(field) {
        // Check presence of values
        if (field.value.trim() === "") {
            this.setStatus(field, `${field.previousElementSibling.innerText} cannot be blank`, "error")
        } else {
            this.setStatus(field, null, "success")
        }

        // check for a valid email address
        if (field.type === "email") {

            const re = /\S+@\S+\.\S+/

            if (!field.validity.typeMismatch) {
                this.setStatus(field, null, "success")
            } else {
                this.setStatus(field, "Please enter valid email address", "error")
            }
        }


    }

    setStatus(field, message, status) {

        const errorMessage = field.parentElement.querySelector(".error")


        if (status === "success") {

            if (errorMessage) {
                errorMessage.innerText = ""
            }
            field.classList.remove("border-red-500")
        }

        if (status === "error") {

            field.parentElement.querySelector(".error").innerText = message
            field.classList.add("border-red-500")
        }
    }
}

const form = document.getElementById("addUser")
const fields = ["email", "name"]

const validator = new FormValidator(form, fields)
validator.initialize()