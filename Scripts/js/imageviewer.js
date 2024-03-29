/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function imageviewer (array, container, durationTimmer, timmerTransition) {
    var timmerInterval = null, cont = 0;
    
    var exec = function (n) {
        //console.log(n);
    };
    
    container.append('<ul>');
    
    for(var element in array) {
        container.append('<li>' + array[element] + '</li>');
    }
    
    container.append('</ul>');
    
    container.find("li").css({
        display: 'block', 
        opacity: 1,
        position: 'absolute',
        'z-index': 0
    });
    
    container.find("li").eq(0).css({
        display: 'block', 
        opacity: 1,
        'z-index': 1
    });
    
    var display = function (n) {
        cont = n % array.length;
        exec(cont);
        
        container.find("li").css({
            'z-index': 0
        });
        
        for(var i=0; i<array.length; i++) {
            container.find("li").eq((cont+i+1) % array.length).css({
                'z-index': i
            });
        }
        
        container.find("li").eq(cont).css({
            opacity: 0
        });
        
        container.find("li").eq(cont).animate({opacity: 1}, timmerTransition);
    };
    
    var step = function (inc) {
        cont = ((cont+inc) < 0)? array.length-1 : (cont+inc)%array.length;
        display(cont);
    };
        
    var changeImage = function () {
        step(1);
        
        timmerInterval = setTimeout(changeImage, durationTimmer);
    };
    
    this.prev = function () {
        clearInterval(timmerInterval);
        step(-1);
        
        timmerInterval = setTimeout(changeImage, durationTimmer);
    };
    
    this.next = function () {
        clearInterval(timmerInterval);
        step(1);
        
        timmerInterval = setTimeout(changeImage, durationTimmer);
    };
    
    this.goTo = function (n) {
        clearInterval(timmerInterval);
        display(n);
        
        timmerInterval = setTimeout(changeImage, durationTimmer);
    };
    
    this.onChange = function (func) {
        exec = func;
    };
    
    timmerInterval = setTimeout(changeImage, durationTimmer);
};