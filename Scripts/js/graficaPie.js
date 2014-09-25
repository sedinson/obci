function Grafica5(container, dept, indicador, ano, titulo) {
    var _this = this;

    this.organizar_json_balanza = function(data, nombre)
    {
        var myObject = [];
        var sum = 0;
        var total = 100;
        var datos = [];
        for (var i = 0; i < data._response.length; i++)
        {
            var valor = [];
            valor.push(data._response[i].nombre);
            valor.push(parseFloat(data._response[i].valor));
            sum = sum + parseFloat(data._response[i].valor);
            datos.push(valor);
            //valor.splice(0,valor.length);
        }
        var valor = [];
        valor.push('Resto del Mundo');
        valor.push(total - sum);
        datos.push(valor);

        return datos;
    };

    this.graficarPuntos = function(container, datos, años, fuente) {

        $(function() {
            var chart;

            $(document).ready(function() {
                if ($(container).length) {
                    $(container).highcharts({
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false
                        },
                        title: {
                            text: 'Fuente: ' + titulo
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
//                pie: {
//                    allowPointSelect: true,
//                    cursor: 'pointer',
//                    dataLabels: {
//                        enabled: false
//                    },
//                    showInLegend: true
//                },
                            series: {
                                events: {
                                    legendItemClick: function(event) {
                                        var visibility = this.visible ? 'visible' : 'hidden';
                                        if (!confirm('The series is currently ' +
                                                visibility + '. Do you want to change that?')) {
                                            return false;
                                        }
                                    }
                                }
                            }
                        },
                        series: [{
                                type: 'pie',
                                name: 'Expo Caribe',
                                data: datos
                            }]
                    });
                }
            });

        });

    };

    this.cargar_data = function(data)
    {
        if (data._code === 200)
        {
            var nombre = [];
            var myObject = [];

            myObject = _this.organizar_json_balanza(data, nombre);
            _this.graficarPuntos(container, myObject, 'name_ejey', ano);
        }
    };

    uget({
        type: 'GET',
        url: LinkServer.Url('grafica', indicador, {
            dept: dept
        })
    }).done(function(data) {
        if (data._response.length > 0) {
            _this.cargar_data(data);
        } else {
            alert('No hay datos que graficar.');
        }
    });

}