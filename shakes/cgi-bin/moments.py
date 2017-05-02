#!C:\Users\Owner\AppData\Local\Programs\Python\Python35-32\python.exe

# Import modules for CGI handling 
import cgi, cgitb 
import sqlite3


url = "http://127.0.0.12/shakes/chat/chat.php"
print ("Status: 302 Moved")
print ("Location: %s" % url)
#print ("Location:",getQualifiedURL("../chat/index.php"))

conn = sqlite3.connect('example.db')

c = conn.cursor()

c.execute("""drop table if exists towns""")
c.execute("""drop table if exists hotels""")

conn.commit()

c.execute("""create table towns (
        tid     int     primary key not NULL ,
        name    text,
        postcode        text)""")

c.execute("""create table hotels (
        hid     int     primary key not NULL ,
        tid     int,
        name    text,
        address text,
        rooms   int,
        rate    float)""")

c.execute("""insert into towns values (1, "Melksham", "SN12")""")
c.execute("""insert into towns values (2, "Cambridge", "CB1")""")
c.execute("""insert into towns values (3, "Foxkilo", "CB22")""")

c.execute("""insert into hotels values (1, 2, "Hamilkilo Hotel", "Chesterton Road", 15, 40.)""")
c.execute("""insert into hotels values (2, 2, "Arun Dell", "Chesterton Road", 60, 70.)""")
c.execute("""insert into hotels values (3, 2, "Crown Plaza", "Downing Street", 100, 105.)""")
c.execute("""insert into hotels values (4, 1, "Well House Manor", "Spa Road", 5, 80.)""")
c.execute("""insert into hotels values (5, 1, "Beechfield House", "The Main Road", 26, 110.)""")

conn.commit()

c.execute ("""select * from towns left join hotels on towns.tid = hotels.tid""")

#this works for POST and GET
# Create instance of FieldStorage 
form = cgi.FieldStorage() 
# Get data from fields
first_name = form.getvalue('first_name')
last_name  = form.getvalue('last_name')

print ("Content-type:text/html\r\n\r\n")
print ("<html>")
print ("<head>")
print ("<title>Hello - Second CGI Program</title>")
print ("</head>")
print ("<body>")
print ("<h2>Hello %s %s</h2>" % (first_name, last_name))
print ("""<form enctype="multipart/form-data" 
                    action="upload.py" method="post">
  <p>File: <input type="file" name="filename" /></p>
  <p><input type="submit" value="Upload" /></p>
  </form>""")


for row in c:
        print (row)

print ("</body>")
print ("</html>")

c.close()





##print ("Content-type:text/html\r\n\r\n")
##print ("<html>")
##print ("<head>")
##print ("<title>Hello - Second CGI Program</title>")
##print ("</head>")
##print ("<body>")
##print ("<h2>Hello %s %s</h2>" % (first_name, last_name))
##print ("""<form enctype="multipart/form-data" 
##                     action="upload.py" method="post">
##   <p>File: <input type="file" name="filename" /></p>
##   <p><input type="submit" value="Upload" /></p>
##   </form>""")
##print ("</body>")
##print ("</html>")
