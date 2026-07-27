import shutil

source = "/var/www/html/stautoparts/backup/app.blade.php.header-backup"
destination = "/var/www/html/stautoparts/resources/views/layouts/app.blade.php"

try:
    # First, make a backup of the current app.blade.php
    shutil.copy2(destination, destination + ".reverted-by-copilot")
    print("Backup of current app.blade.php created.")
    
    # Copy the header backup to destination
    shutil.copy2(source, destination)
    print("Successfully restored app.blade.php from backup/app.blade.php.header-backup!")
except Exception as e:
    print("Error:", e)
