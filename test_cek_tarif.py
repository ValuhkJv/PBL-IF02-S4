from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

# Inisialisasi browser
driver = webdriver.Chrome()

try:
    # 1. Buka halaman utama
    driver.get("http://127.0.0.1:8000")
    wait = WebDriverWait(driver, 10)
    time.sleep(3)  # waktu loading halaman utama

    # 2. Klik tab "Cek Tarif"
    tab_btn = wait.until(EC.element_to_be_clickable((By.ID, "tab-tarif-btn")))
    tab_btn.click()
    time.sleep(2)  # tunggu tab terbuka

    # 3. Isi input asal
    asal_input = wait.until(EC.presence_of_element_located((By.NAME, "asal")))
    asal_input.send_keys("Batam Kota")
    time.sleep(1)

    # 4. Isi input tujuan
    tujuan_input = driver.find_element(By.NAME, "tujuan")
    tujuan_input.send_keys("Batu Aji")
    time.sleep(1)

    # 5. Pilih kategori berat
    berat_dropdown = wait.until(EC.presence_of_element_located((By.NAME, "berat_kategori")))
    Select(berat_dropdown).select_by_visible_text("1-5 Kg")
    time.sleep(1)

    # 6. Klik tombol "Cek Tarif"
    cek_tarif_btn = wait.until(EC.element_to_be_clickable((By.XPATH, "//button[contains(text(), 'Cek Tarif')]")))
    cek_tarif_btn.click()
    time.sleep(3)  # tunggu hasil muncul

    print("✅ Cek tarif berhasil dikirim!")

finally:
    driver.quit()
