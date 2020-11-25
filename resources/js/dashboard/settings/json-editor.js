import ace from "ace-builds/src-noconflict/ace";
require("ace-builds/src-noconflict/theme-terminal");
require("ace-builds/src-noconflict/snippets/javascript");
require("ace-builds/src-noconflict/mode-json");

const editor = ace.edit("editor", {
	useWorker: false,
	mode: "ace/mode/json",
	theme: "ace/theme/terminal"
});

$("#json-form").on("submit", function(event) {
	event.preventDefault();
	
	const jsonValue = editor.getValue();
	$("#json-area").val(jsonValue);

	this.submit();
});