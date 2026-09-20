document.addEventListener('DOMContentLoaded', () => {
  // 1. Logika Tab Metode Pembayaran
  const tabButtons = document.querySelectorAll('.pay-tab-btn');
  const tabContents = document.querySelectorAll('.tab-content');

  tabButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      // Hapus kelas active dari semua tombol dan konten
      tabButtons.forEach(b => b.classList.remove('active'));
      tabContents.forEach(c => c.classList.remove('active'));

      // Tambahkan active ke tombol yang diklik
      btn.classList.add('active');
      const targetTab = btn.getAttribute('data-tab');
      
      const targetContent = document.getElementById('content-' + targetTab);
      if (targetContent) {
        targetContent.classList.add('active');
      }
    });
  });

  // 2. Logika Tombol Salin Nomor Rekening
  const btnCopyRek = document.getElementById('btnCopyRek');
  const rekNumberText = document.getElementById('rekNumberText');

  if (btnCopyRek && rekNumberText) {
    btnCopyRek.addEventListener('click', () => {
      navigator.clipboard.writeText(rekNumberText.textContent.trim()).then(() => {
        alert('Nomor rekening berhasil disalin ke clipboard!');
      }).catch(err => {
        console.error('Gagal menyalin text: ', err);
      });
    });
  }

  // 3. Logika Upload File / Dropzone Simulator
  const dropzoneArea = document.getElementById('dropzoneArea');
  const fileInput = document.getElementById('fileInput');
  const browseFileLink = document.getElementById('browseFileLink');
  const uploadedFileItem = document.getElementById('uploadedFileItem');
  const btnDeleteFile = document.getElementById('btnDeleteFile');
  const fileNameText = document.getElementById('fileNameText');
  const fileSizeText = document.getElementById('fileSizeText');

  if (browseFileLink && fileInput) {
    browseFileLink.addEventListener('click', (e) => {
      e.preventDefault();
      fileInput.click();
    });
  }

  if (fileInput) {
    fileInput.addEventListener('change', (e) => {
      if (e.target.files.length > 0) {
        const file = e.target.files[0];
        fileNameText.textContent = file.name;
        fileSizeText.textContent = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
        uploadedFileItem.style.display = 'flex';
      }
    });
  }

  if (btnDeleteFile && uploadedFileItem) {
    btnDeleteFile.addEventListener('click', () => {
      uploadedFileItem.style.display = 'none';
      if (fileInput) fileInput.value = '';
    });
  }

  // 4. Countdown Timer 5 Jam
  const timerElement = document.getElementById('countdownTimer');
  if (timerElement) {
    let totalSeconds = 4 * 3600 + 59 * 60 + 45; // 04 : 59 : 45

    setInterval(() => {
      if (totalSeconds > 0) {
        totalSeconds--;
        let hours = Math.floor(totalSeconds / 3600);
        let minutes = Math.floor((totalSeconds % 3600) / 60);
        let seconds = totalSeconds % 60;

        timerElement.textContent = 
          String(hours).padStart(2, '0') + ' : ' + 
          String(minutes).padStart(2, '0') + ' : ' + 
          String(seconds).padStart(2, '0');
      }
    }, 1000);
  }

  // 5. Tombol Konfirmasi Selesaikan Pembayaran
  const btnConfirmPayment = document.getElementById('btnConfirmPayment');
  if (btnConfirmPayment) {
    btnConfirmPayment.addEventListener('click', () => {
      alert('Pembayaran berhasil dikonfirmasi! Terima kasih telah berbelanja di Umi Store.');
      // Contoh redirect ke halaman sukses atau beranda:
      // window.location.href = '/beranda';
    });
  }
});