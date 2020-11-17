import utilities from '../main';
import * as FilePond from "filepond";
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import 'filepond/dist/filepond.min.css';

const baseUrl = window.location.origin;
let timer = 0;

const localRedactorConf = {
    buttons: [
        'html', 'undo', 'redo', 'format',
        'bold', 'underline', 'italic', 'deleted',
        'sup', 'sub', 'lists', 'file', 'link', 'image'
    ],
    buttonsAddBefore: {before: 'image', buttons: ['mediaLibrary']},
    style: false,
    plugins: ["mediaLibrary", 'alignment'],
    minHeight: '150px',
    imageResizable: true,
    imagePosition: {
        "left": "image-left",
        "right": "image-right",
        "center": "image-center text-center"
    },
    imageFloatMargin: '20px',
    imageUpload: "/media/upload-images",
    callbacks: {
        upload: {
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        }
    }
}

$(".tab-link").on("show.bs.tab", function(event) {
	event.preventDefault();

	Swal.fire({
		icon: 'info',
		title: 'Προσοχή!',
		html: `<p class="mb-0">Θα πρέπει να αποθηκεύσετε το μάθημα</p>για να συνεχίσετε!`,
		confirmButtonColor: '#536de6'
	});
})

let pluginConfig = {
    translations: {
        en: {
            "mediaLibrary": "Media Library"
        }
    },
    init: function (app) {
        this.app = app;
        this.lang = app.lang;
        this.toolbar = app.toolbar;
    },
    start: function () {
        var buttonData = {
            title: this.lang.get("mediaLibrary"),
            icon: "<i class='mdi mdi-book-open-page-variant'></i>",
            api: "plugin.mediaLibrary.toggle"
        };

        var $button = this.toolbar.addButton("mediaLibrary", buttonData);
    },
    toggle: function () {
		const id = this.app.rootElement.id;

        $('#gallery-content')[0].dataset.editorId = `#${id}`
        $('#gallery-content')[0].dataset.type = "redactor"
        $('#gallery-modal').modal('show')
    }
}

$R.add('plugin', 'mediaLibrary', pluginConfig);
$R("#summary", localRedactorConf);
$R("#description", localRedactorConf);
$R("#material-content", localRedactorConf);

FilePond.registerPlugin(FilePondPluginFileValidateType);
FilePond.registerPlugin(FilePondPluginFileValidateSize);

let dropzone = document.getElementById("file-pond");
const pond = FilePond.create(dropzone, {
	name: 'file[]',
	allowMultiple: true,
	className: "js-filepond-file-dragging",
	labelIdle: "Drag & Drop your files or Browse",
	allowRevert: false,
    server: {
		url: baseUrl,
		process: {
			url: '/media/upload-images',
			headers: {
				"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
			},
			onload: function(data) {
				utilities.paginationRequest( 1, "" );
			}
		}
	},
	onprocessfile: function (error, data) {
		if ( pond.status === 2 ) {
			clearTimeout(timer);
			let files = pond.getFiles();

			for (let i = 0; i < files.length; i++ ) {

				if ( files[i].status === 5 ) {
					timer = setTimeout(function() {
						pond.removeFile(files[i]);
					}, ( i + 1 ) * 500);
				}
			}
		}
	},
	onprocessfiles: function() {
		let files = pond.getFiles();

		for (let i = 0; i < files.length; i++ ) {

			timer = setTimeout(function() {
				pond.removeFile(files[i]);
				
			}, ( i + 1 ) * 500);
			
		}
	},
	acceptedFileTypes: ['image/png', 'image/jpeg'],
});

$("#image-search").on("input", utilities.searchHandler);

$(".js-gallery-page-btn").on( 'click', utilities.paginationHandler);

$(".js-add-image").on("click", utilities.imageHandler);

const dropArea = document.getElementsByClassName("js-filepond-file-dragging");

for ( let i = 0; i < dropArea.length; i++ ) {

	dropArea[i].addEventListener("dragover", function(event) {
		const draggingArea = this.getElementsByClassName("filepond--drop-label")[0];
		const label = draggingArea.querySelector("label");

		draggingArea.classList.add("limegreen");
		label.classList.add("text-limegreen");

	});

	dropArea[i].addEventListener("dragleave", function(event) {
		const draggingArea = this.getElementsByClassName("filepond--drop-label")[0];
		const label = draggingArea.querySelector("label");

		draggingArea.classList.remove("limegreen");
		label.classList.remove("text-limegreen");

	});

	dropArea[i].addEventListener("drop", function(event) {
		const draggingArea = this.getElementsByClassName("filepond--drop-label")[0];
		const label = draggingArea.querySelector("label");

		draggingArea.classList.remove("limegreen");
		label.classList.remove("text-limegreen");

	});
}
