
function toastAlert( icon, message ) {
	Swal.fire({
			toast: 'true',
			position: 'top-end',
			icon: icon,
			title: message,
			showConfirmButton: false,
			timer: 3000,
			  timerProgressBar: true
		});
}

function mainCheckboxSwitcher( main, minor) {

	for ( let i = 0; i < minor.length; i++ ) {
		if ( !minor[i].checked ) {
			main.checked = false;
			break;
		}
		else {
			main.checked = true;
		}
	}

}

function minorCheckboxSwitcher( main, minor ) {

	if ( main.checked ) {
		for ( let i = 0; i < minor.length; i++ ) {
			minor[i].checked = true;
		}
	}
	else {
		for ( let i = 0; i < minor.length; i++ ) {
			minor[i].checked = false;
		}
	}

}

export default {
	toastAlert,
	mainCheckboxSwitcher,
	minorCheckboxSwitcher
}