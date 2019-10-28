<h4>{registration}</h4>
<br /><br />
<ul>
<li>{notice1}</li>
<li>{notice2}</li>
<li>{notice3}</li>
<li>{notice4}</li>
</ul>

<script type="text/javascript">//<![CDATA[
function isAlphaNumeric(value)
{
  if (value.match(/^[a-zA-Z0-9]+$/))
    return true;
  else
    return false;
}
function checkform(f)
{
  if (f.account.value=="")
  {
    alert("{fill_fields}");
    return false;
  }
  if (!isAlphaNumeric(f.account.value))
  {
    alert("{fill_fields}");
    return false;
  }
  if (f.password.value=="")
  {
    alert("{fill_fields}");
    return false;
  }
  if (!isAlphaNumeric(f.password.value))
  {
    alert("{fill_fields}");
    return false;
  }
  if (f.password2.value=="")
  {
    alert("{fill_fields}");
    return false;
  }
  if (f.password.value!=f.password2.value)
  {
    alert("{pass_not_match}");
    return false; 
  }
  return true;
}
//]]></script>
<form method="post" action="reg.php" onsubmit="return checkform(this)">
<table>
 <tr>
  <td>{login}</td>
  <td><input type="text" name="account" maxlength="15" /></td>
 </tr>
 <tr>
  <td>{password}</td>
  <td><input type="password" name="password" maxlength="15" /></td>
 </tr>
 <tr>
  <td>{r_password}</td>
  <td><input type="password" name="password2" maxlength="15" /></td>
 </tr>
 <tr>
  <td>{ver_img}</td>
  <td><img src="captcha.php" alt="" /></td>
 </tr>
  <tr>
  <td>{ver_code}</td>
  <td><input type="text" name="captcha" maxlength="10" /><input type="hidden" name="ref" maxlength="16" value="{ref}" /></td>
 </tr>
 <tr>
  <td colspan="2" style="text-align: center;">{button}</td>
 </tr>
</table>
</form>