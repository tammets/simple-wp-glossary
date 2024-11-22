jQuery(document).ready(function ($) {
    $(".glossary-term").hover(
        function () {
            let $this = $(this);
            if (!$this.find(".glossary-term-popup").length) {
                let title = $this.data("term-title");
                let desc = $this.data("term-desc");
                let popup = `
                    <div class="glossary-term-popup">
                        <strong>${title}</strong>
                        <p>${desc}</p>
                    </div>
                `;
                $this.append(popup);
            }
        },
        function () {
            $(this).find(".glossary-term-popup").remove();
        }
    );
});