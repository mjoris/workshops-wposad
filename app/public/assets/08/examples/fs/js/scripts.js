/*
 * Main scripts
 *
 * @author Rogier van der Linde <rogier@bitmatters.be>
 */

;(function() {
	'use strict';

	// wait till DOM is loaded
	window.addEventListener('load', function() {
		// disable HTML5 form validation
		document.getElementById('form1').setAttribute('novalidate', 'novalidate');

		// intercept document submit
		document.getElementById('form1').addEventListener('submit', function(e) {
			// halt event
			e.preventDefault();
			e.stopPropagation();

			// form checking
			var isValid = true;

			// error messages shortcuts
			var errStreet = document.getElementById('errStreet');
			var errZip = document.getElementById('errZip');
			var errCity = document.getElementById('errCity');

			// input shortcuts
			var qstStreet = document.getElementById('qstStreet');
			var qstZip = document.getElementById('qstZip');
			var qstCity = document.getElementById('qstCity');

			// hide all error messages
			var errMessages = document.querySelectorAll('.message--error');
			for (var i = 0; i < errMessages.length; i++) {
				errMessages[i].style.display = 'none';
			}

			// check street and number
			if (qstStreet.value == '') {
				isValid = false;
				errStreet.innerHTML = 'gelieve een straat en nummer in te vullen';
				errStreet.style.display = 'block';
			}

			// check zip
			if (qstZip.value == '') {
				isValid = false;
				errZip.innerHTML = 'gelieve een postcode in te vullen';
				errZip.style.display = 'block';
			}

			// check city
			if (qstCity.value == '') {
				isValid = false;
				errCity.innerHTML = 'gelieve een gemeente in te vullen';
				errCity.style.display = 'block';
			}

			// draw conclusion
			if (isValid) {
				console.log('all ok');
			} else {
				console.log('form contains errors');
			}

		});
	});

})();
