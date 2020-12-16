//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';

$R("#profil", utilities.redactorConfig);

$(".tab-link").on("show.bs.tab", function(event) {
	event.preventDefault();

	Swal.fire({
		icon: 'info',
		title: 'Προσοχή!',
		html: `<p class="mb-0">Θα πρέπει να αποθηκεύσετε τον χρήστη</p>για να συνεχίσετε!`,
		confirmButtonColor: '#536de6'
	});
})