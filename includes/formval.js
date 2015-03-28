function IsEmpty(aTextField) {
   if ((aTextField.value.length==0) ||
   (aTextField.value==null)) {
      return true;
   }
   else { return false; }
}





function limitAttach(extArray, thisform) {

	allowSubmit = false;
	filen = thisform.fileName.value;
	if (filen == "") return false;
	while (filen.indexOf("\\") != -1)
		filen = filen.slice(filen.indexOf("\\") + 1);
		ext = filen.slice(filen.indexOf(".")).toLowerCase();
	for (var i = 0; i < extArray.length; i++) {
		if (extArray[i] == ext) { allowSubmit = true; break; }
	}
	if (allowSubmit) thisform.submit();
	else
	alert("Please only choose a filename that ends in  "
	+ (extArray.join("  ")) + "\nPlease select a new "
	+ "filename and submit again.");
	return false;

}
