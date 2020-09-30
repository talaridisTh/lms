//!##########################################
//!				Global Variables			#
//!##########################################

let timer = 0;

//!##########################################
//!				EventListerners				#
//!##########################################

$(".js-global-search").on("input", function() {

	clearTimeout(timer);
	if ( this.value.length >= 3) {
		timer = setTimeout( search, 800, this.value);
	}
	else {

		let coverText = `<div class="row mx-0">
				<span class="py-2 d-block text-center mx-auto font-16">
					<i class="mdi mdi-magnify mr-1"></i>
					<u>3 Characters or more</u>
				</span>
			</div>`;

		$("#search-dropdown").html(coverText);
	}

});

//!##############################################
//!					Functions					#
//!##############################################

function search(value) {
	
	axios.post("/dashboard-search", {
		value
	})
	.then( res => {

		$("#search-dropdown").html(res.data);
	})
	.catch( err => {
		console.log(err);
	})
}