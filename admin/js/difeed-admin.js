(function ($) {
	"use strict";

	$(document).ready(function () {
		$('input[name="daterange"]').daterangepicker(
			{
				autoApply: true,
				opens: "left",
				locale: {
					format: "DD/MM/YYYY",
					separator: " - ",
					fromLabel: "From",
					toLabel: "To",
				},
			},
			function (start, end, label) {
				console.log(
					"New date range selected: " +
						start.format("YYYY-MM-DD") +
						" to " +
						end.format("YYYY-MM-DD") +
						" (predefined range: " +
						label +
						")"
				);
			}
		);
	});

	jQuery(document).ready(function ($) {
		wp.codeEditor.initialize($("#fancy-textarea-post"), cm_settings);
		wp.codeEditor.initialize($("#fancy-textarea-hadith"), cm_settings);
		wp.codeEditor.initialize($("#fancy-textarea-ayah"), cm_settings);
		wp.codeEditor.initialize($("#fancy-textarea-names"), cm_settings);
	});
})(jQuery);
