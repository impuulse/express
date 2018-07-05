$(function(){
    $(document).on('click', '.showModalButton', function() {
        var modal = $('#modal');
        modal.modal('show').find('#mContent').load($(this).attr('value'));
    });
});