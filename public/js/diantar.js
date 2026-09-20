document.addEventListener("DOMContentLoaded", () => {
  // DATA WILAYAH BERJENJANG INDONESIA
  const wilayahIndonesia = {
    "Jawa Timur": {
      "Kota Surabaya": ["Mulyorejo", "Surabaya Pusat", "Gubeng", "Rungkut", "Darmo"],
      "Kab. Sidoarjo": ["Sidoarjo Kota", "Waru", "Buduran", "Candi"],
      "Kota Malang": ["Klojen", "Blimbing", "Lowokwaru"]
    },
    "DKI Jakarta": {
      "Kota Jakarta Selatan": ["Kebayoran Baru", "Mampang Prapatan", "Cilandak", "Setiabudi"],
      "Kota Jakarta Pusat": ["Menteng", "Tanah Abang", "Gambir"],
      "Kota Jakarta Barat": ["Kebon Jeruk", "Palmerah", "Cengkareng"]
    },
    "Jawa Barat": {
      "Kota Bandung": ["Coblong", "Dago", "Cicendo", "Antapani"],
      "Kab. Bekasi": ["Cikarang Utara", "Cikarang Pusat", "Tambun Selatan"],
      "Kota Bogor": ["Bogor Selatan", "Bogor Timur", "Tanah Sareal"]
    },
    "Sumatera Selatan": {
      "Kota Palembang": ["Ilir Barat I", "Ilir Timur II", "Kertapati", "Plaju"],
      "Kab. Banyuasin": ["Banyuasin III", "Talang Kelapa"],
      "Kab. Ogan Ilir": ["Indralaya", "Muara Kuang"]
    }
  };

  let daftarAlamat = [
    {
      id: 1,
      name: "Dimas Satria",
      phone: "+62 812-3456-7890",
      address: "Jl. Dharmahusada Indah Timur No. 42, Mulyorejo, Kota Surabaya, Jawa Timur 60115",
      note: "Titipkan di pos satpam bila rumah kosong",
      isPrimary: true
    },
    {
      id: 2,
      name: "Dimas Satria (Kantor)",
      phone: "+62 812-9876-5432",
      address: "Gedung Cyber Lt. 3, Jl. Kuningan Barat II, Mampang Prapatan, Jakarta Selatan, DKI Jakarta 12710",
      note: "Serahkan ke resepsionis lobi utama",
      isPrimary: false
    }
  ];

  let activeAddressIndex = 0;

  const selectProvinsi = document.getElementById('selectNewProvinsi');
  const selectKota = document.getElementById('selectNewKota');
  const selectKecamatan = document.getElementById('selectNewKecamatan');
  const inputPostal = document.getElementById('inputNewPostal');

  // Inisialisasi Pilihan Provinsi
  function initProvinsi() {
    if (!selectProvinsi) return;
    selectProvinsi.innerHTML = '<option value="">Pilih Provinsi</option>';
    for (let prov in wilayahIndonesia) {
      let opt = document.createElement('option');
      opt.value = prov;
      opt.textContent = prov;
      selectProvinsi.appendChild(opt);
    }
  }
  initProvinsi();

  // Event saat Provinsi dipilih
  if (selectProvinsi) {
    selectProvinsi.addEventListener('change', function() {
      const selectedProv = this.value;
      selectKota.innerHTML = '<option value="">Pilih Kota / Kabupaten</option>';
      selectKecamatan.innerHTML = '<option value="">Pilih Kota/Kabupaten Dahulu</option>';
      selectKecamatan.disabled = true;
      inputPostal.value = '';

      if (selectedProv && wilayahIndonesia[selectedProv]) {
        selectKota.disabled = false;
        for (let kota in wilayahIndonesia[selectedProv]) {
          let opt = document.createElement('option');
          opt.value = kota;
          opt.textContent = kota;
          selectKota.appendChild(opt);
        }
      } else {
        selectKota.disabled = true;
      }
    });
  }

  // Event saat Kota/Kabupaten dipilih
  if (selectKota) {
    selectKota.addEventListener('change', function() {
      const selectedProv = selectProvinsi.value;
      const selectedKota = this.value;
      selectKecamatan.innerHTML = '<option value="">Pilih Kecamatan</option>';

      if (selectedKota && wilayahIndonesia[selectedProv][selectedKota]) {
        selectKecamatan.disabled = false;
        wilayahIndonesia[selectedProv][selectedKota].forEach(kec => {
          let opt = document.createElement('option');
          opt.value = kec;
          opt.textContent = kec;
          selectKecamatan.appendChild(opt);
        });

        // Set kode pos otomatis
        if (selectedKota.includes('Surabaya')) inputPostal.value = '60115';
        else if (selectedKota.includes('Jakarta Selatan')) inputPostal.value = '12190';
        else if (selectedKota.includes('Bandung')) inputPostal.value = '40111';
        else if (selectedKota.includes('Palembang')) inputPostal.value = '30139';
        else inputPostal.value = '12000';
      } else {
        selectKecamatan.disabled = true;
        inputPostal.value = '';
      }
    });
  }

  function renderActiveAddress() {
    const active = daftarAlamat[activeAddressIndex];
    if (!active) return;
    document.getElementById('displayRecipient').textContent = `${active.name} (${active.phone})`;
    document.getElementById('displayAddressText').textContent = active.address;
    
    const badge = document.getElementById('displayBadge');
    if (active.isPrimary) {
      badge.style.display = 'inline-block';
      badge.textContent = 'Alamat Utama';
    } else {
      badge.style.display = 'none';
    }

    const noteBox = document.getElementById('displayNoteBox');
    if (active.note && active.note.trim() !== '') {
      noteBox.style.display = 'flex';
      document.getElementById('displayNoteText').textContent = `Catatan Pengirim: "${active.note}"`;
    } else {
      noteBox.style.display = 'none';
    }
  }

  // Accordion Tambah Alamat
  const toggleAddAddress = document.getElementById('toggleAddAddress');
  const formAddAddress = document.getElementById('formAddAddress');
  const chevronIcon = document.getElementById('chevronIcon');

  if (toggleAddAddress) {
    toggleAddAddress.addEventListener('click', () => {
      if (formAddAddress.style.display === 'block') {
        formAddAddress.style.display = 'none';
        chevronIcon.className = 'fa-solid fa-chevron-down';
      } else {
        formAddAddress.style.display = 'block';
        chevronIcon.className = 'fa-solid fa-chevron-up';
      }
    });
  }

  // Simpan Alamat Baru
  const btnSaveNewAddress = document.getElementById('btnSaveNewAddress');
  if (btnSaveNewAddress) {
    btnSaveNewAddress.addEventListener('click', () => {
      const name = document.getElementById('inputNewName').value;
      const phone = document.getElementById('inputNewPhone').value;
      const prov = selectProvinsi.value;
      const kota = selectKota.value;
      const kec = selectKecamatan.value;
      const postal = inputPostal.value;
      const street = document.getElementById('inputNewStreet').value;
      const note = document.getElementById('inputNewNote').value;
      const isPrimary = document.getElementById('checkNewPrimary').checked;

      const finalName = name.trim() !== '' ? name : 'Penerima Baru';
      const finalPhone = phone.trim() !== '' ? phone : '+62 812-0000-0000';
      const finalStreet = street.trim() !== '' ? street : 'Alamat lengkap';

      const fullAddressString = `${finalStreet}, Kec. ${kec || 'Kecamatan'}, ${kota || 'Kota/Kab'}, ${prov || 'Provinsi'} ${postal || ''}`;

      if (isPrimary) {
        daftarAlamat.forEach(item => item.isPrimary = false);
      }

      const newObj = {
        id: daftarAlamat.length + 1,
        name: finalName,
        phone: finalPhone,
        address: fullAddressString,
        note: note,
        isPrimary: isPrimary
      };

      if (isPrimary) {
        daftarAlamat.unshift(newObj); 
        activeAddressIndex = 0;
      } else {
        daftarAlamat.push(newObj);
        activeAddressIndex = daftarAlamat.length - 1;
      }

      renderActiveAddress();
      
      // Reset form
      document.getElementById('inputNewName').value = '';
      document.getElementById('inputNewPhone').value = '';
      selectProvinsi.value = '';
      selectKota.innerHTML = '<option value="">Pilih Provinsi Dahulu</option>';
      selectKota.disabled = true;
      selectKecamatan.innerHTML = '<option value="">Pilih Kota/Kabupaten Dahulu</option>';
      selectKecamatan.disabled = true;
      inputPostal.value = '';
      document.getElementById('inputNewStreet').value = '';
      document.getElementById('inputNewNote').value = '';

      formAddAddress.style.display = 'none';
      chevronIcon.className = 'fa-solid fa-chevron-down';
    });
  }

  // Modal Ubah Alamat
  const modalUbahAlamat = document.getElementById('modalUbahAlamat');
  const btnOpenUbahAlamat = document.getElementById('btnOpenUbahAlamat');
  if (btnOpenUbahAlamat) {
    btnOpenUbahAlamat.addEventListener('click', () => {
      const active = daftarAlamat[activeAddressIndex];
      document.getElementById('editName').value = active.name;
      document.getElementById('editPhone').value = active.phone;
      document.getElementById('editStreet').value = active.address;
      document.getElementById('editNote').value = active.note;
      modalUbahAlamat.style.display = 'flex';
    });
  }

  const closeUbahModal = document.getElementById('closeUbahModal');
  if (closeUbahModal) {
    closeUbahModal.addEventListener('click', () => {
      modalUbahAlamat.style.display = 'none';
    });
  }

  const btnSaveEditAddress = document.getElementById('btnSaveEditAddress');
  if (btnSaveEditAddress) {
    btnSaveEditAddress.addEventListener('click', () => {
      daftarAlamat[activeAddressIndex].name = document.getElementById('editName').value;
      daftarAlamat[activeAddressIndex].phone = document.getElementById('editPhone').value;
      daftarAlamat[activeAddressIndex].address = document.getElementById('editStreet').value;
      daftarAlamat[activeAddressIndex].note = document.getElementById('editNote').value;
      
      renderActiveAddress();
      modalUbahAlamat.style.display = 'none';
    });
  }

  // Modal Pilih Alamat Lain
  const modalPilihAlamat = document.getElementById('modalPilihAlamat');
  const listAlamatContainer = document.getElementById('listAlamatContainer');
  const btnOpenPilihAlamat = document.getElementById('btnOpenPilihAlamat');

  if (btnOpenPilihAlamat) {
    btnOpenPilihAlamat.addEventListener('click', () => {
      listAlamatContainer.innerHTML = '';
      daftarAlamat.forEach((item, idx) => {
        const isActive = (idx === activeAddressIndex);
        const div = document.createElement('div');
        div.className = `address-option-item ${isActive ? 'active' : ''}`;
        div.innerHTML = `
          <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
            <strong>${item.name} (${item.phone})</strong>
            ${item.isPrimary ? '<span class="badge-utama">Utama</span>' : ''}
          </div>
          <p style="font-size:13px; color:var(--text-muted); margin-bottom:8px;">${item.address}</p>
          <button type="button" class="btn-save-address" style="padding:6px 14px; font-size:12px;" onclick="switchActiveAddress(${idx})">
            ${isActive ? 'Alamat Aktif Saat Ini' : 'Gunakan Alamat Ini'}
          </button>
        `;
        listAlamatContainer.appendChild(div);
      });
      modalPilihAlamat.style.display = 'flex';
    });
  }

  const closePilihModal = document.getElementById('closePilihModal');
  if (closePilihModal) {
    closePilihModal.addEventListener('click', () => {
      modalPilihAlamat.style.display = 'none';
    });
  }

  window.switchActiveAddress = function(index) {
    activeAddressIndex = index;
    renderActiveAddress();
    modalPilihAlamat.style.display = 'none';
  };

  window.addEventListener('click', (e) => {
    if (e.target === modalUbahAlamat) modalUbahAlamat.style.display = 'none';
    if (e.target === modalPilihAlamat) modalPilihAlamat.style.display = 'none';
  });

  // Hitung Total Pengiriman
  window.selectShipping = function(cardElement, cost) {
    document.querySelectorAll('.shipping-option-card').forEach(card => {
      card.classList.remove('selected');
      card.querySelector('input[type="radio"]').checked = false;
    });
    cardElement.classList.add('selected');
    cardElement.querySelector('input[type="radio"]').checked = true;

    document.getElementById('shippingFeeDisplay').textContent = 'Rp ' + cost.toLocaleString('id-ID');
    
    let subtotal = 547000;
    let discount = 50000;
    let grandTotal = subtotal - discount + cost;

    document.getElementById('grandTotalDisplay').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
  };

  renderActiveAddress();
});