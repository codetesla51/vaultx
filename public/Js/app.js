// Cache DOM elements
const encryptForm = document.getElementById("encrypt");
const decryptForm = document.getElementById("decrypt");
const keyForm = document.getElementById("keyForm");
const showKeys = document.getElementById("keys");
const showFiles = document.getElementById("files");
const tabs = {
    encrypt: document.getElementById("encryptTab"),
    decrypt: document.getElementById("decryptTab"),
    key: document.getElementById("KeyTab")
};

const forms = { encryptForm, decryptForm, keyForm };
const panels = { showFiles, showKeys };

// Helper function to toggle active classes
function toggleActiveTab(activeTab) {
    // Hide all forms and panels
    Object.values(forms).forEach(form => form.classList.remove("active"));
    Object.values(tabs).forEach(tab => tab.classList.remove("active"));
    panels.showFiles.classList.remove("active");
    panels.showKeys.classList.remove("active");

    // Show the selected form and tab
    forms[`${activeTab}Form`].classList.add("active");
    tabs[activeTab].classList.add("active");

    if (activeTab === "key") {
        panels.showKeys.classList.add("active");
    } else {
        panels.showFiles.classList.add("active");
    }

    // Store active tab in localStorage
    localStorage.setItem("activeTab", activeTab);
}

// Tab event listeners
Object.keys(tabs).forEach(tab => {
    tabs[tab].addEventListener("click", () => toggleActiveTab(tab));
});

// Load saved active tab on page load
window.addEventListener("DOMContentLoaded", () => {
    const activeTab = localStorage.getItem("activeTab") || "encrypt";
    toggleActiveTab(activeTab);
});

// Theme handling
function applyTheme(theme) {
    document.body.classList.remove("light-theme", "dark-theme");
    document.body.classList.add(theme);
}

function toggleTheme() {
    const currentTheme = localStorage.getItem("theme") || "light-theme";
    const newTheme = currentTheme === "light-theme" ? "dark-theme" : "light-theme";
    applyTheme(newTheme);
    localStorage.setItem("theme", newTheme);
}

document.addEventListener("DOMContentLoaded", () => {
    const savedTheme = localStorage.getItem("theme") || "light-theme";
    applyTheme(savedTheme);
});

// Key generation
function generateKey() {
    const keyLength = 15;
    const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789#$%^&*+_)(~[{<:>]/|@#$%";
    const apiKey = Array.from({ length: keyLength }, () => chars.charAt(Math.floor(Math.random() * chars.length))).join("");
    
    document.getElementById("key").value = apiKey;
    document.getElementById("nkey").value = apiKey;
}
