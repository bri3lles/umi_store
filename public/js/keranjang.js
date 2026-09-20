document.addEventListener('DOMContentLoaded', () => {
  const selectAllCheckbox = document.getElementById('selectAll');
  const selectAllCount = document.getElementById('selectAllCount');
  const itemCheckboxes = document.querySelectorAll('.item-checkbox');
  const btnDeleteSelected = document.querySelector('.btn-delete-selected');
  
  // Elemen Ringkasan Pesanan
  const summaryItemBadge = document.querySelector('.summary-card .summary-item-badge');
  const totalPriceText = document.querySelector('.total-price');

  // Format Rupiah
  function formatRupiah(number) {
    return 'Rp ' + number.toLocaleString('id-ID');
  }

  // Fungsi Kalkulasi Ulang Harga & Ringkasan
  function updateCartSummary() {
    const cartItems = document.querySelectorAll('.cart-item-card:not(.out-of-stock)');
    let totalCheckedCount = 0;
    let calculatedSubtotal = 0;
    const totalActiveItems = cartItems.length;

    cartItems.forEach(card => {
      const checkbox = card.querySelector('.item-checkbox');
      const qtyNumber = card.querySelector('.qty-number');
      const unitPriceEl = card.querySelector('.cart-item-unit-price');
      const itemTotalPriceEl = card.querySelector('.cart-item-total-price');

      const unitPriceText = unitPriceEl ? unitPriceEl.textContent.replace(/[^0-9]/g, '') : '0';
      const unitPrice = parseInt(unitPriceText) || 0;
      const qty = parseInt(qtyNumber ? qtyNumber.textContent : 1) || 1;

      const itemTotal = unitPrice * qty;
      if (itemTotalPriceEl) {
        itemTotalPriceEl.textContent = formatRupiah(itemTotal);
      }

      if (checkbox && checkbox.checked) {
        totalCheckedCount++;
        calculatedSubtotal += itemTotal;
      }
    });

    if (selectAllCount) {
      selectAllCount.textContent = totalCheckedCount;
    }

    if (selectAllCheckbox) {
      selectAllCheckbox.checked = (totalCheckedCount === totalActiveItems && totalActiveItems > 0);
    }

    if (summaryItemBadge) {
      summaryItemBadge.textContent = totalCheckedCount + ' Item';
    }

    const priceRows = document.querySelectorAll('.summary-card .price-row');
    priceRows.forEach(row => {
      const rowText = row.querySelector('span:first-child').textContent;
      if (rowText.includes('Subtotal Produk')) {
        row.querySelector('span:last-child').textContent = formatRupiah(calculatedSubtotal);
      }
    });

    if (totalPriceText) {
      totalPriceText.textContent = formatRupiah(calculatedSubtotal);
    }
  }

  // Variabel untuk menyimpan target yang akan dihapus (bisa berupa single card atau 'selected')
  let targetDeleteAction = null; 
  const deleteConfirmModal = document.getElementById('deleteConfirmModal');
  const btnCloseDeleteModal = document.getElementById('btnCloseDeleteModal');
  const btnConfirmDelete = document.getElementById('btnConfirmDelete');

  function openDeleteModal(actionCallback) {
    targetDeleteAction = actionCallback;
    if (deleteConfirmModal) {
      deleteConfirmModal.style.display = 'flex';
    }
  }

  function closeDeleteModalFunc() {
    if (deleteConfirmModal) {
      deleteConfirmModal.style.display = 'none';
    }
    targetDeleteAction = null;
  }

  if (btnCloseDeleteModal) {
    btnCloseDeleteModal.addEventListener('click', closeDeleteModalFunc);
  }

  if (btnConfirmDelete) {
    btnConfirmDelete.addEventListener('click', () => {
      if (typeof targetDeleteAction === 'function') {
        targetDeleteAction();
      }
      closeDeleteModalFunc();
    });
  }

  // Logika Tombol Plus, Minus, Checkbox Satuan, dan Hapus per Item
  const cartItemsList = document.querySelectorAll('.cart-item-card');
  cartItemsList.forEach(card => {
    const minusBtn = card.querySelector('.qty-btn:first-child');
    const plusBtn = card.querySelector('.qty-btn:last-child');
    const qtyNumber = card.querySelector('.qty-number');
    const checkbox = card.querySelector('.item-checkbox');
    const deleteBtn = card.querySelector('.btn-delete');

    if (minusBtn && plusBtn && qtyNumber) {
      let count = parseInt(qtyNumber.textContent) || 1;

      minusBtn.addEventListener('click', () => {
        if (count > 1) {
          count--;
          qtyNumber.textContent = count;
          updateCartSummary();
        }
      });

      plusBtn.addEventListener('click', () => {
        count++;
        qtyNumber.textContent = count;
        updateCartSummary();
      });
    }

    if (checkbox) {
      checkbox.addEventListener('change', () => {
        updateCartSummary();
      });
    }

    // Mengganti confirm() bawaan browser dengan Modal Kustom
    if (deleteBtn) {
      deleteBtn.addEventListener('click', () => {
        openDeleteModal(() => {
          card.remove();
          updateCartSummary();
        });
      });
    }
  });

  // Logika "Pilih Semua" Master Checkbox
  if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener('change', (e) => {
      const isChecked = e.target.checked;
      document.querySelectorAll('.item-checkbox').forEach(cb => {
        cb.checked = isChecked;
      });
      updateCartSummary();
    });
  }

  // Logika Tombol "Hapus Terpilih" dengan Modal Kustom
  if (btnDeleteSelected) {
    btnDeleteSelected.addEventListener('click', () => {
      const checkedItems = document.querySelectorAll('.cart-item-card:not(.out-of-stock)');
      let hasChecked = false;

      checkedItems.forEach(card => {
        const checkbox = card.querySelector('.item-checkbox');
        if (checkbox && checkbox.checked) {
          hasChecked = true;
        }
      });

      if (!hasChecked) {
        alert('Pilih minimal satu produk yang ingin dihapus.');
        return;
      }

      openDeleteModal(() => {
        checkedItems.forEach(card => {
          const checkbox = card.querySelector('.item-checkbox');
          if (checkbox && checkbox.checked) {
            card.remove();
          }
        });
        updateCartSummary();
      });
    });
  }

  // Jalankan kalkulasi pertama kali saat halaman dimuat
  updateCartSummary();

  // Logika Modal / Navigasi Pembayaran & Pengiriman
  const btnOpenPopup = document.getElementById('btnOpenPopup');
  const shippingModal = document.getElementById('shippingModal');
  const btnCloseModal = document.getElementById('btnCloseModal');
  const btnSubmitShipping = document.getElementById('btnSubmitShipping');
  
  const modalOptDiantar = document.getElementById('modalOptDiantar');
  const modalOptAmbil = document.getElementById('modalOptAmbil');
  const radioDiantar = modalOptDiantar ? modalOptDiantar.querySelector('input[type="radio"]') : null;
  const radioAmbil = modalOptAmbil ? modalOptAmbil.querySelector('input[type="radio"]') : null;

  if (btnOpenPopup && shippingModal) {
    btnOpenPopup.addEventListener('click', () => {
      shippingModal.style.display = 'flex';
    });
  }

  function closeModalFunc() {
    if (shippingModal) shippingModal.style.display = 'none';
  }

  if (btnCloseModal) {
    btnCloseModal.addEventListener('click', closeModalFunc);
  }

  window.addEventListener('click', (e) => {
    if (e.target === shippingModal) {
      closeModalFunc();
    }
    if (e.target === deleteConfirmModal) {
      closeDeleteModalFunc();
    }
  });

  if (modalOptDiantar && modalOptAmbil && radioDiantar && radioAmbil) {
    modalOptDiantar.addEventListener('click', () => {
      modalOptDiantar.classList.add('selected');
      modalOptAmbil.classList.remove('selected');
      radioDiantar.checked = true;
    });

    modalOptAmbil.addEventListener('click', () => {
      modalOptAmbil.classList.add('selected');
      modalOptDiantar.classList.remove('selected');
      radioAmbil.checked = true;
    });
  }

  // Tombol Submit Pengiriman (Alert "Ambil di Toko" dihapus, diarahkan sesuai pilihan)
  if (btnSubmitShipping && radioDiantar && radioAmbil) {
    btnSubmitShipping.addEventListener('click', () => {
      if (radioDiantar.checked) {
        window.location.href = window.routeDiantar;
      } else if (radioAmbil.checked) {
        // Jika Anda memiliki route khusus ambil di toko, arahkan ke sana (misal: window.routeAmbil)
        // Atau biarkan mengarah ke halaman pembayaran umum
        window.location.href = window.routePembayaran; 
      }
    });
  }
});