import ArticleEditor from "../../../plugins/article-editor/article-editor";

//!######################################
//!			Global Variables			#
//!######################################

const materialId = $("#edit-material-form")[0].dataset.materialId;


//!######################################
//!			Initializations				#
//!######################################

$R('#description', {
	minHeight: "300px",
	imageUpload: "/materials/upload-description-images",
	imageResizable: true,
	callbacks: {
        upload: {
            beforeSend: function(xhr)
            {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        }
    }
});



ArticleEditor('#material-content', {
	editor: {
		minHeight: "300px"
	},
	image: {
		upload: "/materials/upload-content-images",
		data: {
			"_token": $('meta[name="csrf-token"]').attr('content')
		}
	}
});



