<?php
// Periksa apakah ada data HTML yang diterima
if (isset($_POST['html_content'])) {
    // Dapatkan konten HTML dari formulir
    $htmlContent = $_POST['html_content'];

    // Tentukan lokasi penyimpanan file
    $fileLocation = 'lokasi_penyimpanan/nama_file.html'; // Ganti dengan lokasi dan nama file yang diinginkan

    // Buat file HTML baru dan tulis konten HTML ke dalamnya
    $file = fopen($fileLocation, 'w'); // Buka file dalam mode tulis ('w')
    fwrite($file, $htmlContent); // Tulis konten HTML ke file
    fclose($file); // Tutup file

    // Setelah file dibuat, kembalikan respons berhasil
    echo "File berhasil disimpan sebagai $fileLocation";
} else {
    // Jika tidak ada data HTML yang diterima, berikan pesan kesalahan
    echo "Gagal menyimpan file. Tidak ada konten HTML yang diterima.";
}
?>
