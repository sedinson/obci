function Grafica4(container, pais, indicador, ano, titulo, fuenteo, ejex) {
    var _this = this;

    this.organizar_json_balanza = function(data, nombre)
    {
        var myObject = [];

        var datos = [];
        for (var i = 0; i < data._response.length; i++)
        {
            var valor = [];
            valor.push(parseFloat(data._response[i].valor1));
            valor.push(parseFloat(data._response[i].valor2));
            datos.push(valor);
            //valor.splice(0,valor.length);
        }

        return datos;
    };

    this.graficarPuntos = function(container, datos, años, fuente) {

        $(function() {
            if ($(container).length) {
                $(container).highcharts({
                    chart: {
                        type: 'scatter',
                        zoomType: 'xy'
                    },
                    title: {
                        text: pais + ' ' + ano
                    },
                    subtitle: {
                        text: 'Fuente: ' + fuenteo
                    },
                    xAxis: {
                        title: {
                            enabled: true,
                            text: ejex

                        },
                        startOnTick: true,
                        endOnTick: true,
                        showLastLabel: true
                    },
                    yAxis: {
                        title: {
                            text: titulo
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'left',
                        verticalAlign: 'top',
                        x: 100,
                        y: 70,
                        maxHeight: 60,
                        floating: true,
                        backgroundColor: '#FFFFFF',
                        borderWidth: 1
                    },
                    plotOptions: {
                        scatter: {
                            marker: {
                                radius: 5,
                                states: {
                                    hover: {
                                        enabled: true,
                                        lineColor: 'rgb(100,100,100)'
                                    }
                                }
                            },
                            states: {
                                hover: {
                                    marker: {
                                        enabled: false
                                    }
                                }
                            },
                            tooltip: {
                                headerFormat: '<b>{series.name}</b><br>',
                                pointFormat: '{point.x}, {point.y}'
                            }
                        }
                    },
                    series: [{
                            name: pais + ' ' + ano,
                            data: datos

                        }]
                });
            }
        });

    };

    this.cargar_data = function(data)
    {
        if (data._code === 200)
        {
            var nombre = [];
            var myObject = [];

            myObject = _this.organizar_json_balanza(data, nombre);
            console.log(myObject);


            _this.graficarPuntos(container, myObject, 'name_ejey', ano);
        }
    };

    uget({
        type: 'GET',
        url: LinkServer.Url('grafica', indicador, {
            pais: pais,
            ano: ano

        })
    }).done(function(data) {
        if (data._response.length > 0) {
            _this.cargar_data(data);
        } else {
            alert('No hay datos que graficar.');
        }
    });

}