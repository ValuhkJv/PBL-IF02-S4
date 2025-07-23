from selenium import webdriver
from selenium.webdriver.common.by import By
import time

# Inisialisasi driver Chrome
driver = webdriver.Chrome()

try:
    # Buka halaman login
    driver.get("http://127.0.0.1:8000/login")

    time.sleep(2)  # Tunggu halaman termuat

    # Isi form login
    driver.find_element(By.ID, "email").send_keys("auliasabrina144@gmail.com")
    driver.find_element(By.ID, "password").send_keys("liacantik61")
    driver.find_element(By.XPATH, "//button[contains(text(), 'Login')]").click()

    time.sleep(3)  # Tunggu redirect

    # Verifikasi login
    if "Dashboard" in driver.page_source:
        print("✅ Login berhasil!")
    else:
        print("❌ Login gagal atau teks 'Dashboard' tidak ditemukan.")

finally:
    driver.quit()
