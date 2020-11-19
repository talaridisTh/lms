import utilities from '../main';

const optionId = document.getElementById("page-title").dataset.optionId;

const editor = ace.edit("editor");
editor.setTheme("ace/theme/monokai");
editor.session.setMode("ace/mode/javascript");

const updateBtn = document.getElementById("update-btn");
updateBtn.addEventListener("click", function() {
	const value = editor.getValue();

	jsonUpdate(value);
})

function jsonUpdate(value) {

	axios.post(`/dashboard/dev-tools/${optionId}/update`, {value: value})
	.then( res => {
		utilities.toastAlert("success", "Αποθηκεύτηκε!");
	})
	.catch ( err => {
		console.log(err);
		utilities.toastAlert("error", "Ooops!!!");
	})
}