import utilities from "../main";
export async function deleteBtnHandler() {
	try {
		const {isConfirmed} = await swalDelete();

		if ( !isConfirmed ) return;

		await axios.post("/email/delete", {
			mailIds: [this.dataset.mailId]
		});

		mailsDatatable.ajax.reload(null, false)
	}
	catch (err) {
		console.log(err);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε ...")
	}
}

export function swalDelete() {

	return Swal.fire({
		title: "Διαγραφή;",
		text: "Η ενέργεια θα είναι μη αναστρέψιμη...",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#ff5b5b',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ναι, διαγραφή!',
		cancelButtonText: 'Άκυρο!',
	});
}

export function deleteMails(url, ids, table) {
	
	axios.post(url, {
		mailIds: ids
	})
	.then( res => {
		table.ajax.reload(false, null);
	})
	.catch( err => {
		console.log(err);
		utilities.toastAlert("error", "Κάποιο σφάλμα παρουσιάστηκε...");
	})
}