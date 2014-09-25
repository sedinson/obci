function graficaFlujos(container, pais) {
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
                        text: 'Fuente: Elaboración OBCI con base en DIAN',
                        x: -20
                    },
                    xAxis: {
                        categories: años
                    },
                    yAxis: {
                        title: {
                            text: 'Dólares'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                    },
                    legend: {
                        verticalAlign: 'bottom',
                        borderWidth: 0
                    },
                    series: datos
                });
            }
        });
    };

    uget({
        type: 'GET',
        url: LinkServer.Url('grafica', 'datosmapapais', {
            dept: encodeURIComponent(pais)
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

            // $('#txt').html('<p><b>Exportado: </b>' + myObject[0].expo[myObject[0].expo.length - 1] + '</p><p><b>Importado: </b>' + myObject[0].impo[myObject[0].impo.length - 1] + '</p>');
            _this.graficarLinea(container, datos, 'Exportado- Importado', 'y', ano);
        }
    });
}