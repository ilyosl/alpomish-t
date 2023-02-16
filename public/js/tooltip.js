$(function (){
    var title =
    tippy('.alp-path', {
        content(reference) {
            const id = reference.getAttribute('data-template');
            const template = $(this);
            return template.innerHTML;
        },
    });
})


