document.getElementById("registerForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const name                  = document.getElementById("name").value.trim();
    const email                 = document.getElementById("email").value.trim();
    const password              = document.getElementById("password").value;
    const password_confirmation = document.getElementById("password_confirmation").value;

    const errorEl    = document.getElementById("error");
    const errorAlert = document.getElementById("errorAlert");
    const submitBtn  = document.getElementById("submitBtn");
    const btnSpinner = document.getElementById("btnSpinner");
    const btnText    = document.getElementById("btnText");

    // Validation locale rapide
    errorEl.textContent = "";
    errorAlert.classList.add("hidden");

    if (password !== password_confirmation) {
        errorEl.textContent = "Les mots de passe ne correspondent pas.";
        errorAlert.classList.remove("hidden");
        return;
    }

    // État de chargement
    submitBtn.disabled = true;
    btnSpinner.classList.remove("hidden");
    btnText.textContent = "Création en cours…";

    try {
        const response = await fetch("/api/register", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
            body: JSON.stringify({ name, email, password, password_confirmation }),
        });

        const data = await response.json();

        if (!response.ok) {
            // Laravel renvoie parfois les erreurs dans data.errors
            const firstError = data.errors
                ? Object.values(data.errors).flat()[0]
                : data.message || "Erreur lors de l'inscription.";
            errorEl.textContent = firstError;
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
        btnText.textContent = "Créer mon compte";
    }
});
