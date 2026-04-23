const registerForm = document.getElementById("registerForm");

if (registerForm) {
    registerForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const passwordConfirmation = document.getElementById("password_confirmation").value;

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

        if (password !== passwordConfirmation) {
            if (errorEl) {
                errorEl.textContent = "Les mots de passe ne correspondent pas.";
            }
            if (errorAlert) {
                errorAlert.classList.remove("hidden");
            }
            return;
        }

        if (submitBtn) {
            submitBtn.disabled = true;
        }
        if (btnSpinner) {
            btnSpinner.classList.remove("hidden");
        }
        if (btnText) {
            btnText.textContent = "Creation en cours...";
        }

        try {
            const response = await fetch("/api/register", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
                body: JSON.stringify({
                    name,
                    email,
                    password,
                    password_confirmation: passwordConfirmation,
                }),
            });

            const data = await response.json();

            if (!response.ok) {
                const firstError = data.errors
                    ? Object.values(data.errors).flat()[0]
                    : data.message || "Erreur lors de l'inscription.";

                if (errorEl) {
                    errorEl.textContent = firstError;
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
                btnText.textContent = "Creer mon compte";
            }
        }
    });
}
