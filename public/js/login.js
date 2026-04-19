document.getElementById("loginForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const email    = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;

    const errorEl    = document.getElementById("error");
    const errorAlert = document.getElementById("errorAlert");
    const submitBtn  = document.getElementById("submitBtn");
    const btnSpinner = document.getElementById("btnSpinner");
    const btnText    = document.getElementById("btnText");

    // Reset erreur
    errorEl.textContent = "";
    errorAlert.classList.add("hidden");

    // État de chargement
    submitBtn.disabled = true;
    btnSpinner.classList.remove("hidden");
    btnText.textContent = "Connexion en cours…";

    try {
        const response = await fetch("/api/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
            body: JSON.stringify({ email, password }),
        });

        const data = await response.json();

        if (!response.ok) {
            errorEl.textContent = data.message || "Identifiants invalides";
            errorAlert.classList.remove("hidden");
            return;
        }

        localStorage.setItem("token", data.token);
        localStorage.setItem("user", JSON.stringify(data.user));
        localStorage.setItem("role", data.user.role);

        window.location.href = "/frontend/reviews.html";
    } catch (err) {
        errorEl.textContent = "Erreur réseau. Vérifiez votre connexion.";
        errorAlert.classList.remove("hidden");
    } finally {
        submitBtn.disabled = false;
        btnSpinner.classList.add("hidden");
        btnText.textContent = "Se connecter";
    }
});
