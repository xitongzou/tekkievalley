function changeThumb( key, nr )
{
	elem = document.getElementById(key);
	elem.value = nr;
	elemTmb	= document.getElementById(key + '_' + nr + '_tmb');
	elemTmb.style.borderColor = '#ff4800';
	for ( i = 1; i <= 3; i++ ) {
		if ( i != nr ) {
			elemTmb			= document.getElementById(key + '_' + i + '_tmb');
			elemTmb.style.borderColor = '#ccc';
		}
	}
}

function hideMe( myId )
{
    document.getElementById(myId).style.display="none";
}

function showMe( myId )
{
    document.getElementById(myId).style.display="block";
}

function showStatic( myId )
{
    hideMe('about');
    hideMe('dev');
    hideMe('help');
    hideMe('terms');
    hideMe('privacy');
    showMe(myId);
}
