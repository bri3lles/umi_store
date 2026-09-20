document.addEventListener("DOMContentLoaded", () => {

    /* =====================================================
       PASSWORD SHOW / HIDE
       ===================================================== */

    const passwordButtons = document.querySelectorAll(
        "[data-password-toggle]"
    );

    passwordButtons.forEach((button) => {

        button.addEventListener("click", () => {

            const targetId = button.dataset.target;
            const input = document.getElementById(targetId);

            if (!input) return;

            const icon = button.querySelector(
                ".material-symbols-outlined"
            );

            if (input.type === "password") {

                input.type = "text";

                if (icon) {
                    icon.textContent = "visibility_off";
                }

            } else {

                input.type = "password";

                if (icon) {
                    icon.textContent = "visibility";
                }

            }

        });

    });


    /* =====================================================
       PASSWORD STRENGTH
       ===================================================== */

    const newPassword = document.getElementById("new_password");
    const strengthBars = document.querySelectorAll(
        ".strength-bars span"
    );
    const strengthLabel = document.getElementById("strengthLabel");

    function updatePasswordStrength() {

        if (!newPassword || !strengthLabel) return;

        const password = newPassword.value;

        let strength = 0;

        if (password.length >= 6) {
            strength++;
        }

        if (password.length >= 8) {
            strength++;
        }

        if (/[A-Z]/.test(password)) {
            strength++;
        }

        if (/[0-9!@#$%^&*]/.test(password)) {
            strength++;
        }


        strengthBars.forEach((bar, index) => {

            bar.classList.toggle(
                "is-active",
                index < strength
            );

        });


        if (password.length === 0) {

            strengthLabel.textContent = "Belum diisi";

        } else if (strength <= 1) {

            strengthLabel.textContent = "Lemah";

        } else if (strength === 2) {

            strengthLabel.textContent = "Sedang";

        } else if (strength === 3) {

            strengthLabel.textContent = "Baik";

        } else {

            strengthLabel.textContent = "Kuat";

        }

    }

    if (newPassword) {
        newPassword.addEventListener(
            "input",
            updatePasswordStrength
        );
    }


    /* =====================================================
       MODAL ALAMAT
       ===================================================== */

    const modal = document.getElementById("addressModal");

    const openButtons = document.querySelectorAll(
        "[data-open-address-modal]"
    );

    const closeButtons = document.querySelectorAll(
        "[data-close-address-modal]"
    );


    function openModal() {

        if (!modal) return;

        modal.classList.add("is-open");
        modal.setAttribute("aria-hidden", "false");

        document.body.classList.add("modal-open");
    }


    function closeModal() {

        if (!modal) return;

        modal.classList.remove("is-open");
        modal.setAttribute("aria-hidden", "true");

        document.body.classList.remove("modal-open");
    }


    openButtons.forEach((button) => {

        button.addEventListener("click", openModal);

    });


    closeButtons.forEach((button) => {

        button.addEventListener("click", closeModal);

    });


    if (modal) {

        modal.addEventListener("click", (event) => {

            if (event.target === modal) {
                closeModal();
            }

        });

    }


    document.addEventListener("keydown", (event) => {

        if (
            event.key === "Escape" &&
            modal &&
            modal.classList.contains("is-open")
        ) {
            closeModal();
        }

    });


    /* =====================================================
       KATEGORI ALAMAT
       ===================================================== */

    const categoryButtons = document.querySelectorAll(
        "[data-address-category]"
    );

    categoryButtons.forEach((button) => {

        button.addEventListener("click", () => {

            categoryButtons.forEach((item) => {
                item.classList.remove("is-active");
            });

            button.classList.add("is-active");

        });

    });


    /* =====================================================
       FORM ALAMAT
       ===================================================== */

    const addressForm = document.querySelector(
        "[data-address-form]"
    );

    if (addressForm) {

        addressForm.addEventListener("submit", (event) => {

            event.preventDefault();

            closeModal();

        });

    }


    /* =====================================================
       FOTO PROFIL
       ===================================================== */

    const photoInput = document.getElementById(
        "profilePhotoInput"
    );

    const photoPreview = document.getElementById(
        "profilePreview"
    );

    const uploadButtons = document.querySelectorAll(
        "[data-photo-upload]"
    );

    const deleteButton = document.querySelector(
        "[data-photo-delete]"
    );


    const originalPhoto =
        photoPreview?.getAttribute("src");


    uploadButtons.forEach((button) => {

        button.addEventListener("click", () => {

            if (photoInput) {
                photoInput.click();
            }

        });

    });


    if (photoInput) {

        photoInput.addEventListener("change", () => {

            const file = photoInput.files[0];

            if (!file || !photoPreview) return;


            if (!file.type.startsWith("image/")) {

                alert("File harus berupa gambar.");

                photoInput.value = "";

                return;

            }


            if (file.size > 2 * 1024 * 1024) {

                alert(
                    "Ukuran foto maksimal 2 MB."
                );

                photoInput.value = "";

                return;

            }


            const reader = new FileReader();

            reader.onload = (event) => {

                photoPreview.src =
                    event.target.result;

            };

            reader.readAsDataURL(file);

        });

    }


    if (deleteButton) {

        deleteButton.addEventListener("click", () => {

            if (photoPreview && originalPhoto) {

                photoPreview.src = originalPhoto;

            }

            if (photoInput) {
                photoInput.value = "";
            }

        });

    }


    /* =====================================================
       DEMO SAVE BUTTON
       ===================================================== */

    const saveProfileButton = document.querySelector(
        "[data-save-profile]"
    );

    if (saveProfileButton) {

        saveProfileButton.addEventListener(
            "click",
            () => {

                alert(
                    "Perubahan profil siap disimpan."
                );

            }
        );

    }


    const savePasswordButton = document.querySelector(
        "[data-save-password]"
    );

    if (savePasswordButton) {

        savePasswordButton.addEventListener(
            "click",
            () => {

                alert(
                    "Password siap diperbarui."
                );

            }
        );

    }

});

document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       MODAL HELPERS
       ===================================================== */

    function openModal(modal) {
        if (!modal) return;

        modal.classList.add("is-open");
        modal.setAttribute("aria-hidden", "false");

        document.body.style.overflow = "hidden";
    }


    function closeModal(modal) {
        if (!modal) return;

        modal.classList.remove("is-open");
        modal.setAttribute("aria-hidden", "true");

        if (!document.querySelector(".account-modal-overlay.is-open, .address-modal-overlay.is-open")) {
            document.body.style.overflow = "";
        }
    }


    /* =====================================================
       UBAH PASSWORD
       ===================================================== */

    const passwordModal = document.getElementById("passwordModal");

    document.querySelectorAll("[data-open-password-modal]")
        .forEach(button => {

            button.addEventListener("click", function () {
                openModal(passwordModal);
            });

        });


    /* =====================================================
       UBAH EMAIL
       ===================================================== */

    const emailModal = document.getElementById("emailModal");

    document.querySelectorAll("[data-open-email-modal]")
        .forEach(button => {

            button.addEventListener("click", function () {
                openModal(emailModal);
            });

        });


    /* =====================================================
       UBAH NOMOR TELEPON
       ===================================================== */

    const phoneModal = document.getElementById("phoneModal");

    document.querySelectorAll("[data-open-phone-modal]")
        .forEach(button => {

            button.addEventListener("click", function () {
                openModal(phoneModal);
            });

        });


    /* =====================================================
       CLOSE ACCOUNT MODALS
       ===================================================== */

    document.querySelectorAll("[data-close-account-modal]")
        .forEach(button => {

            button.addEventListener("click", function () {

                const modal = this.closest(".account-modal-overlay");

                closeModal(modal);

            });

        });


    /* =====================================================
       CLOSE SAAT KLIK BACKDROP
       ===================================================== */

    document.querySelectorAll(".account-modal-overlay")
        .forEach(overlay => {

            overlay.addEventListener("click", function (event) {

                if (event.target === overlay) {
                    closeModal(overlay);
                }

            });

        });


    /* =====================================================
       ESCAPE
       ===================================================== */

    document.addEventListener("keydown", function (event) {

        if (event.key !== "Escape") return;

        const openedModal = document.querySelector(
            ".account-modal-overlay.is-open"
        );

        if (openedModal) {
            closeModal(openedModal);
        }

    });


    /* =====================================================
       PASSWORD FORM
       ===================================================== */

    const passwordForm = document.querySelector("[data-password-form]");

    if (passwordForm) {

        passwordForm.addEventListener("submit", function (event) {

            event.preventDefault();

            const currentPassword =
                document.getElementById("modal_current_password")?.value.trim();

            const newPassword =
                document.getElementById("modal_new_password")?.value.trim();

            const confirmation =
                document.getElementById("modal_password_confirmation")?.value.trim();


            if (!currentPassword || !newPassword || !confirmation) {
                alert("Semua kolom kata sandi wajib diisi.");
                return;
            }


            if (newPassword.length < 8) {
                alert("Kata sandi baru minimal 8 karakter.");
                return;
            }


            if (newPassword !== confirmation) {
                alert("Konfirmasi kata sandi tidak cocok.");
                return;
            }


            alert("Kata sandi berhasil diperbarui.");

            passwordForm.reset();

            closeModal(passwordModal);

        });

    }


    /* =====================================================
       EMAIL FORM
       ===================================================== */

    const emailForm = document.querySelector("#emailModal form");

    if (emailForm) {

        emailForm.addEventListener("submit", function (event) {

            event.preventDefault();

            const email =
                document.getElementById("new_email")?.value.trim();

            if (!email) {
                alert("Silakan masukkan email baru.");
                return;
            }

            alert("Permintaan perubahan email berhasil disimpan.");

            closeModal(emailModal);

        });

    }


    /* =====================================================
       PHONE FORM
       ===================================================== */

    const phoneForm = document.querySelector("#phoneModal form");

    if (phoneForm) {

        phoneForm.addEventListener("submit", function (event) {

            event.preventDefault();

            const phone =
                document.getElementById("new_phone")?.value.trim();

            if (!phone) {
                alert("Silakan masukkan nomor telepon baru.");
                return;
            }

            alert("Permintaan perubahan nomor telepon berhasil disimpan.");

            closeModal(phoneModal);

        });

    }

});
