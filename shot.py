import os, time
from playwright.sync_api import sync_playwright

OUT = r"D:\projects\公众号文章\十四五养老服务体系"
VIEWPORT = {"width": 1280, "height": 800}


def login(page, email, password):
    page.goto("http://localhost/login", wait_until="networkidle")
    page.wait_for_selector("#email", timeout=15000)
    page.fill("#email", email)
    page.fill("#password", password)
    page.click("button[type=submit]")
    page.wait_for_load_state("networkidle")
    time.sleep(1)


with sync_playwright() as p:
    browser = p.chromium.launch(executable_path=r"C:\Program Files\Google\Chrome\Application\chrome.exe")
    page = browser.new_page(viewport=VIEWPORT)

    page.goto("http://localhost/login", wait_until="networkidle")
    page.wait_for_selector("#email", timeout=15000)
    time.sleep(1)
    page.screenshot(path=os.path.join(OUT, "shot_login.png"))
    print("saved shot_login")

    login(page, "supervisor@example.com", "password")
    page.screenshot(path=os.path.join(OUT, "shot_dashboard.png"))
    print("saved shot_dashboard")

    for path, name in [("/supervisor/patients", "shot_patients"),
                       ("/supervisor/care-plans", "shot_careplans"),
                       ("/supervisor/assignments", "shot_assignments")]:
        page.goto("http://localhost" + path, wait_until="networkidle")
        time.sleep(1)
        page.screenshot(path=os.path.join(OUT, name + ".png"))
        print("saved", name)

    browser.close()
