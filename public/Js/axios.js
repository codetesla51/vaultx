const loginForm = document.getElementById("logInForm");
const loginappButn = document.getElementById("Loginform-butn");
const loader = document.getElementById("loader");
loginappButn.addEventListener("click", function (e) {
    e.preventDefault();

    const formData = new FormData(loginForm);
    loader.classList.add("active");

    axios
        .post("/login", formData, {
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content")
            }
        })
        .then(function (response) {
            loader.classList.remove("active");
            window.location.href = "/";
        })
        .catch(function (error) {
            loader.classList.remove("active");

            if (error.response.status === 422) {
                let errorMessages = "";
                const errors = error.response.data.errors;

                for (const field in errors) {
                    if (Array.isArray(errors[field])) {
                        // If it's an array, join the messages
                        errorMessages += `${errors[field].join(", ")}<br>`;
                    } else {
                        errorMessages += `${errors[field]}<br>`;
                    }
                }

                Swal.fire({
                    icon: "error",
                    title: "Validation Error",
                    allowOutsideClick: true,
                    confirmButtonColor: "#008afa",
                    confirmButtonText: "Try Again",
                    background: "#f0f0f0",
                    html: errorMessages
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    allowOutsideClick: true,
                    confirmButtonColor: "#008afa",
                    confirmButtonText: "Try Again",
                    background: "#f0f0f0",
                    text: "Something went wrong!"
                });
            }
        });
});

// const passwordInput = document.getElementById("password-input");
// const togglePasswordButton = document.getElementById("toggle-password");

// togglePasswordButton.addEventListener("click", function () {
//     const isPassword = passwordInput.type === "password";
//     passwordInput.type = isPassword ? "text" : "password";
//     if (isPassword) {
//         togglePasswordButton.classList.add("active");
//     } else {
//         togglePasswordButton.classList.remove("active");
//     }
// });
