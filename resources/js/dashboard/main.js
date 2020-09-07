Element.prototype.findParent = function (loops) {
	let parent = this;

	for ( let i = 0; i < loops; i++ ) {
		parent = parent.parentElement;
	}

	return parent;
},false;

Element.prototype.appendBefore = function (element) {
	element.parentNode.insertBefore(this, element);
},false;

Element.prototype.appendAfter = function (element) {

	element.parentNode.insertBefore(this, element.nextSibling);

},false;

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
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'This Year': [moment().startOf('year'), moment().endOf('year')],
        'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
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
function mainCheckboxSwitcher(main, minor, bulkBtn = false) {
    let status = true;
    let counter = 0;
    main.checked = true;

    for (var i = 0; i < minor.length; i++) {
        if (!minor[i].checked) {
            minor[i].findParent(3).classList.remove("bg-selected");
            main.checked = false;
        } else {
            minor[i].findParent(3).classList.add("bg-selected");
            counter++
            status = false;
        }
    }

    if (bulkBtn) {
        bulkModifier(bulkBtn, status, counter);
    }
}

function minorCheckboxSwitcher(main, minor, bulkBtn = false) {
    let counter = 0;
    let status = true;

    if (main.checked && minor.length > 0) {

        counter = minor.length;
        status = false;

        for (var i = 0; i < minor.length; i++) {
            minor[i].checked = true;
            minor[i].findParent(3).classList.add("bg-selected");
        }
    } else {
        for (var i = 0; i < minor.length; i++) {
            minor[i].checked = false;
            minor[i].findParent(3).classList.remove("bg-selected");
        }
    }

    if (bulkBtn) {
        bulkModifier(bulkBtn, status, counter);
    }
}

function bulkModifier(bulkBtn, status, sum) {

    let text = bulkBtn.dataset.text ? bulkBtn.dataset.text : "Επιλογές";
    let enabledColor = bulkBtn.dataset.enabledColor ? bulkBtn.dataset.enabledColor : "btn-warning";
    let disabledColor = bulkBtn.dataset.disabledColor ? bulkBtn.dataset.disabledColor : "btn-secondary";

    if (status) {
        bulkBtn.classList.add(disabledColor)
        bulkBtn.classList.remove(enabledColor)
        bulkBtn.textContent = `${text} (0)  `
        bulkBtn.disabled = true;
    } else {
        bulkBtn.classList.add(enabledColor);
        bulkBtn.classList.remove(disabledColor);
        bulkBtn.textContent = `${text}  (${sum})  `
        bulkBtn.disabled = false;
    }
}

function filterStyle( input, value ) {

	if ( value == "" ) {
		input.classList.remove("select2-selected");
	}
	else {
		input.classList.add("select2-selected");
	}

}

    const filterButton = function (attr, column, table) {
    $(attr).detach().appendTo('.dataTables_length label')

    $(attr).on('change', function () {
        table.columns(column).search(this.value).draw();
        console.log(column)
    });
}

const changeInputHidden = (attr, hiddenAttr) => {

    $(attr).change(function () {
        if (attr == "#activeMaterial") {
            this.value = $(this).prop('checked') == true ? 1 : 0;
        }

        let hiddenValue = $(hiddenAttr)[0].value = this.value

    })
}

function createStateSelect( id = "" ) {
    const selectElm = document.createElement("select");
    selectElm.classList.add("ml-1", "select2");
	selectElm.id = id;

    selectElm.innerHTML = `
		<option value="">Όλες οι Καταστάσεις</option>
		<option value="1">Ενεργά</option>
		<option value="0">Ανενεργά</option>
	`;

    return selectElm;
}

function createDateElm( id ) {
	let input = document.createElement("input");

	input.classList.add("form-control", "date", "d-inline-block", "ml-1");
	input.id = id;
	input.dataset.toggle = "date-picker";
	input.dataset.cancelClass = "btn-secondary";
	input.style.height = "31.96px";
	input.style.width = "195px";
	input.placeholder = "Επιλέξτε ημερομηνίες...";

	return input;
}

function startDate( input ) {

	let dateInput = input;

	if ( !dateInput || dateInput.value == "" ) {
		return "";
	}

	let dateInputValue = dateInput.value.split(" - ");
	let firstDate = dateInputValue[0].split("/").reverse().join("-");

	return firstDate;
}

function endDate( input ) {

	let dateInput = input;

	if ( !dateInput || dateInput.value == "" ) {
		return "";
	}

	let dateInputValue = dateInput.value.split(" - ");
	let secondDate = dateInputValue[1].split("/").reverse().join("-");

	return secondDate;
}

function resetBulk( bulkBtn, checkbox ) {

	bulkBtn.text("Επιλογές  (0)");
	bulkBtn.addClass("btn-secondary");
	bulkBtn.removeClass("btn-warning");
	bulkBtn.prop("disabled", true);
	checkbox.prop("checked", false);
}

function resetAddButton( addBtn, checkbox ) {
	addBtn.text("Προσθήκη Επιλογών (0)");
	addBtn.addClass("btn-secondary");
	addBtn.removeClass("btn-primary");
	addBtn.prop("disabled", true);
	checkbox.prop("checked", false);
}

export default {
    toastAlert,
    mainCheckboxSwitcher,
    minorCheckboxSwitcher,
    filterButton,
    tableLocale,
    changeInputHidden,
    redactorConfig,
    createStateSelect,
    datePickerConfig,
	toastAlertDelete,
	filterStyle,
	createDateElm,
	startDate,
	endDate,
	resetBulk,
	resetAddButton
}

