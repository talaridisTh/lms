import utilities from '../main';
//! EDITOR INIT
//!============================================================

$R('#summaryMaterial',{
    minHeight: '150px'
});
$R('#descriptionMaterial',{
    minHeight: '150px'
});
$R('#contentMaterial',{
    minHeight: '150px'
});


//! METHOD INIT
//!============================================================

utilities.changeInputHidden('#urlMaterial','#urlMaterialHiden')
utilities.changeInputHidden('#createAtMaterial','#createAtMaterialHidden')
utilities.changeInputHidden('#activeMaterial','#activeMaterialHidden')
utilities.changeInputHidden('#typeMaterial','#typeMaterialHidden')
utilities.changeInputHidden('#instructorMaterial','#instructorMaterialHidden')
utilities.changeInputHidden('#topicMaterial','#topicMaterialHidden')
// utilities.changeInputHidden('#coursesMaterial','#coursesMaterialHidden')



//! SELECT2
//!============================================================
$("#typeMaterial").select2({
    minimumResultsForSearch: -1,
    allowClear: true,
    placeholder: 'Ολοι οι Τύποι'
});

// $("#coursesMaterial").select2({
//     allowClear: true,
//     placeholder: 'Ολα τα courses'
// });

$("#instructorMaterial").select2({
    allowClear: true,
    placeholder: 'Ολοι οι Εισηγητής'
});

$("#topicMaterial").select2({
    allowClear: true,
    placeholder: 'Ολα τα Τοpic'
});



let dataRange = $("#createAtMaterial")

dataRange.daterangepicker({
    locale: {
        format: 'YY/MM/DD '
    },
    startDate: moment().startOf('hour'),
    // ranges: {
    //     'Today': [moment(), moment()],
    //     'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    //     'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    //     'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    //     'This Month': [moment().startOf('month'), moment().endOf('month')],
    //     'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    // },
    alwaysShowCalendars: true,
    showCustomRangeLabel: false,
    drops: "auto",
    autoUpdateInput: false,
    opens: "center",
});
