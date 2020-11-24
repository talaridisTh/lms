import utilities from '../main';

utilities.redactorConfig.minHeight = "300px"

$R("#editor", utilities.redactorConfig);

const recipientsSelect = $('#recipients-selection').select2({
	placeholder: "Επιλέξτε παραλήπτες...",
	// allowClear: true,
	ajax: {
		url: "/email/users",
		delay: 1000,
		dataType: "json",
		data: function(params) {
			return {
				search: params.term,
				page: params.page || 1
			}
		}
	}
});

$(".js-recipients").on("change", function() {
	const select = $('#recipients-selection');
	const recipients = $(".js-recipients:checked");
	
	select.html("");
	
	if (recipients.length === 0) {
		select.prop("disabled", false);
		return;
	}
	
	let newOption;

	for (let i = 0; i < recipients.length; i++) {
		newOption = new Option(recipients[i].dataset.recipients, i, false, true);
		select.append(newOption).trigger('change');
	}

	select.prop("disabled", true);
});
