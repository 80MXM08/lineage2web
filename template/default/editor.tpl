<textarea class="editorinput" id="area" name="{txt_name}" cols="65" rows="10" style="width:400px" onselect="FieldName(this, this.name)" onclick="FieldName(this, this.name)" onkeyup="FieldName(this, this.name)">{content}</textarea>
<div class="editor" style="background-image: url(img/editor/bg.gif); background-repeat: repeat-x;">
	<div class="editorbutton" onclick="RowsTextarea('area',1);"><img title="{increase_size}" src="img/editor/plus.gif" /></div>
	<div class="editorbutton" onclick="RowsTextarea('area',0)"><img title="{decrease_size}" src="img/editor/minus.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('b')"><img title="{bold}" src="img/editor/bold.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('i')"><img title="{italic}" src="img/editor/italic.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('u')"><img title="{underline}" src="img/editor/underline.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('li')"><img title="{list}" src="img/editor/li.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('hr')"><img title="{line}" src="img/editor/hr.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('left')"><img title="{aligned_left}" src="img/editor/left.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('center')"><img title="{centered}" src="img/editor/center.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('right')"><img title="{aligned_right}" src="img/editor/right.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('justify')"><img title="{justify}" src="img/editor/justify.gif" /></div>
    <div class="editorbutton" onclick="InsertCode('url','{{input_link}','{input_title}','{link_empty}')"><img title="{insert_link}" src="img/editor/url.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('mail','{input_mail}','{input_title}','{mail_empty}')"><img title="{insert_mail}" src="img/editor/mail.gif" /></div>
	<div class="editorbutton" onclick="InsertCode('img')"><img title="{insert_image}" src="img/editor/img.gif" /></div>
    <div class="editorbutton" onclick="InsertCode('quote')"><img title="{quote}" src="img/editor/quote.gif" /></div>
</div>
<div class="editor" style="background-image: url(img/editor/bg.gif); background-repeat: repeat-x;">
	

	<div class="editorbutton"><select class="editorinput" tabindex="1" style="font-size:10px;" name="family" onchange="InsertCode('family',this.options[this.selectedIndex].value)"><option style="font-family:Verdana;" value="Verdana">Verdana</option><option style="font-family:Arial;" value="Arial">Arial</option><option style="font-family:'Courier New';" value="Courier New">Courier New</option><option style="font-family:Tahoma;" value="Tahoma">Tahoma</option><option style="font-family:Helvetica;" value="Helvetica">Helvetica</option></select></div>
	<div class="editorbutton"><select class="editorinput" tabindex="1" style="font-size:10px; background-color: #383729;" name="color" onchange="InsertCode('color',this.options[this.selectedIndex].value)"><option style="color:black;" value="black">{black}</option><option style="color:silver;" value="silver">{silver}</option><option style="color:gray;" value="gray">{gray}</option><option style="color:white;" value="white">{white}</option><option style="color:maroon;" value="maroon">{maroon}</option><option style="color:red;" value="red">{red}</option><option style="color:purple;" value="purple">{purple}</option><option style="color:fuchsia;" value="fuchsia">{fuchsia}</option><option style="color:green;" value="green">{green}</option><option style="color:lime;" value="lime">{lime}</option><option style="color:olive;" value="olive">{olive}</option><option style="color:yellow;" value="yellow">{yellow}</option><option style="color:navy;" value="navy">{navy}</option><option style="color:blue;" value="blue">{blue}</option><option style="color:teal;" value="teal">{teal}</option><option style="color:aqua;" value="aqua">{aqua}</option></select></div>
	<div class="editorbutton"><select class="editorinput" tabindex="1" style="font-size:10px;" name="size" onchange="InsertCode('size',this.options[this.selectedIndex].value)"><option value="8">{size_8}</option><option value="10">{size_10}</option><option value="12">{size_12}</option><option value="14">{size_14}</option><option value="18">{size_18}</option><option value="24">{size_24}</option></select></div>
</div>