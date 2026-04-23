const loginForm = document.getElementById("loginForm");

if (loginForm) {
    loginForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;

        const errorEl = document.getElementById("error");
        const errorAlert = document.getElementById("errorAlert");
        const submitBtn = document.getElementById("submitBtn");
        const btnSpinner = document.getElementById("btnSpinner");
        const btnText = document.getElementById("btnText");

        if (errorEl) {
            errorEl.textContent = "";
        }
        if (errorAlert) {
            errorAlert.classList.add("hidden");
        }

        if (submitBtn) {
            submitBtn.disabled = true;
        }
        if (btnSpinner) {
            btnSpinner.classList.remove("hidden");
        }
        if (btnText) {
            btnText.textContent = "Connexion en cours...";
        }

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
                if (errorEl) {
                    errorEl.textContent = data.message || "Identifiants invalides";
                }
                if (errorAlert) {
                    errorAlert.classList.remove("hidden");
                }
                return;
            }

            localStorage.setItem("token", data.token);
            localStorage.setItem("user", JSON.stringify(data.user));
            localStorage.setItem("role", data.user.role);

            window.location.href = data.user.role === "admin" ? "/frontend/admin.html" : "/frontend/reviews.html";
        } catch (err) {
            if (errorEl) {
                errorEl.textContent = "Erreur reseau. Verifiez votre connexion.";
            }
            if (errorAlert) {
                errorAlert.classList.remove("hidden");
            }
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
            }
            if (btnSpinner) {
                btnSpinner.classList.add("hidden");
            }
            if (btnText) {
                btnText.textContent = "Se connecter";
            }
        }
    });
}
