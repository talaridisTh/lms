function toastAlert(icon, message) {
    Swal.fire({
        toast: 'true',
        position: 'top-end',
        icon: icon,
        title: message,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}

function mainCheckboxSwitcher(main, minor) {

    for (let i = 0; i < minor.length; i++) {
        if (!minor[i].checked) {
            main.checked = false;
            break;
        } else {
            main.checked = true;
        }
    }

}

function minorCheckboxSwitcher(main, minor) {

    if (main.checked) {
        for (let i = 0; i < minor.length; i++) {
            minor[i].checked = true;
        }
    } else {
        for (let i = 0; i < minor.length; i++) {
            minor[i].checked = false;
        }
    }

}

const filterButton = function (attr, column, table) {
    $(attr).detach().appendTo('.dataTables_length label')
    $(attr).on('change', function () {
        table.columns(column).search(this.value).draw();
    });
}

const selectAndDeselectCheckbox = function (attr) {
    $(attr).click(function () {
        let checkbox = $(attr)


        for (let i = 0; i < checkbox.length; i++) {
            checkbox[i].checked = !checkbox[i].checked
        }

        if (this.checked) {
            $(".bulk-action")[0].hidden = false
           let checkboxes= document.querySelectorAll(".js-user-checkbox:checked").length
            $(".bulk-action")[0].innerText = ` Επιλογές ${checkboxes == 0 ? "" : `( ${checkboxes} ) `} `
            this.innerHTML = '<i class=" h3 mdi mdi-checkbox-multiple-blank-outline"></i>'
        } else {
            $(".bulk-action")[0].hidden = true
            this.innerHTML = '<i class="h3 mdi mdi-checkbox-marked-outline"></i>\n'
        }
    })
}

const changeInputHidden = (attr, hiddenAttr)=>{


    $(attr).change(function(){
        if(attr =="#activeMaterial"){
             this.value = $(this).prop('checked') == true ? 1 : 0;
        }

        console.log($(hiddenAttr))
        let hiddenValue = $(hiddenAttr)[0].value =this.value

    })
}

const tableLocale = {
	emptyTable: 		"Δεν υπάρχουν εγγραφές",
	info: 				"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
	infoEmpty:      	"0 απο 0 τα 0 αποτελέσματα",
	lengthMenu: 		"_MENU_",
	loadingRecords: 	"Φόρτωση ...",
	processing: 		"Επεξεργασία ...",
	search: 			"",
	searchPlaceholder: 	"Αναζήτηση... ",
	zeroRecords: 		"Δεν βρέθηκαν αποτελέσματα",
	paginate:{
		previous:"<i class='mdi mdi-chevron-left'>",
		next:"<i class='mdi mdi-chevron-right'>"}
}

export default {
    toastAlert,
    mainCheckboxSwitcher,
    minorCheckboxSwitcher,
    filterButton,
	selectAndDeselectCheckbox,
	tableLocale,
    changeInputHidden
}
