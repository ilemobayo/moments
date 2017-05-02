#!C:\Users\Owner\AppData\Local\Programs\Python\Python35-32\python.exe

import cgi, os
import cgitb; cgitb.enable()


form = cgi.FieldStorage()

# Get filename here.
fileitem = form['img']

# Test if the file was uploaded
if fileitem.filename:
   # strip leading path from file name to avoid 
   # directory traversal attacks
   fn = os.path.basename(fileitem.filename)
   open(fn, 'wb').write(fileitem.file.read())

   #message = 'The file "' + fn + '" was uploaded successfully'
   
else:
   #message = 'No file was uploaded'
   
url = "http://localhost/shakes/chat/upgallery.php"
print ("Status: 302 Moved")
print ("Location: %s" % url)
print ("")
