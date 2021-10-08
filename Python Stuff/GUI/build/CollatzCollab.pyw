import random as r
import time
import mysql.connector
from dotenv import load_dotenv
import os
import string
from gui import testerID
import json

# db stuff
load_dotenv()
db = mysql.connector.connect(
    host= os.getenv("HOST"),
    user= os.getenv("USER"),
    password= os.getenv("PASSWORD"),
    database= os.getenv("DATABASE"),
)
cursor = db.cursor(buffered=True)
print("Connected to DB")

# control the min and max values
rangeMax = 999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999
rangeMin = 2

# set inital value
num = r.randint(rangeMin, rangeMax)
print(f"Starting at: {num}")

testStart = 1
count = 0

# the function
while True:

    if testStart == 1:
        testIDNum = r.randint(1000,9999)
        testIDLet1 = r.choice(string.ascii_letters)
        testIDLet2 = r.choice(string.ascii_letters)
        testID = str(f"{testIDLet2}{testIDNum}{testIDLet1}")
        cursor.execute(f"INSERT INTO `numsTested` (`testID`, `status`, `testerID`, `date`) VALUES ('{testID}', 'Pending', '{testerID}', current_timestamp())")
        db.commit()

        jsonData = {}
        jsonData['Test Info'] = []
        jsonData["Test Info"].append({
            'testID': testID,
            'testerID': testerID,
            'number': num,
        })
        with open('tests.json', 'w') as outfile:
            json.dump(jsonData, outfile)

        time.sleep(2)

    if (num % 2) == 0:
        testStart = 2
        num /= 2
        print(num)

        if num == 1:
            cursor.execute(f"UPDATE `numsTested` SET `status`= 'Failed' WHERE `testID`= '{testID}'")
            db.commit()

            print("Loop reached... Picking new number")
            num = r.randint(rangeMin, rangeMax)

            testStart = 1
            count += 1
            print(f"Starting at: {num}")

            time.sleep(2)
            pass

    else:
        testStart = 2
        num *= 3
        num += 1
        print(num)

        if num == 1:
            cursor.execute(f"UPDATE `numsTested` SET `status`= 'Failed' WHERE `testID`= '{testID}'")
            db.commit()

            print("Loop reached... Picking new number")
            num = r.randint(rangeMin, rangeMax)

            testStart = 1
            count += 1

            print(f"Starting at: {num}")

            time.sleep(2)
            pass
    
    if count >= 100:
        cursor.execute("DELETE FROM `numsTested` WHERE `status` = 'Failed'")
        db.commit()
        count = 0
        print("Fails Cleared")
        pass