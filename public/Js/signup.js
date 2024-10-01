const signupForm = document.getElementById("signUpForm");
const appButn = document.getElementById("form-butn");
const loader = document.getElementById("loader");
appButn.addEventListener("click", function (e) {
    e.preventDefault();

    const formData = new FormData(signupForm);
    loader.classList.add("active");

    axios
        .post("/signup", formData, {
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content")
            }
        })
        .then(function (response) {
            loader.classList.remove("active");
            window.location.href = "/login";
        })
        .catch(function (error) {
            if (error.response.status === 422) {
                loader.classList.remove("active");
                let errorMessages = "";
                const errors = error.response.data.errors;

                for (const field in errors) {
                    errorMessages += `${errors[field].join(", ")}<br>`;
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
                loader.classList.remove("active");
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
