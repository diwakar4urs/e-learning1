

<script>

	function showConfirmation() {

	swal({

		  title: "{{getPhrase('are_you_sure')}}?",

		  text: "{{getPhrase('you_will_not_be_able_to_recover_this_record')}}!",

		  type: "warning",

		  showCancelButton: true,

		  confirmButtonClass: "btn-danger",

		  confirmButtonText: "{{getPhrase('yes').', '.getPhrase('delete_it')}}!",

		  cancelButtonText: "{{getPhrase('no').', '.getPhrase('cancel_please')}}!",

		  closeOnConfirm: false,

		  closeOnCancel: false

		},

		function(isConfirm) {

		  if (isConfirm) { 
		  	return true;


		  } else {

		    swal("{{getPhrase('cancelled')}}", "{{getPhrase('your_record_is_safe')}} :)", "error");
		    return false;

		  }

	});

	}

</script>