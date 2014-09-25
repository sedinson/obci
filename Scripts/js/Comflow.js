/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var Comflow = function (isadmin, cnv, zin, zout, f, g) {
    if(!f) {
        f = function (x, y) { };
    }
    
    if(!g) {
        g = function (e, i) { };
    }
    
    var z = 0.91,           //Zoom * n
        minz = 0.25,        //Zoom minimo
        maxz = 4,           //Maximo Zoom
        px = 0,             //Posicion X 
        py = 0,             //Posicion Y
        cx = 0,             //Copia de posicion X (Start)
        cy = 0,             //Copia de posicion Y (Start)
        tx = 0,             //Temporal donde esta el mouse X (Start)
        ty = 0,             //Temporal donde esta el mouse Y (Start)
        pressed = false,    //Si esta presionado el clic
        moved = false,      //Si se mueve el escenario
        refresh = true,     //Refrescar la pintada del mapa
        first = true,       //Primera vez que se entra a pintar (Red. Mapa)
        w = 0,              //Ancho de la imagen mapa
        h = 0,              //Alto de la imagen mapa
        rx = -15,           //Registro de clic en x
        ry = -15,           //Registro de clic en y
        data = [],          //Datos para graficar
        avg = [],           //Promedio de la suma de importacion y exportacion
        MIN_VALUE = 0,      //Valor minimo dentro de los datos
        MAX_VALUE = 0,      //Valor maximo dentro de los datos
        ew = [];            //Tamaño de las elipses
    
    var map = new GCanvas(cnv, 600, 400, {
        map: {
            Loading: function (p) {
                console.log("Loading... " + (p*100) + "%");
            }, Setup: function () {
                Images.setBase('/obci/Resource/imgs/');
                Images.add('ellipse0', 'ellipse0.png');
                Images.add('ellipse1', 'ellipse1.png');
                Images.add('ellipse2', 'ellipse2.png');
                Images.add('localizator', 'localizator.png');
                Images.add('mapa', 'mapa.jpg');
            }, Step: function () {
                if(first) {
                    var dim = Images.dim('mapa'),
                        uw = document.getElementById(cnv).width;
                    w = dim.width; 
                    h = dim.height;
                    
                    for(var i=0; i<3; i++) {
                        var tmp = Images.dim('ellipse' + i);
                        ew[i] = tmp.width;
                    }
                    
                    z = uw / w;
                    first = false;
                }
            }, Draw: function (g) {
                if(refresh) {
                    g.drawImage(Images.get('mapa'), 0, 0, w, h, px, py, w*z, h*z);

                    for(var i=0; i<data.length; i++) {
                        var std = avg[i] - MIN_VALUE,                   //Standar Data
                            step = (MAX_VALUE - MIN_VALUE) / 2,         //Size of step every 3 elements
                            j = Math.round(std/step);
                            
                        g.drawImage(Images.get('ellipse' + j), data[i].px*z+px-ew[j]/2, data[i].py*z+py-ew[j]/2);
                    }

                    if(isadmin) {
                        g.drawImage(Images.get('localizator'), rx*z+px-15, ry*z+py-15);
                    }
                    
                    refresh = false;
                }
            }, Start: function (x, y) {
                pressed = true;
                cx = px;
                cy = py;
                tx = x;
                ty = y;
                
                if(ismobile) {
                    for(var i=0; i<data.length; i++) {
                        var std = avg[i] - MIN_VALUE,                   //Standar Data
                            step = (MAX_VALUE - MIN_VALUE) / 2,         //Size of step every 3 elements
                            j = Math.round(std/step);
                        
                        if(Math.sqrt(Math.pow(data[i].px*z+px-x, 2) + Math.pow(data[i].py*z+py-y, 2)) < ew[j]) {
                            g(data[i], i);
                        }
                    }
                }
            }, Moving: function (x, y) {
                if(pressed) {
                    px = (x-tx > 0)? Math.min(cx+x-tx, 0) : Math.max(cx+x-tx, map.W-w*z);
                    py = (y-ty > 0)? Math.min(cy+y-ty, 0) : Math.max(cy+y-ty, map.H-h*z);
                    refresh = true;
                    moved = true;
                }
                
                $("#" + cnv).css({
                    cursor: 'default'
                });
                
                for(var i=0; i<data.length; i++) {
                    var std = avg[i] - MIN_VALUE,                   //Standar Data
                        step = (MAX_VALUE - MIN_VALUE) / 2,         //Size of step every 3 elements
                        j = Math.round(std/step);
                    
                    if(Math.sqrt(Math.pow(data[i].px*z+px-x, 2) + Math.pow(data[i].py*z+py-y, 2)) < ew[j]/2) {
                        $("#" + cnv).css({
                            cursor: 'pointer'
                        });
                    }
                }
            }, End: function (x, y) {
                pressed = false;
                if(isadmin && !moved) {
                    rx = (-px+x)*(1/z);
                    ry = (-py+y)*(1/z);
                }
                
                if(!moved) {
                    for(var i=0; i<data.length; i++) {
                        var std = avg[i] - MIN_VALUE,                   //Standar Data
                            step = (MAX_VALUE - MIN_VALUE) / 2,         //Size of step every 3 elements
                            j = Math.round(std/step);
                        
                        if(Math.sqrt(Math.pow(data[i].px*z+px-x, 2) + Math.pow(data[i].py*z+py-y, 2)) < ew[j]) {
                            g(data[i], i);
                        }
                    }
                }
                
                f(x, y, rx, ry);
                refresh = true;
                moved = false;
            }
        }
    }, 'map');
    
    this.resize = function (width, height) {
        map.resize(width, height);
        refresh = true;
    };
    
    this.setData = function (_data) {
        data = _data;
        avg = [];
        for(var i=0; i<data.length; i++) {
            avg[i] = (Number(data[i].importado) + Number(data[i].exportado)) / 200000;
        }
        
        MIN_VALUE = Math.min.apply(null, avg);
        MAX_VALUE = Math.max.apply(null, avg);
        refresh = true;
    };
    
    $(zin).click(function (e) {
        e.preventDefault();
        z = Math.min(maxz, z+0.25);
        refresh = true;
    });
    
    $(zout).click(function (e) {
        e.preventDefault();
        z = Math.max(minz, z-0.25);
        refresh = true;
    });
};
