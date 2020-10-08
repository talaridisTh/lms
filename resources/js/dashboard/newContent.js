//!######################################
//! 				Imports				#
//!######################################
import utilities from './main';

import ArticleEditor from "../../plugins/article-editor/article-editor"
require("../../plugins/article-editor/plugins/reorder/reorder");

import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import 'filepond/dist/filepond.min.css';

//!##############################################
//! 			Global Variables				#
//!##############################################
const baseUrl = window.location.origin;

//!##############################################
//! 				EventListeners				#
//!##############################################
$(".js-add-image").on( "click", utilities.imageHandler);

$(".js-gallery-page-btn").on( 'click', utilities.paginationHandler);

$(".tab-link").on("show.bs.tab", function(event) {
	event.preventDefault();
	Swal.fire(
		'Προσοχή',
		'<p class="mb-0">Θα πρέπει να αποθηκεύσετε το Course</p>για να συνεχίσετε!',
		'info'
	);
})

//!##############################################
//! 				Initializations				#
//!##############################################
let publishDate = $("#publish-date-select").daterangepicker({
	singleDatePicker: true,
	drops: "auto",
    opens: "center",
	timePicker: true,
	autoUpdateInput: false,
	timePicker24Hour: true,
	cancelButtonClasses: "btn-secondary",
	locale: {
        format: "DD-MM-YYYY H:mm",
    },
});

publishDate.on( "apply.daterangepicker", function(event, picker) {
		
	let startDate = picker.startDate.format('DD-MM-YYYY H:mm');
	this.value = startDate;
	
});

publishDate.on( 'cancel.daterangepicker', function(event, picker) {
	this.value = "";
});

$R.add('plugin', 'mediaLibrary', {
	translations: {
		en: {
			"mediaLibrary": "Media Library"
		}
	},
	init: function(app) {
		this.app = app;
		this.lang = app.lang;
		this.toolbar = app.toolbar;
	},
	start: function() {
		var buttonData = {
			title: this.lang.get("mediaLibrary"),
			icon: "<i class='mdi mdi-book-open-page-variant'></i>",
			api: "plugin.mediaLibrary.toggle"
		};

		var $button = this.toolbar.addButton("mediaLibrary", buttonData);
	},
	toggle: function() {
		$('#gallery-content')[0].dataset.editorId = "#summary"
		$('#gallery-content')[0].dataset.type = "redactor"
		$('#gallery-modal').modal('show')
	}
});

$R("#summary", {
	buttons: [
		'html', 'undo', 'redo', 'format',
		'bold', 'underline', 'italic', 'deleted',
		'sup', 'sub', 'lists', 'file', 'link', 'image'
	],
	buttonsAddBefore: { before: 'image', buttons: ['mediaLibrary'] },
	style: false,
	plugins: ["mediaLibrary", 'alignment'],
	minHeight: '150px',
	imageResizable: true,
	imagePosition : {
        "left": "image-left",
        "right": "image-right",
        "center": "image-center text-center"
	},
	imageFloatMargin: '20px',
	imageUpload: "/media/upload-images",
	callbacks: {
        upload: {
            beforeSend: function(xhr)
            {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        }
    }
});

// Create a plugin
ArticleEditor.add('plugin', 'mediaLibrary', {
    start: function() {
        this.app.addbar.add('mediaButton', {
            title: 'Media Library',
            icon: "<i class='mdi mdi-book-open-page-variant'></i>'",
            command: 'mediaLibrary.modal'
        });
    },
    modal: function(params, button) {
		this.app.popup.close();
		$('#gallery-content')[0].dataset.editorId = "#description"
		$('#gallery-content')[0].dataset.type = "article"
        $('#gallery-modal').modal('show')
    }
});

ArticleEditor('#description', {
	css: "/css/",
	custom: {
		css: [
			"/css/bootstrap.min.css",
			"/css/customArticleStyle.css",
		]
	},
	plugins: ['mediaLibrary', 'reorder'],
	classes: {
		img: 'img-fluid',
		p: 'text-wrap'
	},
	grid: {
		classname: 'row',
		columns: 12,
		gutter: '1px',
		offset: {
			left: '15px',
			right: '15px'
		},
		patterns: {
			'6|6': 'col-6|col-6',
			'4|4|4': 'col-4|col-4|col-4',
			'3|3|3|3': 'col-3|col-3|col-3|col-3',
			'2|2|2|2|2|2': 'col-2|col-2|col-2|col-2|col-2|col-2',
			'3|6|3': 'col-3|col-6|col-3',
			'2|8|2': 'col-2|col-8|col-2',
			'5|7': 'col-5|col-7',
			'7|5': 'col-7|col-5',
			'4|8': 'col-4|col-8',
			'8|4': 'col-8|col-4',
			'3|9': 'col-3|col-9',
			'9|3': 'col-9|col-3',
			'2|10': 'col-2|col-10',
			'10|2': 'col-10|col-2',
			'12': 'col-12'
		}
	},
	align: {
		left: "text-left",
		center: "text-center",
		right: "text-right",
	},
	editor: {
		minHeight: "300px"
	},
	image: {
		upload: "/media/upload-images",
		data: {
			"_token": $('meta[name="csrf-token"]').attr('content'),
		}
	}
});

FilePond.setOptions({
    name: 'file[]',
    allowMultiple: true,
});

FilePond.registerPlugin(FilePondPluginFileValidateType);

let dropzone = document.getElementById("file-pond");
const pond = FilePond.create( dropzone, {
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
	acceptedFileTypes: ['image/png', 'image/jpeg'],
} );