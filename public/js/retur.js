document.addEventListener('DOMContentLoaded', function () {

    const productCard =
        document.querySelector('.return-product');

    const subtotalEl =
        document.getElementById('summary-subtotal');

    const totalRefundEl =
        document.getElementById('summary-total-refund');

    const miniListEl =
        document.getElementById('selected-items-mini');

    const agreement =
        document.getElementById('agreement');

    const submitButton =
        document.getElementById('btn-submit-return');

    const description =
        document.getElementById('return-description');

    const descriptionCount =
        document.getElementById('description-count');

    const imageInput =
        document.getElementById('return-images');

    const uploadPreview =
        document.getElementById('upload-preview');

    const reason =
        document.getElementById('return-reason');

    const shippingOptions =
        document.querySelectorAll(
            'input[name="shipping_method"]'
        );


    /* =====================================================
       FORMAT RUPIAH
    ===================================================== */

    function formatRupiah(number) {

        return 'Rp ' + Number(number)
            .toLocaleString('id-ID');

    }


    /* =====================================================
       DATA PRODUK RETUR
    ===================================================== */

    function getReturnProduct() {

        if (!productCard) {
            return null;
        }

        return {
            name:
                productCard.dataset.name ||
                'Produk Umi Store',

            price:
                Number(
                    productCard.dataset.price || 0
                )
        };

    }


    /* =====================================================
       UPDATE SUMMARY
    ===================================================== */

    function updateSummary() {

        const product =
            getReturnProduct();


        if (!product) {

            if (subtotalEl) {
                subtotalEl.textContent =
                    formatRupiah(0);
            }

            if (totalRefundEl) {
                totalRefundEl.textContent =
                    formatRupiah(0);
            }

            if (miniListEl) {
                miniListEl.innerHTML = `
                    <p class="empty-summary">
                        Produk tidak ditemukan.
                    </p>
                `;
            }

            updateSubmitButton();

            return;
        }


        /* SUBTOTAL */

        if (subtotalEl) {

            subtotalEl.textContent =
                formatRupiah(product.price);

        }


        /* TOTAL REFUND */

        if (totalRefundEl) {

            totalRefundEl.textContent =
                formatRupiah(product.price);

        }


        /* MINI SUMMARY */

        if (miniListEl) {

            miniListEl.innerHTML = `
                <div class="summary-item">

                    <span title="${product.name}">
                        ${product.name}
                    </span>

                    <strong>
                        ${formatRupiah(product.price)}
                    </strong>

                </div>
            `;

        }


        updateSubmitButton();

    }


    /* =====================================================
       VALIDASI SUBMIT
    ===================================================== */

    function updateSubmitButton() {

        if (!submitButton) {
            return;
        }


        /*
         * PRODUK HARUS ADA
         */

        const product =
            getReturnProduct();

        const productValid =
            Boolean(product);


        /*
         * ALASAN RETUR
         */

        const reasonValid =
            reason
                ? Boolean(reason.value)
                : false;


        /*
         * DESKRIPSI MINIMAL 15 KARAKTER
         */

        const descriptionValid =
            description
                ? description.value.trim().length >= 15
                : false;


        /*
         * AGREEMENT
         */

        const agreementValid =
            Boolean(
                agreement &&
                agreement.checked
            );


        /*
         * SEMUA VALID
         */

        const isValid =
            productValid &&
            reasonValid &&
            descriptionValid &&
            agreementValid;


        /*
         * BUTTON STATE
         */

        submitButton.disabled =
            !isValid;


        submitButton.classList.toggle(
            'enabled',
            isValid
        );

    }


    /* =====================================================
       ALASAN RETUR
    ===================================================== */

    if (reason) {

        reason.addEventListener(
            'change',
            updateSubmitButton
        );

    }


    /* =====================================================
       DESKRIPSI
    ===================================================== */

    if (description) {

        description.addEventListener(
            'input',
            function () {

                if (descriptionCount) {

                    descriptionCount.textContent =
                        `${description.value.length} / 500`;

                }

                updateSubmitButton();

            }
        );

    }


    /* =====================================================
       AGREEMENT
    ===================================================== */

    if (agreement) {

        agreement.addEventListener(
            'change',
            updateSubmitButton
        );

    }


    /* =====================================================
       SHIPPING METHOD
    ===================================================== */

    function updateShippingState() {

        shippingOptions.forEach(
            function (radio) {

                const wrapper =
                    radio.closest(
                        '.shipping-option'
                    );


                if (wrapper) {

                    wrapper.classList.toggle(
                        'active',
                        radio.checked
                    );

                }

            }
        );

    }


    shippingOptions.forEach(
        function (radio) {

            radio.addEventListener(
                'change',
                updateShippingState
            );

        }
    );


    /* =====================================================
       UPLOAD FOTO
    ===================================================== */

    if (imageInput && uploadPreview) {

        imageInput.addEventListener(
            'change',
            function () {

                const files =
                    Array.from(
                        this.files || []
                    );


                /*
                 * MAKSIMAL 5 FOTO
                 */

                if (files.length > 5) {

                    alert(
                        'Maksimal 5 foto.'
                    );

                    this.value = '';

                    return;

                }


                /*
                 * HAPUS PREVIEW SEBELUMNYA
                 */

                uploadPreview
                    .querySelectorAll(
                        '.upload-preview-item'
                    )
                    .forEach(
                        function (item) {

                            item.remove();

                        }
                    );


                /*
                 * LOOP FILE
                 */

                files.forEach(
                    function (file) {


                        /*
                         * VALIDASI FORMAT
                         */

                        if (
                            !file.type.match(
                                /^image\/(jpeg|png)$/
                            )
                        ) {

                            alert(
                                `${file.name} bukan JPG/PNG yang valid.`
                            );

                            return;

                        }


                        /*
                         * MAKSIMAL 5MB
                         */

                        if (
                            file.size >
                            5 * 1024 * 1024
                        ) {

                            alert(
                                `${file.name} lebih dari 5MB.`
                            );

                            return;

                        }


                        const reader =
                            new FileReader();


                        reader.onload =
                            function (event) {

                                const preview =
                                    document.createElement(
                                        'div'
                                    );


                                preview.className =
                                    'upload-preview-item';


                                const image =
                                    document.createElement(
                                        'img'
                                    );


                                image.src =
                                    event.target.result;


                                image.alt =
                                    'Bukti retur';


                                preview.appendChild(
                                    image
                                );


                                uploadPreview.appendChild(
                                    preview
                                );

                            };


                        reader.readAsDataURL(
                            file
                        );

                    }
                );

            }
        );

    }


    /* =====================================================
       SUBMIT
    ===================================================== */

    if (submitButton) {

        submitButton.addEventListener(
            'click',
            function () {

                if (this.disabled) {
                    return;
                }


                alert(
                    'Pengajuan retur berhasil dikirim. Tim Umi Store akan melakukan verifikasi.'
                );

            }
        );

    }


    /* =====================================================
       INITIAL
    ===================================================== */

    updateShippingState();

    updateSummary();

});