
(function($) {
    "use strict";

    /*================================
    Preloader
    ==================================*/

    var preloader = $('#preloader');
    $(window).on('load', function() {
        preloader.fadeOut('slow', function() { $(this).remove(); });
    });

    /*================================
    sidebar collapsing
    ==================================*/
    $('.nav-btn').on('click', function() {
        $('.page-container').toggleClass('sbar_collapsed');
    });

    /*================================
    sidebar menu
    ==================================*/
    $("#menu").metisMenu();

    /*================================
    slimscroll activation
    ==================================*/
    /*$('.menu-inner').slimScroll({
        height: 'auto'
    });*/
   /*================================
    form bootstrap validation
    ==================================*/
	/*------------- Start form Validation -------------*/
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);

    /*================================
    datatable active
    ==================================*/
    if ($('#didtable').length) {
        $('#didtable').DataTable({
            responsive: true
        });
    }
	if ($('#didtableblock').length) {
        $('#didtableblock').DataTable({
            responsive: true
        });
    }
	if($('#recordingtable').length){
		let table = $('#recordingtable').DataTable({
			'columnDefs': [{
			 'targets': 0,
			 'searchable': false,
			 'orderable': false,
			 'className': 'dt-body-center'
		  }],
			'order': [[1, 'asc']],
            'responsive': true
        });
		// Handle click on "Select all" control
		$('#select-all').on('click', function(){
		   // Get all rows with search applied
		   var rows = table.rows({ 'search': 'applied' }).nodes();
		   // Check/uncheck checkboxes for all rows in the table
		   $('input[type="checkbox"]', rows).prop('checked', this.checked);
		});
		// Handle click on checkbox to set state of "Select all" control
		$('#recordingtable tbody').on('change', 'input[type="checkbox"]', function(){
		   // If checkbox is not checked
		   if(!this.checked){
			  var el = $('#select-all').get(0);
			  // If "Select all" control is checked and has 'indeterminate' property
			  if(el && el.checked && ('indeterminate' in el)){
				 // Set visual state of "Select all" control
				 // as 'indeterminate'
				 el.indeterminate = true;
			  }
		   }
		});
	}
   /*================================
    login form
    ==================================*/
    $('.form-gp input').on('focus', function() {
        $(this).parent('.form-gp').addClass('focused');
    });
    $('.form-gp input').on('focusout', function() {
        if ($(this).val().length === 0) {
            $(this).parent('.form-gp').removeClass('focused');
        }
    });
})(jQuery);