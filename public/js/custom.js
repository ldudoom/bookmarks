$('.favorite').on('click', function(e){
    e.preventDefault();
    const favorite = $(this);
    const url = favorite.data('url');
    $.get(url).done(function(resp){
        alert(resp.message);
        favorite.removeClass('btn-success');
        favorite.removeClass('btn-outline-success');
        favorite.addClass(resp.newClass);
    }).fail(function(){
        alert('Error');
    });
});