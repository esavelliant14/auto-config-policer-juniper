import schedule
import time
import subprocess

def job():
    subprocess.run(["python", "rollback.py"])

# jalan setiap 1 menit
schedule.every(1).minutes.do(job)

while True:
    schedule.run_pending()
    time.sleep(1)