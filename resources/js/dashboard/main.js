Element.prototype.findParent = function (loops) {
	let parent = this;

	for ( let i = 0; i < loops; i++ ) {
		parent = parent.parentElement;
	}

	return parent;
}

//!##########################################
//!				Configurations				#
//!##########################################

//!ALERT
//!============================================================
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

function toastAlertDelete(text,icon="warning"){
    return   Swal.fire({
        title: 'Είστε σίγουρος;',
        text:text,
        icon: icon,
        showCancelButton: true,
        confirmButtonText: 'Ναί, διαγραφή!',
        cancelButtonText: 'Άκυρο'
    });
}


//!CONFIG
//!============================================================
const redactorConfig = {
    style: false,
    minHeight: '150px',
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




//!GLOBAL FUNCTION
//!============================================================
function mainCheckboxSwitcher(main, minor) {

    for (let i = 0; i < minor.length; i++) {
        if (!minor[i].checked) {
            main.checked = false;
            break;
        } else {
            main.checked = true;
        }
    }

function mainCheckboxSwitcher(main, minor, bulkBtn = false ) {
	let status = true;
	let counter = 0;
	main.checked = true;

    for (var i = 0; i < minor.length; i++) {
        if ( !minor[i].checked ) {
			minor[i].findParent(3).classList.remove("bg-selected");
			main.checked = false;
		}
		else {
			minor[i].findParent(3).classList.add("bg-selected");
			counter++
			status = false;
		}
	}

	if ( bulkBtn ) {
		bulkModifier( bulkBtn, status, counter );
	}
}

function minorCheckboxSwitcher(main, minor, bulkBtn = false) {
	let counter = 0;
	let status = true;

    if ( main.checked && minor.length > 0 ) {

		counter = minor.length;
		status = false;

        for (var i = 0; i < minor.length; i++) {
			minor[i].checked = true;
			minor[i].findParent(3).classList.add("bg-selected");
		}
	}
	else {
		for (var i = 0; i < minor.length; i++) {
			minor[i].checked = false;
			minor[i].findParent(3).classList.remove("bg-selected");
		}
	}

	if ( bulkBtn ) {
		bulkModifier( bulkBtn, status, counter );
	}
}

function bulkModifier( bulkBtn, status, sum ) {

	let text = bulkBtn.dataset.text ? bulkBtn.dataset.text : "Επιλογές";
	let enabledColor = bulkBtn.dataset.enabledColor ? bulkBtn.dataset.enabledColor : "btn-warning";
	let disabledColor = bulkBtn.dataset.disabledColor ? bulkBtn.dataset.disabledColor : "btn-secondary";

	if ( status ) {
		bulkBtn.classList.add( disabledColor )
		bulkBtn.classList.remove( enabledColor )
		bulkBtn.textContent = `${text} (0)  `
		bulkBtn.disabled = true;
	}
	else {
		bulkBtn.classList.add( enabledColor );
		bulkBtn.classList.remove( disabledColor );
		bulkBtn.textContent = `${text}  (${sum})  `
		bulkBtn.disabled = false;
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
        let checkboxes = document.querySelectorAll(".js-user-checkbox:checked").length
        $(".bulk-action")[0].innerText = ` Επιλογές ${checkboxes == 0 ? "" : `( ${checkboxes} ) `} `
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
            $(".bulk-action")[0].disabled = false
            $(".bulk-action")[0].classList.add("bg-warning")
            $(".bulk-action")[0].classList.remove("bg-secontary")


        } else {
            for (let i = 0; i < checkbox.length; i++) {
                checkbox[i].checked = false
                checkbox[i].parentElement.parentElement.parentElement.classList.remove("trHover")
            }
            $(".bulk-action")[0].disabled = true
            $(".bulk-action")[0].classList.remove("bg-warning")
            $(".bulk-action")[0].classList.add("bg-secontary")

        }
    })
}

const changeInputHidden = (attr, hiddenAttr) => {


    $(attr).change(function () {
        if (attr == "#activeMaterial") {
            this.value = $(this).prop('checked') == true ? 1 : 0;
        }

        let hiddenValue = $(hiddenAttr)[0].value = this.value

    })
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
    datePickerConfig,
    toastAlertDelete

}
