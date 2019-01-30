/**
 * Vendo Shopping Engine
 *
 * @author    Vendo.ma S.A.R.L
 * @copyright Vendo.ma - All Rights reserved
 * @license   LICENSE.txt
 * @version 1.0.7
 *
 */


var copy = document.querySelector('#copyTxt');


copy.addEventListener('click', function(){
    var token = document.querySelector('#tokenTxt');
    var t = document.createElement('textarea');
    t.id = 't';
    t.style.height = 0;
    document.body.appendChild(t)
    t.value = token.innerText;
    var text = document.querySelector('#t');
    text.select();
    token.classList.add('pulse');
    setTimeout(function(){
        token.classList.remove('pulse');
    },700)
    document.execCommand('copy');
    document.body.removeChild(t);
})