/*
 * Page-specific scripts
 *
 * @author Rogier van der Linde <rogier.vanderlinde@odisee.be>
 */

	/**
	* Sets the mood image
	*/
	const setMood = function(nr) {
		// check boundaries
		if (nr < 0) nr = 0;
		if (nr > 5) nr = 5;

		// adjust image
		document.getElementById("imgMood").src = "img/mood" + nr + ".gif";
	}

	// start scripts
	window.addEventListener('DOMContentLoaded', function() {
		document.getElementById("selMood").addEventListener('change', function() {
			setMood(this.value);
		});
	});
