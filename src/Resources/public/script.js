var ContaoFlash = ContaoFlash || {};

ContaoFlash.clearMessages = function(){
    if(!this.clear) return;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'flash/clear?ids=' + this.clear.join(','));
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send();
}

ContaoFlash.registerEventHandlers = function(){
    var elements = document.querySelectorAll('.mod_flash_messages .flash-message');
    if(!elements.length) return;
    elements.forEach(function(el){
        var close = el.querySelector('.flash-dismiss');
        close.addEventListener('click', function(e){
            e.preventDefault();
            var xhr = new XMLHttpRequest();
            xhr.open('GET', this.href);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.send();
            el.parentNode.removeChild(el);
        });
    });
}

document.addEventListener('DOMContentLoaded', function(){
    ContaoFlash.registerEventHandlers();
    setTimeout(function(){
        ContaoFlash.clearMessages();
    }, 2000);
});

