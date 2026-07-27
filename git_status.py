import subprocess
try:
    print(subprocess.check_output(["git", "status"], stderr=subprocess.STDOUT).decode())
except Exception as e:
    print("Error:", e)
