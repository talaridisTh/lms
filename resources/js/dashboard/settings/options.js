import utilities from '../main';
import ace from "ace-builds/src-noconflict/ace";
// require("ace-builds/src-noconflict/theme-monokai");
// require("ace-builds/src-noconflict/theme-clouds_midnight");
// require("ace-builds/src-noconflict/theme-kr_theme");
require("ace-builds/src-noconflict/theme-terminal");
require("ace-builds/src-noconflict/snippets/javascript");
// require("ace-builds/src-noconflict/mode-javascript");
require("ace-builds/src-noconflict/mode-json");

const optionId = document.getElementById("page-title").dataset.optionId;

const editor = ace.edit("editor", {
	useWorker: false,
	mode: "ace/mode/json",
	theme: "ace/theme/terminal"
});

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