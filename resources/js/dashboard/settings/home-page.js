//!######################################
//! 				Imports				#
//!######################################
import utilities from '../main';
import ArticleEditor from "../../../plugins/article-editor/article-editor"
require("../../../plugins/article-editor/plugins/reorder/reorder");

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
		let id = this.app.$element.nodes[0].id;
		this.app.popup.close();
		$('#gallery-content')[0].dataset.editorId = `#${id}`
		$('#gallery-content')[0].dataset.type = "article"
        $('#gallery-modal').modal('show')
    }
});

utilities.articleConfig.plugins = ['mediaLibrary', 'reorder'];

ArticleEditor("#first-section-textarea", utilities.articleConfig);
ArticleEditor("#second-section-textarea", utilities.articleConfig);
ArticleEditor("#third-section-textarea", utilities.articleConfig);
ArticleEditor("#fourth-section-textarea", utilities.articleConfig);
ArticleEditor("#fifth-section-textarea", utilities.articleConfig);

$("#image-search").on("input", utilities.searchHandler);

$(".js-gallery-page-btn").on( 'click', utilities.paginationHandler);

$(".js-add-image").on( "click", utilities.imageHandler);