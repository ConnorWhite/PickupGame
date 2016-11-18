#!/usr/bin/python
import MySQLdb
import selenium

from selenium import webdriver
from selenium.webdriver.common.keys import Keys

driver = webdriver.Firefox()
#driver.get("http://www.python.org")
#assert "Python" in driver.title
#elem = driver.find_element_by_name("q")
#elem.clear()
#elem.send_keys("pycon")
#elem.send_keys(Keys.RETURN)
#assert "No results found." not in driver.page_source
#driver.close()

# connect
db = MySQLdb.connect(host="mysql.connorwhite.org", user="ee461l_team", passwd="c8XCrjcnss9E6fBX", db="pickupgame_db")

cursor = db.cursor()

# execute SQL select statement
cursor.execute("SELECT * FROM Player")

# commit your changes
db.commit()

# get the number of rows in the resultset
numrows = int(cursor.rowcount)

# get and display one row at a time.
for x in range(0,numrows):
    row = cursor.fetchone()
    print row[0], "-->", row[1]
