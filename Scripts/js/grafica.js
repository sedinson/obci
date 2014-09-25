uget = function(params) {
    return $.ajax({
        type: (params.type) ? params.type : 'GET',
        url: (params.url) ? params.url : '',
        data: (params.data) ? params.data : {},
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
};

function Grafica(container, container2, container3, container4, paises) {
    var _this = this;

    this.a_unico = function(ar) {

        var ya = false, v = "", aux = [].concat(ar), r = Array();

        for (var i in aux) { // 
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

    this.busqueda = function(data, pais) {
        var var_exp = [];
        var var_imp = [];
        var importado = [];
        var exportado = [];
        var myObject = [];
        for (var i = 0; i < data._response.length; i++) {
            for (var j = 0; j < data._response[i].length; j++) {
                if (data._response[i][j].nombre === pais) {
                    exportado.push(parseFloat(data._response[i][j].exportado));
                    importado.push(parseFloat(data._response[i][j].importado));
                    if (!isNaN(parseFloat(data._response[i][j].var_exp))) {
                        var_exp.push(parseFloat(data._response[i][j].var_exp));
                    } else {
                        var_exp.push(parseFloat(0));
                    }
                    if (!isNaN(parseFloat(data._response[i][j].var_imp))) {
                        var_imp.push(parseFloat(data._response[i][j].var_imp));
                    } else {
                        var_imp.push(parseFloat(0));
                    }

                }
            }

        }
        myObject.push({
            nombre: pais,
            exportado: exportado,
            importado: importado,
            var_exp: var_exp,
            var_imp: var_imp
        });
        return  myObject;
    };
    this.graficar = function(container, datos, name) {




        $(function() {
            if ($(container).length) {
                $(container).highcharts({
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: name
                    },
                    subtitle: {
                        text: 'Source: BD OBCI'
                    },
                    xAxis: {
                        categories: ['2010', '2011', '2012'],
                        title: {
                            text: 'año'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Exportación(millions)',
                            align: 'high'
                        },
                        labels: {
                            overflow: 'justify'
                        }
                    },
                    tooltip: {
                        valueSuffix: ' millions'
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: true
                            }
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0,
                        backgroundColor: '#FFFFFF',
                        shadow: true
                    },
                    credits: {
                        enabled: false
                    },
                    series: datos
                });
            }
        });

    };

    uget({
        type: 'GET',
        url: LinkServer.Url('grafica', 'aloha', {
            paises: paises
        })
    }).done(function(data) {
        if (data._code === 200) {
            //this.graficar(data._response);
            var ano = [];
            var nombre = Array();
            var var_exp = [];
            var var_imp = [];
            var importado = [];
            var exportado = [];
            var exportadoC = [];
            var myObject = [];

            for (var i = 0; i < data._response.length; i++) {
                for (var j = 0; j < data._response[i].length; j++) {
                    nombre.push(data._response[i][j].nombre);
                }
            }


            nombre = _this.a_unico(nombre);

            for (var j = 0; j < nombre.length; j++) {
                myObject.push(_this.busqueda(data, nombre[j]));
            }

            for (var j = 0; j < myObject.length; j++) {
                exportado[j] = {
                    name: myObject[j][0].nombre,
                    data: myObject[j][0].exportado
                };

                importado[j] = {
                    name: myObject[j][0].nombre,
                    data: myObject[j][0].importado
                };

                var_exp[j] = {
                    name: myObject[j][0].nombre,
                    data: myObject[j][0].var_exp
                };

                var_imp[j] = {
                    name: myObject[j][0].nombre,
                    data: myObject[j][0].var_imp
                };
            }

            _this.graficar(container, exportado, 'Exportado');
            _this.graficar(container2, importado, 'Importado');
            _this.graficar(container3, var_exp, 'Var Expo');
            _this.graficar(container4, var_imp, 'Var Impo');
        }
    });
}