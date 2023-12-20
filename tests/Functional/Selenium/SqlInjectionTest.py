from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options
import unittest

class SQLInjectionTest(unittest.TestCase):
    def setUp(self):
        chrome_binary_path = "C:/Users/olegl/Downloads/chrome-win64/chrome.exe"  # Path to your Chrome binary
        chrome_driver_path = "C:/Users/olegl/Downloads/chromedriver.exe" # Path to your Chromedriver

        # Set Chrome options
        chrome_options = Options()
        chrome_options.binary_location = chrome_binary_path

        # Initialize WebDriver with Chrome options
        self.driver = webdriver.Chrome(executable_path=chrome_driver_path, options=chrome_options)  # Update chromedriver path

    def test_sql_injection(self):

        LOGIN_URL = "http://localhost:8000" + "/signin"

        driver = self.driver
        # Open the login page
        driver.get(LOGIN_URL)  # Replace with your website's URL

        # Fill in the form with SQL injection payload
        username_input = driver.find_element(By.NAME, 'loginusername')
        password_input = driver.find_element(By.NAME, 'loginpassword')
        username_input.send_keys("' OR '1'='1")
        password_input.send_keys("' OR '1'='1")

        # Submit the form
        submit_button = driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]')
        submit_button.click()

        # Wait for the error message to appear
        error_message = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CLASS_NAME, 'alert-danger'))
        )

        # Assert that the error message is present
        self.assertIsNotNone(error_message, "SQL injection error message not found.")

    def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()