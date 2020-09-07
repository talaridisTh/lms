//!######################################
//!			Global Variables			#
//!######################################

// const materialId = $("#edit-material-form")[0].dataset.materialId;


//!######################################
//!			Initializations				#
//!######################################

$R('#summaryMaterial',{
    minHeight: '150px'
});
$R('#descriptionMaterial',{
    minHeight: '150px'
});
$R('#contentMaterial',{
    minHeight: '150px'
});




//! EVENT listener
//!============================================================

//! SELECT2
//!============================================================
$("#typeMaterial").select2({
    minimumResultsForSearch: -1,
});

$("#instructorMaterial").select2({

    tags: true
});

$("#topicMaterial").select2({
    tags: true
});


$("#topicFilterMaterialCourses").select2({});

$(".custom-select").select2({   minimumResultsForSearch: -1,});

$("#activeFilterMaterialCourses").select2({   minimumResultsForSearch: -1,});

$("#userFilterMaterialCourses").select2({   minimumResultsForSearch: -1,});


//sortable
$("ul.select2-selection__rendered").sortable({
    containment: 'parent'
});
