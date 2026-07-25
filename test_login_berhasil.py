import os
import time

from selenium import webdriver
from selenium.webdriver.common.by import By

# Kredensial dibaca dari environment variable, JANGAN di-hardcode di file ini
# (file ini ikut ter-commit ke repo). Contoh cara menjalankan:
#   PowerShell : $env:TEST_EMAIL="..."; $env:TEST_PASSWORD="..."; python test_login_berhasil.py
#   Bash       : TEST_EMAIL=... TEST_PASSWORD=... python test_login_berhasil.py
BASE_URL = os.environ.get("TEST_BASE_URL", "http://127.0.0.1:8000")
TEST_EMAIL = os.environ.get("TEST_EMAIL")
TEST_PASSWORD = os.environ.get("TEST_PASSWORD")

if not TEST_EMAIL or not TEST_PASSWORD:
    raise SystemExit("Set dulu environment variable TEST_EMAIL dan TEST_PASSWORD.")

# Inisialisasi driver Chrome
driver = webdriver.Chrome()

try:
    # Buka halaman login
    driver.get(f"{BASE_URL}/login")

    time.sleep(2)  # Tunggu halaman termuat

    # Isi form login
    driver.find_element(By.ID, "email").send_keys(TEST_EMAIL)
    driver.find_element(By.ID, "password").send_keys(TEST_PASSWORD)
    driver.find_element(By.XPATH, "//button[contains(text(), 'Login')]").click()

    time.sleep(3)  # Tunggu redirect

    # Verifikasi login
    if "Dashboard" in driver.page_source:
        print("✅ Login berhasil!")
    else:
        print("❌ Login gagal atau teks 'Dashboard' tidak ditemukan.")

finally:
    driver.quit()
