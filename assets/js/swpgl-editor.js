(function ($) {
    // Ensure the script runs only after TinyMCE is available
    function addGlossaryButtonToTinyMCE() {
        if (typeof tinymce !== 'undefined') {
            tinymce.PluginManager.add('swpgl_plugin', function (editor, url) {
                editor.addButton('swpgl_button', {
                    text: 'Glossary',
                    icon: false,
                    onclick: function () {
                        // Fetch glossary terms via AJAX
                        $.post(
                            ajaxurl,
                            { action: 'swpgl_get_glossary_terms' },
                            function (response) {
                                if (response.success) {
                                    let terms = response.data;

                                    // Build HTML for a dropdown
                                    let dropdownHtml = '<select id="glossary-term-select">';
                                    dropdownHtml += '<option value="">Select a Glossary Term</option>';
                                    terms.forEach(function (term) {
                                        dropdownHtml += `<option value="${term.id}">${term.title}</option>`;
                                    });
                                    dropdownHtml += '</select>';

                                    editor.windowManager.open({
                                        title: 'Insert Glossary Term',
                                        body: [
                                            {
                                                type: 'container',
                                                html: dropdownHtml,
                                            },
                                        ],
                                        onsubmit: function () {
                                            const termId = $('#glossary-term-select').val();
                                            if (termId) {
                                                editor.insertContent(
                                                    `[glossary_hover id="${termId}"]Your text here[/glossary_hover]`
                                                );
                                            }
                                        },
                                    });
                                } else {
                                    alert('No glossary terms available.');
                                }
                            }
                        );
                    },
                });
            });
        } else {
            // Retry after a delay if TinyMCE is not yet loaded
            setTimeout(addGlossaryButtonToTinyMCE, 100);
        }
    }

    // Run the function to add the button
    addGlossaryButtonToTinyMCE();
})(jQuery);