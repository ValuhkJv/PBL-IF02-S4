from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
import time

# Inisialisasi browser
driver = webdriver.Chrome()

try:
    # === 1. Buka halaman login ===
    driver.get("http://127.0.0.1:8000/login")
    time.sleep(2)

    driver.find_element(By.ID, "email").send_keys("auliasabrina144@gmail.com")
    time.sleep(1)
    driver.find_element(By.ID, "password").send_keys("liacantik61")
    time.sleep(1)
    driver.find_element(By.XPATH, "//button[contains(text(), 'Login')]").click()
    time.sleep(3)

    # === 2. Klik dropdown 'Layanan' ===
    layanan_dropdown = driver.find_element(By.XPATH, "//summary[contains(text(), 'Layanan')]")
    driver.execute_script("arguments[0].click();", layanan_dropdown)
    time.sleep(2)

    permintaan_link = driver.find_element(By.XPATH, "//a[contains(text(), 'Permintaan Pengiriman')]")
    driver.execute_script("arguments[0].click();", permintaan_link)
    time.sleep(3)

    # === 3. Isi Form Step 1 ===
    Select(driver.find_element(By.NAME, "pickupKecamatan")).select_by_visible_text("Batam Kota")
    time.sleep(1)

    driver.find_element(By.NAME, "receiverName").send_keys("Nama Penerima")
    time.sleep(1)
    driver.find_element(By.NAME, "receiverPhoneNumber").send_keys("081234567890")
    time.sleep(1)
    driver.find_element(By.NAME, "receiverAddress").send_keys("Jl. Tujuan 456, Batam")
    time.sleep(1)
    Select(driver.find_element(By.NAME, "receiverKecamatan")).select_by_visible_text("Bengkong")
    time.sleep(1)
    driver.find_element(By.NAME, "itemType").send_keys("Dokumen")
    time.sleep(1)
    driver.find_element(By.NAME, "weightKG").send_keys("2.5")
    time.sleep(1)
    driver.find_element(By.NAME, "notes").send_keys("Jangan dibanting")
    time.sleep(1)

    # === 4. Klik 'Lanjutkan' ke Step 2 ===
    driver.find_element(By.XPATH, "//button[contains(text(), 'Lanjutkan')]").click()
    time.sleep(3)

    print("✅ Step 1 berhasil disubmit")

    # === 5. Pilih metode pembayaran COD ===
    cod_label = driver.find_element(By.XPATH, "//span[contains(text(), 'Bayar di Tempat (COD)')]")
    driver.execute_script("arguments[0].click();", cod_label)
    time.sleep(2)

    # === 6. Klik 'Konfirmasi & Buat Pesanan' ===
    confirm_button = driver.find_element(By.XPATH, "//button[contains(text(), 'Konfirmasi') and contains(text(), 'Pesanan')]")
    driver.execute_script("arguments[0].click();", confirm_button)
    time.sleep(3)

    print("✅ Pesanan berhasil dikonfirmasi dengan metode COD")

finally:
    driver.quit()
