String.prototype.capitalize = function(){
    return this.replace( /(^|\s)([a-z])/g , function(m,p1,p2){ return p1+p2.toUpperCase(); } );
};

var device = navigator.userAgent;
var lat,lng,z;
    if (device.match(/Iphone/i)|| device.match(/Ipod/i)|| device.match(/Android/i)|| device.match(/J2ME/i)|| device.match(/HTC/i)) {

    //alert('Navegador movil');
    lat= '3.8204080831949407';
    lng = '-72.7734375';
    z = 4;
    }
    else if (device.match(/Ipad/i))
    {
    //alert('iPad');
    lat= '3.8204080831949407';
    lng = '-72.7734375';
    z = 4;
    } else {
    //alert('PC/Laptop/Mac');
    lat= '3.8204080831949407';
    lng = '-72.7734375';
    z = 4;
    }
    function mapa(container, container2) {

    var _this = this;
    this.organizar_json_expoimpo = function(data)
    {
        var myObject = [];
        var valorExp = [];
        var valorImp = [];
        var ano = [];
        for (var i = 0; i < data._response.length; i++)
        {
            valorExp.push(parseFloat(data._response[i].exportado));
            valorImp.push(parseFloat(data._response[i].importado));
            ano.push(data._response[i].ano);

        }
        myObject.push({
            expo: valorExp,
            impo: valorImp,
            ano: ano
        });
        return myObject;
    };

    this.graficarLinea = function(container, datos, title, name_ejey, anos, fuente)
    {
        $(function() {
            $(container).highcharts({
                title: {
                    text: title,
                    x: -20 //center
                },
                subtitle: {
                    text: fuente,
                    x: -20
                },
                xAxis: {
                    categories: anos
                },
                yAxis: {
                    title: {
                        text: name_ejey
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                legend: {
                    backgroundColor: '#FFFFFF',
                   reversed: true
                },
                series: datos
            });
        });
    };

    //Aqui haces la carga del mapa (crear mapa)
    var mapOptions = {
        center: new google.maps.LatLng(lat,lng),
        zoom: z,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: true,
        mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
        navigationControl: true,
        navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL}
    };

    var map = new google.maps.Map(document.getElementById(container), mapOptions);

    var markers = new Array();

    var addMarker = function(marker) {
        //this.markers[this.markers.length] = marker;
        markers.push(marker);
    };

    var newMarker = function(m, _map) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(m.latitud, m.longitud),
            map: _map,
            title: m.nombre,
            icon: LinkPage.Absolute('Resource/imgs/' + m.tipo + '.png')
        });

        google.maps.event.addListener(marker, 'click', function() {
            $("body, html").animate({
                scrollTop: $(window).height()-220
            }, 500);

            $('#titulo').html(m.tipo.capitalize() + ' ' + marker.title);
            uget({
                type: 'GET',
                url: LinkServer.Url('grafica', 'datos_zf_pt', {
                    nombre: encodeURIComponent(marker.title),
                    tipo: encodeURIComponent(m.tipo)
                })
            }).done(function(data) {

                if (data._code === 200) {
                    var ano = [];
                    for (var i = 0; i < data._response.length; i++) {
                        ano.push(data._response[i].ano);
                    }
                    var myObject = [];
                    myObject = _this.organizar_json_expoimpo(data);
                    var datos = [];

                    datos[0] = {
                        name: 'Exportado',
                        data: myObject[0].expo
                    };

                    datos[1] = {
                        name: 'Importado',
                        data: myObject[0].impo
                    };

                    $('#txt').html('<p><b>Exportado: </b>' + myObject[0].expo[myObject[0].expo.length - 1] + '</p><p><b>Importado: </b>' + myObject[0].impo[myObject[0].impo.length - 1] + '</p>');
                    
                    if(m.tipo === 'zona franca'){
                        _this.graficarLinea(container2, datos, 'Importacion-Exportacion '+ marker.title, 'Miles de dólares', ano,'Fuente: Elaboración OBCI con base en DANE.');
                    }else{
                        _this.graficarLinea(container2, datos, 'Importacion-Exportacion '+ marker.title, 'Toneladas', ano,'Fuente: Elaboración OBCI con base en Superintendencia de Puetros y Transporte.');
                    }
                    
                }
            });

        });

        addMarker({
            marker: marker,
            tipo: m.tipo
        });
    };

    //Cargar todos los puntos de Zona Franca
    uget({
        type: 'GET',
        url: LinkServer.Url('zonafranca', 'posiciones', {
            tipo: encodeURIComponent('zona franca')
        })
    }).done(function(data) {
        if (data._code === 200) {
            for (var i = 0; i < data._response.length; i++) {
                newMarker(data._response[i], map);
            }
        }
    });

    //Cargar todos los puntos de Puerto
    uget({
        type: 'GET',
        url: LinkServer.Url('zonafranca', 'posiciones', {
            tipo: encodeURIComponent('puerto')
        })
    }).done(function(data) {
        if (data._code === 200) {
            for (var i = 0; i < data._response.length; i++) {
                newMarker(data._response[i], map);
            }
        }
    });

    this.mostrar_puntos = function(tipo) {
        for (var i = 0; i < markers.length; i++) {
            if (markers[i].tipo === tipo) {
                markers[i].marker.setMap(map);
            }
        }
    };

    this.ocultar_puntos = function(tipo) {
        for (var i = 0; i < markers.length; i++) {
            if (markers[i].tipo === tipo) {
                markers[i].marker.setMap(null);
            }
        }
    };
}
