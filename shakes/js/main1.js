function check()
{

  if(document.form1.firstname.value=="")
  {
    alert("Confirm Password does not matched");
	document.form1.firstname.focus();
	return false;
  }
    if(document.form1.surname.value=="")
  {
    alert("Plese Select Subject to Register");
	document.form1.surname.focus();
	return false;
  }
  if(document.form1.matric.value=="")
  {
    alert("Plese Enter Your Name");
	document.form1.matric.focus();
	return false;
  }
  if(document.form1.dept.value=="")
  {
    alert("Plese Select Department");
	document.form1.dept.focus();
	return false;
  }
  if(document.form1.level.value=="")
  {
    alert("Plese Select Level");
	document.form1.level.focus();
	return false;
  }
  if(document.form1.phone.value=="")
  {
    alert("Plese Enter Contact No");
	document.form1.phone.focus();
	return false;
  }
  if(document.form1.email.value=="")
  {
    alert("Plese Enter your Email Address");
	document.form1.email.focus();
	return false;
  }
  e=document.form1.email.value;
		f1=e.indexOf('@');
		f2=e.indexOf('@',f1+1);
		e1=e.indexOf('.');
		e2=e.indexOf('.',e1+1);
		n=e.length;

		if(!(f1>0 && f2==-1 && e1>0 && e2==-1 && f1!=e1+1 && e1!=f1+1 && f1!=n-1 && e1!=n-1))
		{
			alert("Please Enter valid Email");
			document.form1.email.focus();
			return false;
		}
  return true;
  }
  
