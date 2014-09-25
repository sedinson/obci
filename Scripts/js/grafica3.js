function Grafica3(container, container2, nombres, indicador, title, unidad, fuente)
{
    var _this = this;

    //Obtiene los nombres de los paises, departamentos, etc
    this.eliminar_repetidos = function(ar) {

        var ya = false, v = "", aux = [].concat(ar), r = Array();

        for (var i in aux) {
            v = aux[i];
            ya = false;
            for (var a in aux) {
                if (v == aux[a]) {
                    if (ya == false) {
                        ya = true;
                    }
                    else {
                        aux[a] = "";
                    }
                }
            }
        }
        for (var a in aux) {
            if (aux[a] != "") {
                r.push(aux[a]);
            }
        }
        //Retornamos el Array creado 
        return r;
    };

    this.organizar_json_expoimpo = function(data, nombre)
    {
        var myObject = [];
        var valor = [];
        for (var i = 0; i < data._response.length; i++)
        {
            if (data._response[i].nombre === nombre) {
                valor.push(parseFloat(data._response[i].valor));
            }
        }
        myObject.push({
            name: nombre,
            data: valor
        });
        return myObject;
    };

    this.graficarBarra = function(container, datos, title, name_ejey, años) {

        $(function() {
            if ($(container).length) {
                $(container).highcharts({
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: title
                    },
                    subtitle: {
                        text: 'Fuente: ' + fuente
                    },
                    xAxis: {
                        categories: años,
                        title: {
                            text: 'año'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: name_ejey,
                            align: 'high'
                        },
                        labels: {
                            overflow: 'justify'
                        }
                    },
                    tooltip: {
                        valueSuffix: ''
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: false
                            }
                        }
                    },
                    legend: {
                        backgroundColor: '#FFFFFF',
                        reversed: true
                    },
                    credits: {
                        enabled: false
                    },
                    series: datos
                });
            }
        });

    };

    this.graficarLinea = function(container, datos, title, name_ejey, años)
    {
        $(function() {
            if ($(container).length) {
                $(container).highcharts({
                    title: {
                        text: title,
                        x: -20 //center
                    },
                    subtitle: {
                        text: 'Fuente: ' + fuente,
                        x: -20
                    },
                    xAxis: {
                        categories: años
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
            }
        });
    };

    this.cargar_data = function(data) {
        if (data._code === 200) {
            var nombre = [];
            var myObject = [];
            var ano = [];

            for (var i = 0; i < data._response.length; i++) {
                nombre.push(data._response[i].nombre);
                ano.push(data._response[i].ano);
            }

            nombre = _this.eliminar_repetidos(nombre);
            ano = _this.eliminar_repetidos(ano);

            for (var j = 0; j < nombre.length; j++) {
                myObject.push(_this.organizar_json_expoimpo(data, nombre[j]));
            }

            var datos_grafica = [];

            for (var j = 0; j < myObject.length; j++) {
                datos_grafica[j] = {
                    name: myObject[j][0].name,
                    data: myObject[j][0].data
                };
            }

            _this.graficarBarra(container, datos_grafica, title, unidad, ano);
            _this.graficarLinea(container2, datos_grafica, title, unidad, ano);
        }
    };

    uget({
        type: 'GET',
        url: LinkServer.Url('grafica', indicador, {
            dept: nombres
        })
    }).done(function(data) {
        if (data._response.length > 0) {
            _this.cargar_data(data);
        } else {
            alert('No hay datos que graficar.');
        }
    });
}