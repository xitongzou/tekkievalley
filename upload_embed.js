function submitEmbedUpload( button_id, form_id ) {
	buttonObj = document.getElementById(button_id);
	buttonObj.disabled=true;
	buttonObj.value="Uploading...";
	formObj = document.getElementById(form_id);
	formObj.submit();
}

function resetEmbedUpload( button_id ) {
	buttonObj = document.getElementById(button_id);
	buttonObj.disabled=false;
	buttonObj.value="Upload";
}

function toggleTab( tab_id, button_id ) {
	for(i=0; i<buttons.length; i++ ) {
		elem = document.getElementById(buttons[i]);
		if ( buttons[i] == button_id ) {
			elem.className="tabactive";
		} else {
			elem.className="";
		}
	}

	for(i=0; i<tabs.length; i++ ) {
		elem = document.getElementById(tabs[i]);
		if(tabs[i]==tab_id) {
			elem.style.display="block";
		} else {
			elem.style.display="none";
		}
	}
}
