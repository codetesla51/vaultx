const encform = document.getElementById("encrypt");
const decform = document.getElementById("decrypt");
const encryptButn = document.getElementById("encBut");
const decryptButn = document.getElementById("decBut");
const loader = document.getElementById("loader");

encryptButn.addEventListener("click", function (e) {
    e.preventDefault();
    const formData = new FormData(encform);
    loader.classList.add("active");

    axios
        .post("/encrypt", formData, {
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content")
            }
        })
        .then(function (response) {
            loader.classList.remove("active");
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "File encrypted successfully.",
                confirmButtonColor: "#008afa"
            }).then(() => {
                window.location.href = "/";
            });
        })
        .catch(function (error) {
            loader.classList.remove("active");
            if (error.response && error.response.status === 422) {
                let errorMessages = "";
                const errors = error.response.data.errors;
                for (const field in errors) {
                    errorMessages += `${errors[field].join(", ")}<br>`;
                }
                Swal.fire({
                    icon: "error",
                    title: "Validation Error",
                    html: errorMessages,
                    confirmButtonColor: "#008afa"
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    confirmButtonColor: "#008afa"
                });
            }
        });
});
decryptButn.addEventListener("click", function (e) {
    e.preventDefault();
    const formData = new FormData(decform);
    loader.classList.add("active");

    axios
        .post("/decrypt", formData, {
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content")
            }
        })
        .then(function (response) {
            loader.classList.remove("active");

            // Show success message
            Swal.fire({
                icon: "success",
                title: "Success",
                text: response.data.success,
                confirmButtonColor: "#008afa"
            }).then(() => {
                // Download file after decryption is successful
                const downloadUrl = response.data.download_url;
                window.location.href = downloadUrl; // Trigger download
            });
        })
        .catch(function (error) {
            loader.classList.remove("active");

            if (error.response && error.response.status === 422) {
                Swal.fire({
                    icon: "error",
                    title: "Decryption Error",
                    text: "Decryption failed. Check your key.",
                    confirmButtonColor: "#008afa"
                });
            } else if (error.response && error.response.status === 404) {
                Swal.fire({
                    icon: "error",
                    title: "File Error",
                    text: "The selected file does not exist.",
                    confirmButtonColor: "#008afa"
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    confirmButtonColor: "#008afa"
                });
            }
        });
});

function deleteFile(fileName) {
    if (confirm("Are you sure you want to delete this file?")) {
        // Perform the Axios DELETE request
        axios
            .delete("/delete/" + fileName, {
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content")
                }
            })
            .then(response => {
                alert(response.data.message);
                // Optionally reload the page or remove the file row from the DOM
                location.reload(); // This will reload the page
            })
            .catch(error => {
                console.error(error);
                if (error.response) {
                    alert(error.response.data.error);
                }
            });
    }
}
function copyShareLink(fileName) {
    const url = `${window.location.origin}/decrypt/${fileName}`;
    navigator.clipboard
        .writeText(url)
        .then(() => {
            alert("Link copied to clipboard: " + url);
        })
        .catch(err => {
            alert("Failed to copy the link");
        });
}
function uploadKey() {
    const key = document.getElementById("nkey").value;
    const token = document.querySelector("input[name=_token]").value;

    if (key.length < 8) {
        Swal.fire("Error", "Key must be at least 8 characters long", "error");
        return;
    }

    axios
        .post("/keys/upload", {
            key: key,
            _token: token
        })
        .then(response => {
            if (response.data.success) {
                Swal.fire("Success", "Key added successfully", "success");
                document.getElementById("nkey").value = "";
                window.location.href = "/";
            } else {
                Swal.fire("Error", response.data.message, "error");
            }
        })
        .catch(error => {
            Swal.fire("Error", "There was a problem adding the key", "error");
        });
}
