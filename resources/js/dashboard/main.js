//!##########################################
//!				Configurations				#
//!##########################################

const redactorConfig = {
	style: false,
	minHeight: '150px',
}

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
        let checkboxes = document.querySelectorAll(".js-user-checkbox:checked").length

        for (let i = 0; i < checkbox.length; i++) {
            checkbox[i].checked = !checkbox[i].checked
        }

        if (this.checked) {

            this.innerHTML = '<i class="h3 mdi mdi-checkbox-multiple-blank-outline"></i>'
        } else {

            this.innerHTML = '<i class="h3 mdi mdi-checkbox-marked-outline"></i>\n'
        }

        if (this.childNodes[0].className == "h3 mdi mdi-checkbox-multiple-blank-outline") {

            for (let i = 0; i < checkbox.length; i++) {
                checkbox[i].checked = true
                checkbox[i].parentElement.parentElement.parentElement.classList.add("trHover")
            }
            $(".bulk-action")[0].hidden = false

            $(".bulk-action")[0].innerText = ` Επιλογές ${checkboxes == 0 ? "" : `( ${checkboxes} ) `} `
        } else {
            for (let i = 0; i < checkbox.length; i++) {
                checkbox[i].checked = false
                checkbox[i].parentElement.parentElement.parentElement.classList.remove("trHover")
            }
            $(".bulk-action")[0].hidden = true
        }
    })
}

const changeInputHidden = (attr, hiddenAttr) => {


    $(attr).change(function () {
        if (attr == "#activeMaterial") {
            this.value = $(this).prop('checked') == true ? 1 : 0;
        }


        let hiddenValue = $(hiddenAttr)[0].value = this.value



      // let test  =   $("#topicMaterial").clone()
      //   console.log(test)


    })
}


$(".test").click(function(e){
    $( "#topicMaterialHidden" ).replaceWith( $( "#topicMaterial" ) );

    console.log(this)
})

const tableLocale = {
    emptyTable: "Δεν υπάρχουν εγγραφές",
    info: "_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
    infoEmpty: "0 απο 0 τα 0 αποτελέσματα",
    lengthMenu: "_MENU_",
    loadingRecords: "Φόρτωση ...",
    processing: "Επεξεργασία ...",
    search: "",
    searchPlaceholder: "Αναζήτηση... ",
    zeroRecords: "Δεν βρέθηκαν αποτελέσματα",
    paginate: {
        previous: "<i class='mdi mdi-chevron-left'>",
        next: "<i class='mdi mdi-chevron-right'>"
    }
}

function createStateSelect() {
	const selectElm = document.createElement("select");
	selectElm.classList.add("ml-1", "custom-select", "custom-select-sm", "form-control", "form-control-sm");

	selectElm.innerHTML = `
		<option value="">Όλες οι Καταστάσεις</option>
		<option value="1">Ενεργά</option>
		<option value="0">Ανενεργά</option>
	`;

	return selectElm;
}

const datePickerConfig = {
	ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	},
	alwaysShowCalendars: true,
	showCustomRangeLabel: false,
	drops: "auto",
	autoUpdateInput: false,
	opens: "center",
	locale: {
		format: "DD/MM/YYYY",
	},
}

export default {
    toastAlert,
    mainCheckboxSwitcher,
    minorCheckboxSwitcher,
    filterButton,
    selectAndDeselectCheckbox,
    tableLocale,
    changeInputHidden,
	redactorConfig,
	createStateSelect,
	datePickerConfig

}
