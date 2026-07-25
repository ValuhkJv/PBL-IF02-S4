import os
import time

from selenium import webdriver
from selenium.webdriver.common.by import By

# Email dibaca dari environment variable (jangan di-hardcode di file yang ter-commit).
# Password di sini memang sengaja salah, jadi bukan rahasia.
BASE_URL = os.environ.get("TEST_BASE_URL", "http://127.0.0.1:8000")
TEST_EMAIL = os.environ.get("TEST_EMAIL")

if not TEST_EMAIL:
    raise SystemExit("Set dulu environment variable TEST_EMAIL.")

# Inisialisasi driver Chrome
driver = webdriver.Chrome()

try:
    # Buka halaman login Laravel
    driver.get(f"{BASE_URL}/login")  # Sesuaikan lewat TEST_BASE_URL jika beda

    time.sleep(2)  # Tunggu halaman termuat

    # Isi form login dengan email benar dan password salah
    driver.find_element(By.ID, "email").send_keys(TEST_EMAIL)
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
