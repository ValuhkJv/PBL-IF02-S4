from selenium import webdriver
from selenium.webdriver.common.by import By
import time

# Inisialisasi driver Chrome
driver = webdriver.Chrome()

try:
    # Buka halaman login Laravel
    driver.get("http://127.0.0.1:8000/login")  # Sesuaikan URL jika beda

    time.sleep(2)  # Tunggu halaman termuat

    # Isi form login dengan email benar dan password salah
    driver.find_element(By.ID, "email").send_keys("auliasabrina144@gmail.com")
    driver.find_element(By.ID, "password").send_keys("password_salah")
    driver.find_element(By.XPATH, "//button[contains(text(), 'Login')]").click()

    time.sleep(3)  # Tunggu proses login

    # Cek apakah login gagal (misalnya, pesan error muncul atau tidak masuk ke dashboard)
    if "Dashboard" in driver.page_source:
        print("❌ Test GAGAL: Login seharusnya gagal, tapi berhasil masuk.")
    else:
        print("✅ Test BERHASIL: password salah")

finally:
    driver.quit()
