document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('previewModal');
  const openBtn = document.getElementById('openModalBtn');
  const closeBtn = document.getElementById('closeModalBtn');

  if (openBtn && modal) {
    openBtn.addEventListener('click', () => {
      modal.style.display = 'flex';
    });
  }

  if (closeBtn && modal) {
    closeBtn.addEventListener('click', () => {
      modal.style.display = 'none';
    });
  }

  window.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.style.display = 'none';
    }
  });
});

function goToHistory() {
  alert("Mengarahkan ke halaman Riwayat Pesanan...");
  // Contoh route Laravel: window.location.href = "{{ route('riwayat') }}";
}